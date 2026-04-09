@extends('layouts.frontend')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
/* ── ROOT TOKENS ─────────────────────────────────────────── */
:root {
    --ac:   #b85c2a;
    --ac2:  #d4784a;
    --dk:   #1e1510;
    --md:   #6b5e54;
    --lt:   #a0958d;
    --sf:   #f7f3ee;
    --wh:   #ffffff;
    --bd:   #ece5dc;
    --fh:   'Cormorant Garamond', serif;
    --fb:   'Outfit', sans-serif;
    --r:    14px;
    --r-lg: 20px;
    --px:   5%;         /* padding horizontal global */
    --gap:  1rem;       /* gap standar               */
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--fb); background: var(--sf); color: var(--dk); -webkit-font-smoothing: antialiased; }
img  { display: block; }
a    { text-decoration: none; }

/* ════════════════════════════════════════════════════════
   HERO ROW  –  slider kiri | kategori kanan
   ════════════════════════════════════════════════════════ */
.fn-hero-row {
    display: grid;
    grid-template-columns: 1fr 340px;   /* slider | sidebar kategori */
    gap: var(--gap);
    padding: 1.4rem var(--px);
    align-items: start;
}

/* ── SLIDER ─────────────────────────────────────────────── */
.fn-slider {
    position: relative;
    aspect-ratio: 1 / 1;
    border-radius: var(--r-lg);
    overflow: hidden;
    background: var(--dk);
}

.fn-slide {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity .85s ease;
}

.fn-slide.active { opacity: 1; }

/* overlay gelap kiri */
.fn-slide::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        150deg,
        rgba(18,10,4,.80) 0%,
        rgba(18,10,4,.40) 55%,
        transparent 100%
    );
}

/* konten slide */
.fn-slide-content {
    position: absolute;
    bottom: 2rem;
    left: 1.8rem;
    right: 1.8rem;
    z-index: 2;
}

.fn-tag {
    display: inline-block;
    background: rgba(184,92,42,.28);
    border: 1px solid rgba(184,92,42,.55);
    color: var(--ac2);
    font-size: .65rem;
    font-weight: 600;
    letter-spacing: .12em;
    text-transform: uppercase;
    padding: .28rem .8rem;
    border-radius: 999px;
    margin-bottom: .7rem;
    backdrop-filter: blur(6px);
}

.fn-slide-content h2 {
    font-family: var(--fh);
    font-size: 1.65rem;
    font-weight: 600;
    color: #fff;
    line-height: 1.25;
    margin-bottom: .5rem;
}

.fn-slide-content p {
    color: rgba(255,255,255,.55);
    font-size: .78rem;
    line-height: 1.65;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.fn-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: var(--ac);
    color: #fff !important;
    padding: .55rem 1.25rem;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 500;
    transition: background .22s, transform .18s;
}
.fn-btn-primary:hover { background: var(--ac2); transform: translateY(-1px); }
.fn-btn-primary svg   { width: 13px; height: 13px; }

/* dots */
.fn-dots {
    position: absolute;
    bottom: 1.1rem;
    right: 1.5rem;
    z-index: 3;
    display: flex;
    gap: 5px;
    align-items: center;
}

.fn-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255,255,255,.32);
    border: none;
    cursor: pointer;
    padding: 0;
    transition: background .3s, width .3s;
}

.fn-dot.active {
    background: #fff;
    width: 18px;
    border-radius: 999px;
}

/* ── SIDEBAR KATEGORI ───────────────────────────────────── */
.fn-cats-sidebar {
    display: flex;
    flex-direction: column;
    gap: var(--gap);
    height: 100%;
}

.fn-cat {
    position: relative;
    flex: 1;
    border-radius: var(--r-lg);
    overflow: hidden;
    display: block;
    transition: transform .3s ease, box-shadow .3s ease;
    min-height: 0;
}

.fn-cat:hover { transform: translateY(-3px); box-shadow: 0 14px 36px rgba(0,0,0,.17); }

.fn-cat img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .55s ease;
}

.fn-cat:hover img { transform: scale(1.06); }

.fn-cat::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(10,5,2,.72) 0%, rgba(10,5,2,.15) 55%, transparent 100%);
}

.fn-cat-body {
    position: absolute;
    bottom: 1.1rem;
    left: 1.2rem;
    z-index: 1;
    transition: transform .28s ease;
}

