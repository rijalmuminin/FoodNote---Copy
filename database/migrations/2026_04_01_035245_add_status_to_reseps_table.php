<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambah kolom status.
     */
    public function up(): void
    {
        Schema::table('reseps', function (Blueprint $table) {
            // Menambahkan kolom status setelah kolom foto
            // Enum membatasi input hanya: pending, approved, atau rejected
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('foto');
        });
    }

    /**
     * Batalkan migrasi (Rollback).
     */
    public function down(): void
    {
        Schema::table('reseps', function (Blueprint $table) {
            // Menghapus kolom status jika migrasi di-rollback
            $table->dropColumn('status');
        });
    }
};