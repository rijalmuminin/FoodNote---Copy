<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ResepController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/resep', [ResepController::class, 'index']);
Route::get('/resep/{id}', [ResepController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/resep-saya', [ResepController::class, 'resepSaya']);
});
Route::middleware('auth:sanctum')->get('/resep-tersimpan',
 [ResepController::class, 'resepTersimpan']);