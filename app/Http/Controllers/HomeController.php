<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Tampilan Halaman Depan FoodNote
     * Mengambil 9 resep terpopuler berdasarkan algoritma interaksi
     */
    public function index()
    {
        // 1. Ambil 9 resep dengan skor popularitas tertinggi
        $reseps = Resep::with(['user', 'kategori'])
            // Hitung rata-rata rating (1.0 - 5.0)
            ->withAvg('interaksi as avg_rating', 'rating')
            
            // Hitung jumlah user yang memberikan rating (biar rating 5.0 dari 1 orang kalah sama 4.8 dari 100 orang)
            ->withCount(['interaksi as rating_count' => function($q) {
                $q->whereNotNull('rating');
            }])
            
            // Hitung jumlah komentar yang valid (tidak kosong)
            ->withCount(['interaksi as komentar_count' => function($q) {
                $q->whereNotNull('komentar')->where('komentar', '!=', '');
            }])
            
            // Hitung berapa kali resep ini disimpan oleh user lain
            ->withCount(['interaksi as simpan_count' => function($q) {
                $q->where('simpan_resep', true);
            }])
            
            /**
             * ALGORITMA POPULER:
             * Skor = Jumlah Simpan + Jumlah Komentar + (Rata-rata Rating * Jumlah Pemberi Rating)
             * COALESCE digunakan untuk menangani nilai NULL jika resep belum punya interaksi.
             */
            ->orderByRaw('(
                (COALESCE(simpan_count, 0) * 3) + 
                (COALESCE(komentar_count, 0) * 1) + 
                (COALESCE(avg_rating, 0) * COALESCE(rating_count, 0))
            ) DESC')
            ->take(8)
            ->get();

        // 2. Ambil semua kategori untuk bagian filter atau top category di Home
        $kategoris = Kategori::all();

        // 3. Return ke view user/index.blade.php
        return view('user.index', compact('reseps', 'kategoris'));
    }
}