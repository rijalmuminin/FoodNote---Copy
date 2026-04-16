<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resep;
use App\Http\Resources\ResepResource;
use Illuminate\Http\Request;

class ResepController extends Controller
{
    /**
     * 1. Ambil semua resep dengan FILTER & SEARCH
     */
    public function index(Request $request)
    {
        $query = Resep::query()
            ->with(['user', 'kategori'])
            ->where('status', 'approved')
            // Menghitung rata-rata rating untuk filter 'having'
            ->withAvg('interaksi as avg_rating', 'rating')
            ->withCount(['interaksi as rating_count' => function ($q) {
                $q->whereNotNull('rating');
            }]);

        // 🔍 Search berdasarkan judul
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // 🏷️ Filter Kategori (berdasarkan nama)
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // ⭐ Filter Rating Minimum
        if ($request->filled('rating_min') && is_numeric($request->rating_min)) {
            $query->having('avg_rating', '>=', $request->rating_min);
        }

        // ⏱️ Filter Waktu Masak Maksimum
        if ($request->filled('waktu') && is_numeric($request->waktu)) {
            $query->where('waktu_masak', '<=', $request->waktu);
        }

        $reseps = $query->latest()->get();

        return ResepResource::collection($reseps);
    }

    /**
     * 2. Ambil detail satu resep
     */
    public function show($id)
    {
        $resep = Resep::with(['user', 'bahan', 'langkah', 'interaksi', 'kategori'])
            ->withAvg('interaksi as avg_rating', 'rating')
            ->find($id);

        if (!$resep) {
            return response()->json(['message' => 'Resep tidak ditemukan'], 404);
        }

        return new ResepResource($resep);
    }

    /**
     * 3. Resep Milik Saya (Auth)
     */
    public function resepSaya(Request $request)
    {
        $reseps = Resep::with(['user', 'kategori'])
            ->where('user_id', $request->user()->id) 
            ->latest()
            ->get();

        return ResepResource::collection($reseps);
    }

    /**
     * 4. Resep yang Disimpan (Bookmark)
     */
    public function resepTersimpan()
    {
        $user = auth()->user();

        $resep = Resep::whereHas('interaksi', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('simpan_resep', 1);
        })->with(['user', 'bahan', 'langkah', 'interaksi', 'kategori'])->get();

        return ResepResource::collection($resep);
    }
}