<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResepResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'judul'         => $this->judul,
            'deskripsi'     => $this->deskripsi,
            'waktu_masak'   => $this->waktu_masak . ' Menit',
            'foto'          => $this->foto ? asset('storage/' . $this->foto) : asset('assets/img/default-resep.png'),
            
            // --- TAMBAHKAN RATING DI SINI ---
            // Menghitung rata-rata rating dari tabel interaksis
            // Jika tidak ada rating, kita kasih default 0
            'rating'        => round($this->interaksi()->avg('rating') ?? 0, 1),
            // Menghitung jumlah orang yang kasih rating/komentar
            'total_ulasan'  => $this->interaksi()->count(),
            // --------------------------------
            
            'status'        => $this->status,
            'tanggal'       => $this->tanggal_publish,
            
            'penulis' => [
                'nama' => $this->user->name ?? 'Anonim',
            ],

            'bahan'   => $this->whenLoaded('bahan'),
            'langkah' => $this->whenLoaded('langkah'),
        ];
    }
}