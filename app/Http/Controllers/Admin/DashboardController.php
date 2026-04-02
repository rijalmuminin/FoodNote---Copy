<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Resep;
use App\Models\Kategori;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard admin.
     */
    public function index()
    {
        return view('admin.index        ', [
            // Menghitung total user yang terdaftar
            'total_user'     => User::count(),
            
            // Menghitung total semua resep
            'total_resep'    => Resep::count(),
            
            // Menghitung resep yang statusnya 'pending' (Menunggu Persetujuan)
            'resep_pending'  => Resep::where('status', 'pending')->count(),
            
            // Menghitung total kategori yang tersedia
            'total_kategori' => Kategori::count(),  
            
            // Mengambil 5 resep terbaru untuk ditampilkan di tabel dashboard
            'resep_terbaru'  => Resep::with('user')->latest()->take(5)->get(),
        ]);
    }
}