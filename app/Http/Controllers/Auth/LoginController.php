<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Controller ini menangani proses autentikasi user dan redirect
    | setelah login. Kami menggunakan trait AuthenticatesUsers.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Hanya guest (belum login) yang boleh akses login
        $this->middleware('guest')->except('logout');

        // Logout harus user login
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirect setelah login berdasarkan role.
     * 
     * @param Request $request
     * @param mixed $user
     */
    protected function authenticated(Request $request, $user)
    {
        // Pastikan di tabel users ada kolom 'role' atau 'is_admin'
        if ($user->role === 'admin') {
            // Jika admin, redirect ke admin dashboard
            return redirect('/admin/dashboard');
        }

        // User biasa
        return redirect('/'); // atau '/home' sesuai kebutuhan
    }
}
