<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'nama_kategori'
    ];

    public function resep()
    {
        return $this->belongsToMany(    
            Resep::class,
            'resep_kategoris',
            'kategori_id',
            'resep_id'
        );
    }
}