.fn-cat:hover .fn-cat-body { transform: translateY(-3px); }

.fn-cat-body h3 {
    font-family: var(--fh);
    font-size: 1.25rem;
    font-weight: 600;
    color: #fff;
    margin-bottom: .1rem;
}

.fn-cat-body span {
    color: rgba(255,255,255,.58);
    font-size: .7rem;
}

/* ════════════════════════════════════════════════════════
   SECTION WRAPPER
   ════════════════════════════════════════════════════════ */
.fn-wrap {
    padding: 2rem var(--px);
}

.fn-sec-head {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 1.4rem;
}

.fn-sec-title {
    font-family: var(--fh);
    font-size: 1.65rem;
    font-weight: 600;
    color: var(--dk);
}

.fn-sec-title em { color: var(--ac); font-style: italic; }

.fn-sec-all {
    font-size: .75rem;
    font-weight: 500;
    color: var(--ac);
    display: flex;
    align-items: center;
    gap: .3rem;
    transition: gap .2s;
}
.fn-sec-all:hover { gap: .55rem; }

/* ════════════════════════════════════════════════════════
   RECIPE GRID  –  4 kolom, 2 baris (8 resep)
   ════════════════════════════════════════════════════════ */
.fn-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.fn-card {
    background: var(--wh);
    border-radius: var(--r);
    overflow: hidden;
    border: 1px solid var(--bd);
    display: block;
    transition: transform .22s ease, box-shadow .22s ease;
}

.fn-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(26,18,8,.09); }

.fn-card-img {
    position: relative;
    height: 180px;
    overflow: hidden;
    background: var(--bd);
}

.fn-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .38s ease;
}

.fn-card:hover .fn-card-img img { transform: scale(1.06); }

.fn-badge {
    position: absolute;
    top: 9px;
    left: 9px;
    background: rgba(26,18,8,.70);
    backdrop-filter: blur(6px);
    color: #f5c26b;
    font-size: .68rem;
    font-weight: 600;
    padding: .25rem .6rem;
    border-radius: 999px;
    display: flex;
    align-items: center;
    gap: .22rem;
}

.fn-card-body { padding: .9rem 1rem 1rem; }

.fn-card-title {
    font-family: var(--fh);
    font-size: .98rem;
    font-weight: 600;
    color: var(--dk);
    line-height: 1.35;
    margin-bottom: .45rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.fn-card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: .7rem;
    color: var(--lt);
    margin-bottom: .75rem;
}

