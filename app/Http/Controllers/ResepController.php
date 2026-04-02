<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\Kategori;

class ResepController extends Controller
{
    /**
     * LIST RESEP (Halaman Index / Jelajah)
     */
    public function index(Request $request)
    {
        // Tambahkan filter status 'approved' agar yang pending tidak muncul
        $query = Resep::query()
            ->where('status', 'approved') 
            ->with(['user', 'kategori'])
            ->withAvg('interaksi as avg_rating', 'rating')
            ->withCount(['interaksi as rating_count' => function ($q) {
                $q->whereNotNull('rating');
            }]);

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // 🏷️ FILTER KATEGORI
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // ⭐ FILTER RATING
        if ($request->filled('rating_min') && is_numeric($request->rating_min)) {
            $query->having('avg_rating', '>=', $request->rating_min);
        }

        // ⏱️ FILTER WAKTU MASAK
        if ($request->filled('waktu') && is_numeric($request->waktu)) {
            $query->where('waktu_masak', '<=', $request->waktu);
        }

        // 📦 DATA
        $reseps = $query->latest()->paginate(9)->withQueryString();

        $kategoris = Kategori::all();

        return view('user.resep.index', compact('reseps', 'kategoris'));
    }

    /**
     * DETAIL RESEP
     */
    public function show($id)
    {
        // Gunakan where status approved agar resep pending tidak bisa diakses lewat link langsung
        $resep = Resep::where('status', 'approved')
            ->with([
                'user',
                'kategori',
                'bahan',
                'langkah',
                'interaksi.user'
            ])
            ->withAvg('interaksi as avg_rating', 'rating')
            ->withCount(['interaksi as rating_count' => function ($q) {
                $q->whereNotNull('rating');
            }])
            ->findOrFail($id);

        $avgRating = number_format($resep->avg_rating ?? 0, 1);
        $jumlahUlasan = $resep->rating_count ?? 0;

        $sudahSimpan = false;
        $userInteraksi = null;

        if (auth()->check()) {
            $userInteraksi = $resep->interaksi
                ->where('user_id', auth()->id())
                ->first();

            $sudahSimpan = $userInteraksi?->simpan_resep ?? false;
        }

        $komentars = $resep->interaksi
            ->whereNotNull('komentar')
            ->where('komentar', '!=', '')
            ->sortByDesc('created_at');

        return view('user.resep.show', compact(
            'resep',
            'avgRating',
            'jumlahUlasan',
            'sudahSimpan',
            'userInteraksi',
            'komentars'
        ));
    }

    /**
     * HOME (Landing Page)
     */
    public function home()
    {
        // Hanya ambil resep yang sudah disetujui (Approved)
        $reseps = Resep::where('status', 'approved')
            ->with(['user', 'kategori'])
            ->withAvg('interaksi as avg_rating', 'rating')
            ->withCount(['interaksi as rating_count' => function ($q) {
                $q->whereNotNull('rating');
            }])
            ->latest()
            ->take(9)
            ->get();

        $kategoris = Kategori::all();

        return view('user.index', compact('reseps', 'kategoris'));
    }
}