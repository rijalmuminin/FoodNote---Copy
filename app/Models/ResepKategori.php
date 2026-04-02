<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResepKategori extends Model
{
    protected $table = 'resep_kategoris';

    protected $fillable = [
        'resep_id',
        'kategori_id'
    ];
}
