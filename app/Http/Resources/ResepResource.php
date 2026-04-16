<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResepResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'judul'         => $this->judul,
            'deskripsi'     => $this->deskripsi,
            'waktu_masak'   => $this->waktu_masak . ' Menit',
            'foto'          => $this->foto ? asset('storage/' . $this->foto) : asset('assets/img/default-resep.png'),
            
            // OPTIMASI: Mengambil hasil dari withAvg dan withCount di Controller
            // Kalau avg_rating tidak ada (misal di show), dia baru hitung manual
            'rating'        => round($this->avg_rating ?? $this->interaksi()->avg('rating') ?? 0, 1),
            'total_ulasan'  => $this->rating_count ?? $this->interaksi()->count(),
            
            'status'        => $this->status,
            'tanggal'       => $this->tanggal_publish,
            
            'penulis' => [
                'nama' => $this->user->name ?? 'Anonim',
            ],

            // Data Bahan
            'bahan'   => $this->whenLoaded('bahan', function () {
                return $this->bahan->map(function ($item) {
                    return [
                        'nama_bahan' => $item->nama_bahan,
                        'kuantitas'  => $item->kuantitas,
                    ];
                });
            }),

            // Data Langkah (Cara Membuat)
            'langkah' => $this->whenLoaded('langkah', function () {
                return $this->langkah->map(function ($item) {
                    return [
                        'step' => $item->deskripsi_langkah, 
                    ];
                });
            }),

            // Data Ulasan (Interaksi)
            'ulasan'  => $this->whenLoaded('interaksi', function () {
                return $this->interaksi->whereNotNull('komentar')->map(function ($item) {
                    return [
                        'user' => [
                            'nama' => $item->user->name ?? 'User',
                        ],
                        'rating'   => $item->rating,
                        'komentar' => $item->komentar,
                    ];
                });
            }),

            // Kategori
            'kategori' => $this->whenLoaded('kategori', function () {
                return $this->kategori->map(function ($kat) {
                    return [
                        'nama' => $kat->nama_kategori,
                    ];
                });
            }),
        ];
    }
}