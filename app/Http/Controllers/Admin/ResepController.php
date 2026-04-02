<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\Kategori;
use App\Models\Bahan;
use App\Models\Langkah;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ResepController extends Controller
{
    /**
     * LIST SEMUA RESEP + SEARCH + FILTER + SORT
     */
    public function index(Request $request)
    {
        $query = Resep::query()->with(['user', 'kategori']);

        // 🔥 AVG RATING & JUMLAH RATING
        $query->withAvg('interaksi as avg_rating', 'rating');
        $query->withCount([
            'interaksi as rating_count' => function ($q) {
                $q->whereNotNull('rating');
            }
        ]);

        // 1. SEARCH
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // 2. FILTER KATEGORI
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // 3. FILTER WAKTU MASAK
        if ($request->filled('waktu')) {
            switch ($request->waktu) {
                case 'kilat': $query->where('waktu_masak', '<=', 15); break;
                case 'sedang': $query->whereBetween('waktu_masak', [16, 45]); break;
                case 'lama': $query->where('waktu_masak', '>', 45); break;
            }
        }

        // 4. FILTER STATUS (Tambahan agar admin bisa filter mana yang pending)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 5. FILTER RATING
        if ($request->filled('rating_min')) {
            $query->having('avg_rating', '>=', $request->rating_min);
        }

        // 6. SORTING
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'terbaru': $query->orderBy('created_at', 'desc'); break;
                case 'terlama': $query->orderBy('created_at', 'asc'); break;
                case 'rating_tertinggi': $query->orderByDesc('avg_rating'); break;
                case 'judul_az': $query->orderBy('judul', 'asc'); break;
                case 'judul_za': $query->orderBy('judul', 'desc'); break;
                default: $query->orderBy('created_at', 'desc'); break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $resep = $query->paginate(10)->appends($request->query());
        $kategoris = Kategori::all();

        return view('admin.resep.index', compact('resep', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.resep.create', compact('kategoris'));
    }

    /**
     * SIMPAN RESEP (Admin Side)
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'required',
            'waktu_masak'     => 'nullable|integer|min:1',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kategori_id'     => 'required|array',
            'bahan.*'         => 'required',
            'jumlah.*'        => 'required',
            'langkah.*'       => 'required',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('resep', 'public');
        }

        // Simpan Resep - OTOMATIS APPROVED karena diinput Admin
        $resep = Resep::create([
            'user_id'         => auth()->id(),
            'judul'           => $request->judul,
            'deskripsi'       => $request->deskripsi,
            'waktu_masak'     => $request->waktu_masak,
            'tanggal_publish' => now(), 
            'foto'            => $fotoPath,
            'status'          => 'approved', 
        ]);

        // Simpan Bahan
        foreach ($request->bahan as $i => $b) {
            Bahan::create([
                'resep_id'   => $resep->id,
                'nama_bahan' => $b,
                'jumlah'     => $request->jumlah[$i],
            ]);
        }

        // Simpan Langkah
        foreach ($request->langkah as $i => $l) {
            Langkah::create([
                'resep_id'          => $resep->id,
                'nomor_langkah'     => $i + 1,
                'deskripsi_langkah' => $l,
            ]);
        }

        $resep->kategori()->attach($request->kategori_id);

        return redirect()->route('admin.resep.index')->with('success', 'Resep berhasil diterbitkan');
    }

    public function show($id)
    {
        $resep = Resep::with(['user', 'bahan', 'langkah', 'kategori', 'interaksi.user'])
            ->withAvg('interaksi as avg_rating', 'rating')
            ->withCount([
                'interaksi as rating_count' => fn($q) => $q->whereNotNull('rating'),
                'interaksi as saved_count'  => fn($q) => $q->where('simpan_resep', true),
            ])
            ->findOrFail($id);

        return view('admin.resep.show', compact('resep'));
    }

    public function edit($id)
    {
        $resep = Resep::with(['bahan', 'langkah', 'kategori'])->findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.resep.edit', compact('resep', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required',
            'kategori_id' => 'required|array',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $resep = Resep::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($resep->foto) { Storage::disk('public')->delete($resep->foto); }
            $resep->foto = $request->file('foto')->store('resep', 'public');
        }

        $resep->update([
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'waktu_masak' => $request->waktu_masak,
            'foto'        => $resep->foto,
        ]);

        $resep->kategori()->sync($request->kategori_id);

        // Reset & Re-insert Bahan/Langkah
        Bahan::where('resep_id', $resep->id)->delete();
        Langkah::where('resep_id', $resep->id)->delete();

        foreach ($request->bahan as $i => $b) {
            Bahan::create(['resep_id' => $resep->id, 'nama_bahan' => $b, 'jumlah' => $request->jumlah[$i]]);
        }

        foreach ($request->langkah as $i => $l) {
            Langkah::create(['resep_id' => $resep->id, 'nomor_langkah' => $i + 1, 'deskripsi_langkah' => $l]);
        }

        return redirect()->route('admin.resep.index')->with('success', 'Resep berhasil diperbarui');
    }

    public function destroy($id)
    {
        $resep = Resep::findOrFail($id);
        if ($resep->foto) { Storage::disk('public')->delete($resep->foto); }
        $resep->delete();
        return back()->with('success', 'Resep berhasil dihapus');
    }

    /**
     * MODERASI: APPROVE
     */
    public function approve($id)    
    {
        $resep = Resep::findOrFail($id);
        $resep->update([
            'status' => 'approved',
            'tanggal_publish' => now()
        ]);

        return redirect()->route('admin.resep.index')->with('success', 'Resep "' . $resep->judul . '" telah diterbitkan!');
    }

    /**
     * MODERASI: REJECT
     */
    public function reject($id)
    {
        $resep = Resep::findOrFail($id);
        $resep->update(['status' => 'rejected']);

        return redirect()->route('admin.resep.index')->with('success', 'Resep "' . $resep->judul . '" telah ditolak.');
    }
}