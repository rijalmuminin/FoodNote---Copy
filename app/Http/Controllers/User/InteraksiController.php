<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interaksi;
use App\Models\Resep;

class InteraksiController extends Controller
{
    /**
     * Daftar kata-kata yang akan disensor
     */
    private $censoredWords = [
        // Daftar kata kasar dalam bahasa Indonesia
        'anjing', 'babi', 'kontol', 'memek', 'ngentot', 'jancok', 'jancuk',
        'asu', 'bangsat', 'sialan', 'goblok', 'tolol', 'bego', 'idiot',
        'setan', 'kampret', 'keparat', 'lonte', 'sundal', 'pelacur',
        'peler', 'tai', 'tinja', 'brengsek', 'ampas', 'banci', 'bencong',
        'cacat', 'cebong', 'kampang', 'kimak', 'kuntilanak', 'silit',
        'toket', 'udeng', 'wadimor', 'fuck', 'shit', 'bitch', 'asshole',
        // Tambahkan kata-kata lain yang ingin disensor
    ];
    
    /**
     * Karakter pengganti sensor
     */
    private $replacement = '*';
    
    /**
     * Jumlah huruf awal dan akhir yang tetap terlihat
     * Set ke 0 jika ingin semua huruf diganti *
     */
    private $visibleLetters = 1; // Misal: a***g (1 huruf awal dan akhir terlihat)
    
    /**
     * Simpan / Bookmark Resep (Toggle)
     */
    public function simpan($id)
    {
        $userId = auth()->id();
        
        // Cari interaksi yang ada atau buat baru
        $interaksi = Interaksi::firstOrNew([
            'resep_id' => $id,
            'user_id'  => $userId
        ]);

        // Toggle status simpan
        $interaksi->simpan_resep = !$interaksi->simpan_resep;
        $interaksi->save();

        return back()->with('success', $interaksi->simpan_resep ? 'Resep berhasil disimpan!' : 'Resep dihapus dari simpanan.');
    }

    /**
     * Kirim atau Update Ulasan (Rating & Komentar sekaligus)
     */
    public function ulasan(Request $request, $id)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:500',
        ]);
        
        // Sensor komentar
        $komentar = $this->censorText($request->komentar);
        
        // Simpan ke database
        Interaksi::updateOrCreate(
            ['resep_id' => $id, 'user_id' => auth()->id()],
            [
                'rating'   => $request->rating,
                'komentar' => $komentar
            ]
        );

        return back()->with('success', 'Ulasan dan rating berhasil dikirim!');
    }
    
    /**
     * Fungsi untuk menyensor teks
     * 
     * @param string $text
     * @return string
     */
    private function censorText($text)
    {
        if (empty($text)) {
            return $text;
        }
        
        foreach ($this->censoredWords as $word) {
            // Pattern untuk mencari kata utuh (case-insensitive)
            $pattern = '/\b' . preg_quote($word, '/') . '\b/i';
            
            // Sensor kata
            $censored = $this->censorWord($word);
            
            // Ganti kata yang ditemukan dengan versi yang sudah disensor
            $text = preg_replace($pattern, $censored, $text);
        }
        
        return $text;
    }
    
    /**
     * Fungsi untuk menyensor per kata
     * 
     * @param string $word
     * @return string
     */
    private function censorWord($word)
    {
        $length = mb_strlen($word);
        
        // Jika visibleLetters = 0, semua huruf diganti *
        if ($this->visibleLetters == 0) {
            return str_repeat($this->replacement, $length);
        }
        
        // Jika panjang kata kurang dari 2 * visibleLetters, semua huruf diganti *
        if ($length <= $this->visibleLetters * 2) {
            return str_repeat($this->replacement, $length);
        }
        
        // Ambil huruf awal dan akhir, sisanya diganti *
        $first = mb_substr($word, 0, $this->visibleLetters);
        $last = mb_substr($word, -$this->visibleLetters);
        $middle = str_repeat($this->replacement, $length - ($this->visibleLetters * 2));
        
        return $first . $middle . $last;
    }
    
    /**
     * Cek apakah teks mengandung kata kasar (opsional)
     * 
     * @param string $text
     * @return bool
     */
    private function containsBadWords($text)
    {
        foreach ($this->censoredWords as $word) {
            if (preg_match('/\b' . preg_quote($word, '/') . '\b/i', $text)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Alternatif: Sensor dengan pesan peringatan (jika ingin menolak komentar kasar)
     */
    public function ulasanWithWarning(Request $request, $id)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:500',
        ]);
        
        // Cek apakah mengandung kata kasar
        if ($this->containsBadWords($request->komentar)) {
            // Opsi 1: Sensor otomatis dan beri peringatan
            $komentar = $this->censorText($request->komentar);
            
            Interaksi::updateOrCreate(
                ['resep_id' => $id, 'user_id' => auth()->id()],
                [
                    'rating'   => $request->rating,
                    'komentar' => $komentar
                ]
            );
            
            return back()->with('warning', 'Komentar Anda mengandung kata-kata yang tidak pantas dan telah disensor.');
            
            // Opsi 2: Tolak komentar (jika ingin lebih ketat)
            // return back()->withErrors(['komentar' => 'Komentar mengandung kata-kata yang tidak diperbolehkan.'])->withInput();
        }
        
        // Jika aman, simpan langsung
        Interaksi::updateOrCreate(
            ['resep_id' => $id, 'user_id' => auth()->id()],
            [
                'rating'   => $request->rating,
                'komentar' => $request->komentar
            ]
        );
        
        return back()->with('success', 'Ulasan dan rating berhasil dikirim!');
    }

    /**
     * Halaman List Resep yang Disimpan oleh User
     */
    public function resepDisimpan()
    {
        // Ambil resep yang simpan_resep = true untuk user ini
        $reseps = Resep::whereHas('interaksi', function($q) {
            $q->where('user_id', auth()->id())->where('simpan_resep', true);
        })
        ->withAvg('interaksi as avg_rating', 'rating')
        ->withCount('interaksi as rating_count')
        ->latest()
        ->paginate(9);

        return view('user.resep_tersimpan.index', compact('reseps'));
    }
}