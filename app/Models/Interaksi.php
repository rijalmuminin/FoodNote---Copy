<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaksi extends Model
{
    protected $fillable = [
        'user_id',
        'resep_id',
        'rating',
        'komentar',
        'simpan_resep'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resep()
    {
        return $this->belongsTo(Resep::class);
    }
}
