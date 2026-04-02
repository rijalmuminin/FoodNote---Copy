<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Langkah extends Model
{
    protected $table = 'langkahs';

    protected $fillable = [
        'resep_id',
        'nomor_langkah',
        'deskripsi_langkah'
    ];

    public function resep()
    {
        return $this->belongsTo(Resep::class);
    }
}
