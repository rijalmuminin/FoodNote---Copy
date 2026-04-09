<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resep;
use App\Http\Resources\ResepResource;
use Illuminate\Http\Request;

class ResepController extends Controller
{
    // 1. Ambil semua resep (untuk halaman utama Flutter)
    public function index()
    {
        $reseps = Resep::with('user')
                    ->where('status', 'approved') // tampilkan yang sudah publish saja
                    ->latest()
                    ->get();

        return ResepResource::collection($reseps);
    }

    // 2. Ambil detail satu resep (untuk halaman detail di Flutter)
    public function show($id)
    {
        $resep = Resep::with(['user', 'bahan', 'langkah'])->find($id);

        if (!$resep) {
            return response()->json(['message' => 'Resep tidak ditemukan'], 404);
        }

        return new ResepResource($resep);
    }
    // Fungsi untuk mengambil resep milik user yang sedang login saja (untuk fitur "Resep Saya" di Flutter)
    public function resepSaya(Request $request)
    {
        // Mengambil resep milik user yang login (berdasarkan token)
        $reseps = Resep::with('user')
                    ->where('user_id', $request->user()->id) 
                    ->latest()
                    ->get();

        return ResepResource::collection($reseps);
    }
}