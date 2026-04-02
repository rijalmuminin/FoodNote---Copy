<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    protected $table = 'bahans';

    protected $fillable = [
        'resep_id',
        'nama_bahan',
        'jumlah',
    ];

    public function resep()
    {
        return $this->belongsTo(Resep::class);
    }
}

