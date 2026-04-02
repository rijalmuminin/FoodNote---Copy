<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| CONTROLLERS IMPORT
|--------------------------------------------------------------------------
*/

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ResepController as AdminResepController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\UserController;

// USER / FRONTEND CONTROLLERS
use App\Http\Controllers\User\ResepsayaController as UserResepsayaController;
use App\Http\Controllers\User\PageController;
use App\Http\Controllers\User\InteraksiController;

// PUBLIC / USER RESEP CONTROLLER
use App\Http\Controllers\ResepController as UserResepController;

Auth::routes();

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/profile', [PageController::class, 'profile'])->name('user.profile')->middleware('auth');

// Halaman Utama
Route::get('/', [UserResepController::class, 'home'])->name('user.index');

/*
|--------------------------------------------------------------------------
| USER RESEP ROUTES (List & Detail)
|--------------------------------------------------------------------------
*/
Route::get('/resep', [UserResepController::class, 'index'])->name('user.resep.index');
Route::get('/resep/{id}', [UserResepController::class, 'show'])->name('user.resep.show');

/*
|--------------------------------------------------------------------------
| INTERAKSI RESEP (Login Required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Simpan Resep
    Route::post('/resep/{id}/simpan', [InteraksiController::class, 'simpan'])->name('resep.simpan');
    
    // Ulasan (Gabungan Rating & Komentar)
    Route::post('/resep/{id}/ulasan', [InteraksiController::class, 'ulasan'])->name('resep.ulasan');

    // Halaman List Resep yang disimpan
    Route::get('/resep-disimpan', [InteraksiController::class, 'resepDisimpan'])->name('user.resep.disimpan');
});

/*
|--------------------------------------------------------------------------
| USER AUTH ONLY (CRUD Resep Saya)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::resource('resepsaya', UserResepsayaController::class)->names('user.resepsaya');
    Route::get('/tentang', [PageController::class, 'tentang'])->name('tentang');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Approve & Reject Included)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/', fn() => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Fitur Terima & Tolak Resep (Diletakkan SEBELUM resource agar tidak bentrok)
        Route::post('/resep/{id}/approve', [AdminResepController::class, 'approve'])->name('resep.approve');
Route::post('/resep/{id}/reject', [AdminResepController::class, 'reject'])->name('resep.reject');        
        // Resource CRUD
        Route::resource('resep', AdminResepController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('user', UserController::class)->only(['index', 'edit', 'update']);
    });