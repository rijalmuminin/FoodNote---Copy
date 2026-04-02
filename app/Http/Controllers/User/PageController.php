<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resep;

class PageController extends Controller
{
    public function tentang()
    {
        return view('user.tentang');
    }

    public function profile()
    {
        $user = auth()->user();

        // Ambil resep milik user yang login
        $reseps = Resep::with(['kategori'])
            ->withAvg('interaksi as avg_rating', 'rating')
            ->withCount(['interaksi as rating_count' => function($q) {
                $q->whereNotNull('rating');
            }])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // Ambil resep yang disimpan oleh user
        $resepSimpan = Resep::with(['kategori', 'user'])
            ->withAvg('interaksi as avg_rating', 'rating')
            ->whereHas('interaksi', function($q) use ($user) {
                $q->where('user_id', $user->id)->where('simpan_resep', true);
            })
            ->latest()
            ->get();

        return view('user.profile', compact('user', 'reseps', 'resepSimpan'));
    }
}