.fn-stars { color: #e8a060; letter-spacing: 1px; font-size: .73rem; }

.fn-card-link {
    display: block;
    text-align: center;
    padding: .48rem;
    border: 1px solid var(--bd);
    border-radius: 8px;
    font-size: .73rem;
    font-weight: 500;
    color: var(--ac);
    transition: background .18s, color .18s, border-color .18s;
}
.fn-card-link:hover { background: var(--ac); color: #fff; border-color: var(--ac); }

/* ════════════════════════════════════════════════════════
   DIVIDER
   ════════════════════════════════════════════════════════ */
.fn-divider { height: 1px; background: var(--bd); margin: 0 var(--px); }

/* ════════════════════════════════════════════════════════
   CTA BANNER
   ════════════════════════════════════════════════════════ */
.fn-cta {
    margin: 2rem var(--px);
    background: var(--dk);
    border-radius: var(--r-lg);
    padding: 2.5rem 2.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    position: relative;
    overflow: hidden;
}

.fn-cta::before {
    content: '';
    position: absolute;
    right: -50px; top: -50px;
    width: 240px; height: 240px;
    background: radial-gradient(circle, rgba(184,92,42,.22) 0%, transparent 70%);
    pointer-events: none;
}

.fn-cta-text h2 {
    font-family: var(--fh);
    font-size: 1.75rem;
    font-weight: 600;
    color: #fff;
    margin-bottom: .4rem;
}

.fn-cta-text p {
    color: rgba(255,255,255,.5);
    font-size: .8rem;
    line-height: 1.7;
    max-width: 420px;
}

.fn-btn-outline {
    display: inline-block;
    border: 1.5px solid rgba(255,255,255,.28);
    color: #fff !important;
    padding: .6rem 1.6rem;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 500;
    white-space: nowrap;
    flex-shrink: 0;
    transition: background .22s, border-color .22s;
}
.fn-btn-outline:hover { background: var(--ac); border-color: var(--ac); }

/* ════════════════════════════════════════════════════════
   NEWSLETTER
   ════════════════════════════════════════════════════════ */
.fn-nl {
    background: var(--wh);
    border-top: 1px solid var(--bd);
    padding: 2.2rem var(--px);
    display: grid;
    grid-template-columns: 1fr 1.1fr 1fr;
    gap: 2.5rem;
    align-items: center;
}

.fn-nl-quote {
    font-family: var(--fh);
    font-size: 1rem;
    line-height: 1.6;
    color: var(--dk);
    font-style: italic;
    border-left: 2px solid var(--ac);
    padding-left: 1rem;
}

.fn-nl-quote cite {
    display: block;
    font-family: var(--fb);
    font-size: .7rem;
    color: var(--lt);
    font-style: normal;
    margin-top: .45rem;
}

.fn-nl-form-wrap h4 { font-size: .84rem; font-weight: 600; color: var(--dk); margin-bottom: .18rem; }
.fn-nl-form-wrap p  { font-size: .7rem; color: var(--lt); margin-bottom: .85rem; }

.fn-nl-form { display: flex; flex-direction: column; gap: .45rem; }

.fn-nl-form input {
    border: 1px solid var(--bd);
    border-radius: 9px;
    padding: .58rem 1rem;
    font-size: .78rem;
    font-family: var(--fb);
    background: var(--sf);
    color: var(--dk);
    outline: none;
    transition: border-color .2s;
}
.fn-nl-form input:focus { border-color: var(--ac); }

.fn-nl-form button {
    background: var(--ac);
    color: #fff;
    border: none;
    padding: .58rem;
    border-radius: 9px;
    font-size: .78rem;
    font-weight: 500;
    font-family: var(--fb);
    cursor: pointer;
    transition: background .2s;
}
.fn-nl-form button:hover { background: var(--ac2); }

.fn-nl-img img {
    width: 100%;
    border-radius: var(--r);
    max-height: 160px;
    object-fit: cover;
}

/* ════════════════════════════════════════════════════════
   RESPONSIVE
   ════════════════════════════════════════════════════════ */
@media (max-width: 1100px) {
    .fn-grid { grid-template-columns: repeat(4, 1fr); }
}

@media (max-width: 900px) {
    .fn-hero-row {
        grid-template-columns: 1fr;
    }
    .fn-cats-sidebar {
        flex-direction: row;
        height: 160px;
    }
    .fn-grid { grid-template-columns: repeat(2, 1fr); }
    .fn-nl   { grid-template-columns: 1fr; gap: 1.6rem; }
    .fn-nl-img { display: none; }
}

@media (max-width: 600px) {
    :root { --px: 4%; }
    .fn-slider { aspect-ratio: 4/3; }
    .fn-cats-sidebar { height: 130px; gap: .6rem; }
    .fn-slide-content h2 { font-size: 1.35rem; }
    .fn-grid { grid-template-columns: repeat(2, 1fr); }
    .fn-cta  { flex-direction: column; text-align: center; }
    .fn-cta-text p { max-width: 100%; }
}
</style>
@endsection

@section('content')

{{-- ══════════════════════════════════════════════════════
     HERO ROW  –  Slider (kiri) + Kategori (kanan)
     ══════════════════════════════════════════════════════ --}}
<div class="fn-hero-row">

    {{-- SLIDER --}}
    <div class="fn-slider">
        @foreach($reseps->take(3) as $slider)
        <div class="fn-slide {{ $loop->first ? 'active' : '' }}"
             style="background-image:url('{{ asset('storage/'.$slider->foto) }}')">
            <div class="fn-slide-content">
                <span class="fn-tag">✦ Resep Unggulan</span>
                <h2>{{ $slider->judul }}</h2>
                <p>{{ Str::limit($slider->deskripsi, 110) }}</p>
                <a href="{{ route('user.resep.show', $slider->id) }}" class="fn-btn-primary">
                    Lihat Resep
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 8h10M9 4l4 4-4 4"/>
                    </svg>
                </a>
            </div>
        </div>
        @endforeach

        <div class="fn-dots">
            @foreach($reseps->take(3) as $slider)
            <button class="fn-dot {{ $loop->first ? 'active' : '' }}" data-idx="{{ $loop->index }}"></button>
            @endforeach
        </div>
    </div>

    {{-- KATEGORI SIDEBAR --}}
    <div class="fn-cats-sidebar">
        @foreach($kategoris->take(2) as $kat)
        @php
            $namaKategori = strtolower($kat->nama_kategori);
            $fotoKategori = 'bg1.jpg';
            if (str_contains($namaKategori, 'padang'))     { $fotoKategori = 'masakan-padang.jpg'; }
            elseif (str_contains($namaKategori, 'rumahan')) { $fotoKategori = 'masakan-rumahan.jpg'; }
        @endphp
        <a href="{{ url('/resep?kategori='.$kat->nama_kategori) }}" class="fn-cat">
            <img src="{{ asset('assets/frontend/img/bg-img/' . $fotoKategori) }}"
                 alt="{{ $kat->nama_kategori }}"
                 onerror="this.onerror=null;this.src='https://placehold.co/400x300?text={{ urlencode($kat->nama_kategori) }}'">
            <div class="fn-cat-body">
                <h3>{{ $kat->nama_kategori }}</h3>
                <span>Koleksi Resep Terbaik</span>
            </div>
        </a>
        @endforeach
    </div>

</div>

{{-- ══════════════════════════════════════════════════════
     RESEP TERPOPULER
     ══════════════════════════════════════════════════════ --}}
<section class="fn-wrap">
    <div class="fn-sec-head">
        <h3 class="fn-sec-title">Resep <em>Terpopuler</em></h3>
        <a href="{{ url('/resep') }}" class="fn-sec-all">
            Lihat semua
            <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 8h10M9 4l4 4-4 4"/>
            </svg>
        </a>
    </div>

    <div class="fn-grid">
        @foreach($reseps->take(8) as $resep)
        @php
            $avgRating   = $resep->avg_rating  ?? 0;
            $ratingCount = $resep->rating_count ?? 0;
        @endphp
        <a href="{{ route('user.resep.show', $resep->id) }}" class="fn-card">
            <div class="fn-card-img">
                <img src="{{ $resep->foto ? asset('storage/'.$resep->foto) : asset('assets/img/no-image.png') }}"
                     alt="{{ $resep->judul }}">
                @if($avgRating > 0)
                <span class="fn-badge">★ {{ number_format($avgRating, 1) }}</span>
                @endif
            </div>
            <div class="fn-card-body">
                <h5 class="fn-card-title">{{ $resep->judul }}</h5>
                <div class="fn-card-meta">
                    <span class="fn-stars">
                        @for($i = 1; $i <= 5; $i++){{ $i <= round($avgRating) ? '★' : '☆' }}@endfor
                    </span>
                    <span>({{ $ratingCount }} ulasan)</span>
                </div>
                <span class="fn-card-link">Lihat Detail</span>
            </div>
        </a>
        @endforeach
    </div>
</section>

<div class="fn-divider"></div>

{{-- ══════════════════════════════════════════════════════
     CTA BANNER
     ══════════════════════════════════════════════════════ --}}
<div class="fn-cta">
    <div class="fn-cta-text">
        <h2>Masak Apa Hari Ini?</h2>
        <p>Temukan ribuan resep rumahan yang lezat, sehat, dan mudah dibuat. Bagikan juga resep andalanmu kepada komunitas FoodNote!</p>
    </div>
    <a href="{{ url('/resep') }}" class="fn-btn-outline">Jelajahi Resep →</a>
</div>

{{-- ══════════════════════════════════════════════════════
     NEWSLETTER
     ══════════════════════════════════════════════════════ --}}
<section class="fn-nl">
    <blockquote class="fn-nl-quote">
        "Tidak ada yang lebih baik daripada pulang ke rumah dan makan makanan enak bersama keluarga."
        <cite>— FoodNote Community</cite>
    </blockquote>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var slides = document.querySelectorAll('.fn-slide');
    var dots   = document.querySelectorAll('.fn-dot');
    var current = 0;
    var timer;

    function show(idx) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = idx;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    function next()  { show((current + 1) % slides.length); }
    function reset() { clearInterval(timer); timer = setInterval(next, 5500); }

    dots.forEach(function (d, i) {
        d.addEventListener('click', function () { show(i); reset(); });
    });

    reset();
});
</script>
@endsection