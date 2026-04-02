@extends('layouts.frontend')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    /* Style untuk komentar yang disensor */
    .censored-text {
        filter: blur(3px);
        cursor: pointer;
        transition: filter 0.2s;
        background: #f0f0f0;
        padding: 2px 5px;
        border-radius: 4px;
        display: inline-block;
    }
    
    .censored-text:hover {
        filter: blur(0);
        background: #fff3cd;
    }
    
    /* Tooltip untuk sensor */
    .censored-text[data-tooltip]:hover:after {
        content: attr(data-tooltip);
        position: absolute;
        background: #333;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 10;
        margin-left: 5px;
    }
    
    /* Warning badge untuk komentar yang disensor */
    .censored-warning {
        display: inline-block;
        background: #ffc107;
        color: #856404;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 12px;
        margin-left: 8px;
        cursor: help;
    }
</style>
@endsection

@section('content')

<div class="recipe-detail-page">
    <div class="container py-5">

        <div class="mb-4">
            @if(request('from') === 'simpan')
                <a href="{{ route('user.resep.disimpan') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Resep Disimpan</a>
            @else
                <a href="{{ route('user.resep.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Semua Resep</a>
            @endif
        </div>

        {{-- Hero --}}
        <div class="recipe-hero mb-5">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="hero-image">
                        <img src="{{ $resep->foto ? asset('storage/' . $resep->foto) : asset('assets/img/no-image.png') }}" alt="{{ $resep->judul }}">
                        <div class="rating-badge-large">
                            <i class="fas fa-star"></i>
                            <span class="rating-value">{{ number_format($resep->avg_rating ?? 0, 1) }}</span>
                            <small>({{ $resep->interaksi->whereNotNull('rating')->count() }})</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-info">
                        <h1 class="recipe-title-main">{{ $resep->judul }}</h1>
                        <div class="recipe-meta-main">
                            <div class="meta-item-main"><i class="fas fa-user"></i><span>{{ $resep->user->name }}</span></div>
                            @if($resep->waktu_masak)
                            <div class="meta-item-main"><i class="fas fa-clock"></i><span>{{ $resep->waktu_masak }} menit</span></div>
                            @endif
                            <div class="meta-item-main"><i class="fas fa-calendar-alt"></i><span>{{ $resep->created_at->diffForHumans() }}</span></div>
                        </div>
                        @if($resep->kategori->isNotEmpty())
                        <div class="categories-main mb-3">
                            @foreach($resep->kategori as $kat)
                                <span class="category-badge"><i class="fas fa-tag"></i> {{ $kat->nama_kategori }}</span>
                            @endforeach
                        </div>
                        @endif
                        <p class="recipe-description">{{ $resep->deskripsi ?? 'Resep masakan yang lezat dan mudah dibuat.' }}</p>
                        @auth
                        <form action="{{ route('resep.simpan', $resep->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-save {{ $sudahSimpan ? 'active' : '' }}">
                                <i class="fas fa-heart"></i> {{ $sudahSimpan ? 'Tersimpan' : 'Simpan Resep' }}
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="btn-save"><i class="fas fa-heart"></i> Login untuk Simpan</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- Ingredients & Steps --}}
        <div class="recipe-content-section mb-5">
            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <div class="content-card sticky-bahan">
                        <div class="card-header-custom"><i class="fas fa-shopping-basket"></i><h3>Bahan-bahan</h3></div>
                        <div class="card-body-custom">
                            @forelse($resep->bahan as $b)
                                <div class="ingredient-item">
                                    <span class="ingredient-name">{{ $b->nama_bahan }}</span>
                                    <span class="ingredient-amount">{{ $b->jumlah }}</span>
                                </div>
                            @empty
                                <p class="text-muted text-center py-4">Belum ada bahan</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="content-card">
                        <div class="card-header-custom"><i class="fas fa-list-ol"></i><h3>Cara Membuat</h3></div>
                        <div class="card-body-custom">
                            @forelse($resep->langkah as $index => $l)
                                <div class="step-item">
                                    <div class="step-number">{{ $index + 1 }}</div>
                                    <div class="step-content"><p>{{ $l->deskripsi_langkah }}</p></div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-4">Belum ada langkah</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Review Form --}}
        @auth
        <div class="review-section mb-5">
            <div class="content-card">
                <div class="card-header-custom"><i class="fas fa-star"></i><h3>Berikan Rating & Ulasan</h3></div>
                <div class="card-body-custom">
                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert" style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 12px;">
                            <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="float: right; background: none; border: none; font-size: 20px;"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('resep.ulasan', $resep->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Rating Anda</label>
                            <div class="star-rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $userInteraksi?->rating == $i ? 'checked' : '' }} required>
                                    <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Komentar</label>
                            <textarea name="komentar" class="form-control-custom" rows="4" required placeholder="Bagaimana pengalaman Anda membuat resep ini? (Kata-kata kasar akan otomatis disensor)">{{ $userInteraksi?->komentar ?? '' }}</textarea>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-shield-alt"></i> Komentar yang mengandung kata-kata tidak pantas akan otomatis disensor menjadi ****
                            </small>
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> {{ $userInteraksi ? 'Update Ulasan' : 'Kirim Ulasan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endauth

        {{-- Comments with Censor Filter --}}
        <div class="comments-section">
            <h3 class="section-title mb-4"><i class="fas fa-comments"></i> Ulasan Pengguna ({{ $komentars->count() }})</h3>
            @forelse($komentars as $k)
                <div class="comment-card">
                    <div class="comment-header">
                        <div class="user-info">
                            <div class="user-avatar">{{ strtoupper(substr($k->user->name ?? 'U', 0, 1)) }}</div>
                            <div>
                                <strong>{{ $k->user->name ?? 'Pengguna' }}</strong>
                                <div class="comment-meta">
                                    <div class="stars-small">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $k->rating ? 'filled' : 'empty' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="separator">•</span>
                                    <span class="time">{{ $k->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($k->komentar)
                        <div class="comment-text">
                            {{-- Cek apakah komentar mengandung karakter sensor (*) --}}
                            @if(strpos($k->komentar, '*') !== false)
                                <span class="censored-text" data-tooltip="Klik untuk lihat teks asli (mengandung kata tidak pantas)">
                                    {{ $k->komentar }}
                                </span>
                                <span class="censored-warning" title="Komentar ini telah disensor karena mengandung kata-kata tidak pantas">
                                    <i class="fas fa-eye-slash"></i> Disensor
                                </span>
                            @else
                                {{ $k->komentar }}
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-comments">
                    <i class="fas fa-comments"></i>
                    <h5>Belum ada ulasan</h5>
                    <p>Jadilah yang pertama memberikan ulasan untuk resep ini!</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

<style>
:root {
    --primary:   #b84a1e;
    --primary-lt:#fdf0e8;
    --accent:    #e07040;
    --hdr:       #6b2d10;
    --gold:      #d4930a;
    --ink:       #2a1a10;
    --ink-s:     #6b4e3d;
    --ink-m:     #a88070;
    --border:    #e8d0c0;
    --bg:        #fdf8f4;
    --white:     #ffffff;
    --r:         12px;
    --sh:        0 2px 18px rgba(100,40,10,.09);
}
.recipe-detail-page { background:var(--bg);min-height:100vh;font-family:'DM Sans',sans-serif; }

.btn-back { display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:var(--white);color:var(--ink);border:1.5px solid var(--border);border-radius:8px;text-decoration:none;font-weight:500;font-size:14px;transition:.25s; }
.btn-back:hover { border-color:var(--primary);color:var(--primary);transform:translateX(-3px); }

.hero-image { position:relative;border-radius:var(--r);overflow:hidden;box-shadow:0 6px 28px rgba(100,40,10,.2); }
.hero-image img { width:100%;height:500px;object-fit:cover;display:block;transition:transform 7s ease; }
.hero-image:hover img { transform:scale(1.04); }
.rating-badge-large { position:absolute;top:18px;left:18px;background:rgba(20,8,2,.82);backdrop-filter:blur(6px);color:var(--gold);padding:9px 16px;border-radius:8px;font-weight:700;display:flex;align-items:center;gap:6px; }
.rating-value { font-size:18px;color:var(--white); }

.hero-info { background:var(--white);padding:30px;border-radius:var(--r);box-shadow:var(--sh);height:100%;display:flex;flex-direction:column;border:1px solid var(--border); }
.recipe-title-main { font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:700;color:var(--ink);margin-bottom:18px;line-height:1.25; }
.recipe-meta-main { display:flex;flex-wrap:wrap;gap:16px;margin-bottom:16px;padding-bottom:16px;border-bottom:1px solid var(--border); }
.meta-item-main { display:flex;align-items:center;gap:7px;color:var(--ink-s);font-size:13.5px; }
.meta-item-main i { color:var(--accent); }
.category-badge { display:inline-flex;align-items:center;gap:5px;padding:4px 12px;background:var(--primary-lt);color:var(--primary);border:1px solid #f0c0a0;border-radius:100px;font-size:12px;font-weight:600;margin:0 6px 6px 0; }
.recipe-description { color:var(--ink-s);line-height:1.88;margin-bottom:24px;flex-grow:1;font-size:14.5px; }

.btn-save { display:flex;align-items:center;justify-content:center;gap:9px;width:100%;padding:13px 24px;background:var(--white);color:var(--primary);border:2px solid var(--primary);border-radius:9px;font-weight:600;font-size:14px;text-decoration:none;cursor:pointer;transition:.3s;font-family:inherit; }
.btn-save:hover,.btn-save.active { background:var(--primary);color:var(--white); }

.content-card { background:var(--white);border-radius:var(--r);box-shadow:var(--sh);overflow:hidden;border:1px solid var(--border); }
.card-header-custom { background:var(--hdr);color:var(--white);padding:16px 22px;display:flex;align-items:center;gap:10px; }
.card-header-custom i { opacity:.7;font-size:14px; }
.card-header-custom h3 { margin:0;font-size:1rem;font-weight:600; }
.card-body-custom { padding:22px; }

.sticky-bahan { position:sticky;top:80px;max-height:calc(100vh - 110px);overflow-y:auto;scrollbar-width:thin;scrollbar-color:var(--border) transparent; }
.sticky-bahan::-webkit-scrollbar { width:4px; }
.sticky-bahan::-webkit-scrollbar-thumb { background:var(--border);border-radius:4px; }

.ingredient-item { display:flex;justify-content:space-between;align-items:center;padding:11px 0;border-bottom:1px solid #f5e8df;font-size:14px; }
.ingredient-item:last-child { border-bottom:none; }
.ingredient-name { color:var(--ink); }
.ingredient-amount { font-weight:600;font-size:12.5px;color:var(--ink-s);background:var(--primary-lt);padding:3px 10px;border-radius:100px;white-space:nowrap; }

.step-item { display:flex;gap:16px;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #f5e8df;align-items:flex-start; }
.step-item:last-child { border-bottom:none;margin-bottom:0;padding-bottom:0; }
.step-number { flex-shrink:0;width:38px;height:38px;background:var(--primary);color:var(--white);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px; }
.step-content p { margin:0;color:var(--ink-s);line-height:1.78;font-size:14.5px;padding-top:8px; }

.star-rating-input { display:flex;flex-direction:row-reverse;justify-content:flex-end;gap:6px; }
.star-rating-input input[type="radio"] { display:none; }
.star-rating-input label { cursor:pointer;font-size:33px;color:#ddd;transition:.15s; }
.star-rating-input input[type="radio"]:checked ~ label,
.star-rating-input label:hover,
.star-rating-input label:hover ~ label { color:var(--gold);transform:scale(1.1); }
.star-rating-input label:active { transform:scale(1.2); }

.form-control-custom { width:100%;padding:12px 15px;border:1.5px solid var(--border);border-radius:9px;font-size:14px;font-family:inherit;transition:.25s;resize:vertical;background:var(--bg);box-sizing:border-box; }
.form-control-custom:focus { outline:none;border-color:var(--accent);background:var(--white); }
.btn-submit { display:inline-flex;align-items:center;gap:9px;padding:12px 26px;background:var(--hdr);color:var(--white);border:none;border-radius:9px;font-weight:600;font-size:14px;cursor:pointer;font-family:inherit;transition:.25s; }
.btn-submit:hover { background:var(--primary);transform:translateY(-1px); }

.section-title { font-family:'Playfair Display',serif;color:var(--ink);font-size:1.35rem; }
.comment-card { background:var(--white);border-radius:var(--r);padding:20px;margin-bottom:14px;box-shadow:var(--sh);border:1px solid var(--border);transition:box-shadow .25s; }
.comment-card:hover { box-shadow:0 6px 24px rgba(100,40,10,.14); }
.user-info { display:flex;align-items:center;gap:12px; }
.user-avatar { width:42px;height:42px;border-radius:50%;background:var(--hdr);color:var(--white);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:15px;flex-shrink:0; }
.comment-meta { display:flex;align-items:center;gap:8px;margin-top:3px; }
.stars-small i.filled { color:var(--gold); }
.stars-small i.empty { color:#ddd; }
.separator,.time { color:var(--ink-m);font-size:12px; }
.comment-text { margin:10px 0 0;color:var(--ink-s);font-size:14px;line-height:1.72; }
.empty-comments { text-align:center;padding:48px 20px;color:var(--ink-m); }
.empty-comments i { font-size:30px;display:block;margin-bottom:12px;opacity:.3; }
.empty-comments h5 { font-family:'Playfair Display',serif;color:var(--ink);margin-bottom:6px; }

/* Style untuk komentar yang disensor */
.censored-text {
    filter: blur(3px);
    cursor: pointer;
    transition: filter 0.2s;
    background: #f0f0f0;
    padding: 2px 5px;
    border-radius: 4px;
    display: inline-block;
}

.censored-text:hover {
    filter: blur(0);
    background: #fff3cd;
}

.censored-text[data-tooltip]:hover:after {
    content: attr(data-tooltip);
    position: absolute;
    background: #333;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    z-index: 10;
    margin-left: 5px;
}

.censored-warning {
    display: inline-block;
    background: #ffc107;
    color: #856404;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 12px;
    margin-left: 8px;
    cursor: help;
}

.alert-warning {
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 20px;
}

.alert-warning i {
    margin-right: 8px;
}

.btn-close {
    float: right;
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #856404;
}

@media (max-width: 768px) {
    .hero-image img { height: 320px; }
    .hero-info { padding: 20px; }
    .recipe-title-main { font-size: 1.5rem; }
    .card-header-custom { padding: 12px 18px; }
    .card-body-custom { padding: 18px; }
    .censored-text { filter: blur(2px); }
}
</style>

@push('scripts')
<script>
    // Optional: Tambahkan JavaScript untuk tooltip dan interaksi
    document.addEventListener('DOMContentLoaded', function() {
        // Untuk komentar yang disensor, bisa ditambahkan fitur klik untuk melihat teks asli
        const censoredTexts = document.querySelectorAll('.censored-text');
        censoredTexts.forEach(el => {
            el.addEventListener('click', function() {
                if (this.style.filter === 'blur(0px)') {
                    this.style.filter = 'blur(3px)';
                } else {
                    this.style.filter = 'blur(0px)';
                }
            });
        });
        
        // Auto dismiss alert setelah 5 detik
        const alerts = document.querySelectorAll('.alert-warning');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    });
</script>
@endpush

@endsection