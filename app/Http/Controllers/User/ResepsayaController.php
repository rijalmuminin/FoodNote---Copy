<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\Bahan;
use App\Models\Langkah;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResepsayaController extends Controller
{
    public function index(Request $request)
    {
        // Admin bisa lihat semua resep di list user, tapi user cuma bisa lihat miliknya
        if (auth()->user()->role == 'admin') { 
            $query = Resep::with(['user', 'kategori']);
        } else {
            $query = Resep::where('user_id', auth()->id())->with(['kategori']);
        }

        // Filter sederhana berdasarkan waktu masak
        if ($request->waktu_masak) {
            $query->where('waktu_masak', '<=', $request->waktu_masak);
        }

        $reseps = $query->latest()->get();
        return view('user.resepsaya.index', compact('reseps'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('user.resepsaya.create', compact('kategoris'));
    }

    /**
     * SIMPAN RESEP USER
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'required',
            'waktu_masak'     => 'required|integer|min:1',
            'foto'            => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', 
            'kategori_id'     => 'required|array|min:1',
            'bahan.*'         => 'required',
            'jumlah.*'        => 'required',
            'langkah.*'       => 'required',
        ], [
            'judul.required'        => 'Nama resep jangan dikosongkan, Jal.',
            'deskripsi.required'    => 'Isi deskripsi singkat tentang masakanmu.',
            'waktu_masak.required'  => 'Tentukan berapa lama waktu masaknya.',
            'foto.required'         => 'Foto masakan wajib diunggah.',
            'kategori_id.required'  => 'Pilih minimal satu kategori.',
            'bahan.*.required'      => 'Nama bahan tidak boleh kosong.',
            'jumlah.*.required'     => 'Jumlah/takaran bahan harus diisi.',
            'langkah.*.required'    => 'Isi penjelasan langkah memasaknya.',
        ]);

        try {
            DB::beginTransaction();

            // 1. Upload Foto
            $fotoPath = $request->file('foto')->store('resep', 'public');

            // 2. Buat Resep dengan status PENDING
            $resep = Resep::create([
                'user_id'         => auth()->id(),
                'judul'           => $request->judul,
                'deskripsi'       => $request->deskripsi,
                'waktu_masak'     => $request->waktu_masak,
                'tanggal_publish' => null, // Belum publish sampai di-acc admin
                'foto'            => $fotoPath,
                'status'          => 'pending', // Default untuk user
            ]);

            // 3. Simpan Bahan
            foreach ($request->bahan as $i => $b) {
                Bahan::create([
                    'resep_id'   => $resep->id,
                    'nama_bahan' => $b,
                    'jumlah'     => $request->jumlah[$i]
                ]);
            }

            // 4. Simpan Langkah
            foreach ($request->langkah as $i => $l) {
                Langkah::create([
                    'resep_id'          => $resep->id,
                    'nomor_langkah'     => $i + 1,
                    'deskripsi_langkah' => $l
                ]);
            }

            $resep->kategori()->attach($request->kategori_id);

            DB::commit();
            return redirect()->route('user.resepsaya.index')
                ->with('success', 'Resep berhasil dikirim! Mohon tunggu persetujuan admin ya.');

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($fotoPath)) { Storage::disk('public')->delete($fotoPath); }
            return back()->withInput()->with('error', 'Gagal menyimpan resep: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $query = Resep::with(['bahan', 'langkah', 'kategori', 'user']);
        if (auth()->user()->role != 'admin') {
            $query->where('user_id', auth()->id());
        }
        $resep = $query->findOrFail($id);
        return view('user.resepsaya.show', compact('resep'));
    }

    public function edit($id)
    {
        $resep = Resep::with(['bahan', 'langkah', 'kategori'])->findOrFail($id);

        // User tidak boleh edit resep orang lain
        if (auth()->user()->role != 'admin' && $resep->user_id != auth()->id()) {
            abort(403, 'Kamu tidak punya akses edit resep ini.');
        }

        // Proteksi: Resep yang sudah Approved tidak boleh diedit user biasa
        if (auth()->user()->role != 'admin' && $resep->status == 'approved') {
            return redirect()->route('user.resepsaya.index')
                ->with('error', 'Resep yang sudah terbit tidak bisa diedit. Hubungi admin jika ingin perubahan.');
        }

        $kategoris = Kategori::all();
        return view('user.resepsaya.edit', compact('resep', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $resep = Resep::findOrFail($id);

        if (auth()->user()->role != 'admin' && $resep->user_id != auth()->id()) { abort(403); }

        // Sama seperti edit, proteksi di update
        if (auth()->user()->role != 'admin' && $resep->status == 'approved') {
            return redirect()->route('user.resepsaya.index')->with('error', 'Update gagal. Resep sudah terbit.');
        }

        $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required',
            'waktu_masak' => 'required|integer|min:1',
            'kategori_id' => 'required|array',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('foto')) {
                if ($resep->foto) { Storage::disk('public')->delete($resep->foto); }
                $resep->foto = $request->file('foto')->store('resep', 'public');
            }

            $resep->update([
                'judul'       => $request->judul,
                'deskripsi'   => $request->deskripsi,
                'waktu_masak' => $request->waktu_masak,
                'foto'        => $resep->foto,
                // Status tetap 'pending' atau balik jadi 'pending' jika diedit? 
                // Di sini saya biarkan tetap sesuai status sebelumnya atau bisa kamu set pending lagi.
            ]);

            $resep->kategori()->sync($request->kategori_id);

            Bahan::where('resep_id', $id)->delete();
            Langkah::where('resep_id', $id)->delete();

            foreach ($request->bahan as $i => $b) {
                Bahan::create(['resep_id' => $id, 'nama_bahan' => $b, 'jumlah' => $request->jumlah[$i]]);
            }

            foreach ($request->langkah as $i => $l) {
                Langkah::create(['resep_id' => $id, 'nomor_langkah' => $i + 1, 'deskripsi_langkah' => $l]);
            }

            DB::commit();
            return redirect()->route('user.resepsaya.index')->with('success', 'Resep berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $resep = Resep::findOrFail($id);

        if (auth()->user()->role != 'admin' && $resep->user_id != auth()->id()) { abort(403); }

        if ($resep->foto) { Storage::disk('public')->delete($resep->foto); }
        $resep->delete();

        return back()->with('success', 'Resep berhasil dihapus');
    }
}