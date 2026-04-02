<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $fillable = [
        'user_id', 
        'judul', 
        'deskripsi', 
        'waktu_masak', 
        'foto', 
        'status', // Tambahkan ini
        'tanggal_publish'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsToMany(Kategori::class, 'resep_kategoris');
    }

    public function bahan()
    {
        return $this->hasMany(Bahan::class);
    }

    public function langkah()
    {
        return $this->hasMany(Langkah::class);
    }
    public function interaksi()
    {
        return $this->hasMany(Interaksi::class);
    }

    public function ratings()
    {
        return $this->hasMany(Interaksi::class)->whereNotNull('rating');
    }

}
