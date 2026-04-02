<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('interaksis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('resep_id')->constrained()->cascadeOnDelete();
        $table->integer('rating')->nullable();      
        $table->text('komentar')->nullable();     
        $table->boolean('simpan_resep')->default(false); 
        $table->timestamps();
        $table->unique(['user_id', 'resep_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interaksis');
    }
};
