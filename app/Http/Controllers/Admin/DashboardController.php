<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Resep;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'total_user'     => User::count(),
            'total_resep'    => Resep::count(),
            'resep_pending'  => Resep::where('status', 'pending')->count(),
            
            // Tambahan data statistik baru
            'resep_approved' => Resep::where('status', 'approved')->count(),
            'resep_rejected' => Resep::where('status', 'rejected')->count(),
            
            'total_kategori' => Kategori::count(),  
            'resep_terbaru'  => Resep::with('user')->latest()->take(5)->get(),
        ]);
    }
}