@extends('layouts.frontend')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
/* ── TOKENS ────────────────── */
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
    --px:   5%;
    --r:    14px;
    --r-lg: 22px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--fb); background: var(--sf); color: var(--dk); -webkit-font-smoothing: antialiased; }
img  { display: block; }
a    { text-decoration: none; }

/* ════════════════════════════════════════════════════════
   HERO BREADCRUMB
   ════════════════════════════════════════════════════════ */
.tn-hero {
    position: relative;
    height: 300px;
    overflow: hidden;
    background: var(--dk);
}

.tn-hero-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: .35;
    filter: saturate(.6);
}

.tn-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(160deg, rgba(18,10,4,.85) 0%, rgba(18,10,4,.4) 100%);
}

.tn-hero-body {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 0 var(--px) 2.5rem;
}

.tn-hero-label {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    font-size: .68rem;
    font-weight: 600;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--ac2);
    margin-bottom: .8rem;
}

.tn-hero-label::before {
    content: '';
    display: block;
    width: 28px;
    height: 1.5px;
    background: var(--ac2);
}

.tn-hero-body h1 {
    font-family: var(--fh);
    font-size: 3rem;
    font-weight: 600;
    color: #fff;
    line-height: 1.1;
}

.tn-hero-body h1 em {
    font-style: italic;
    color: var(--ac2);
}

/* ════════════════════════════════════════════════════════
   INTRO
   ════════════════════════════════════════════════════════ */
.tn-intro {
    padding: 5rem var(--px);
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}

.tn-label {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    font-size: .68rem;
    font-weight: 600;
    letter-spacing: .13em;
    text-transform: uppercase;
    color: var(--ac);
    margin-bottom: 1rem;
}

.tn-label::before {
    content: '';
    display: block;
    width: 22px;
    height: 1.5px;
    background: var(--ac);
}

.tn-intro-text h2 {
    font-family: var(--fh);
    font-size: 2.4rem;
    font-weight: 600;
    color: var(--dk);
    line-height: 1.22;
    margin-bottom: 1.2rem;
}

.tn-intro-text h2 em {
    font-style: italic;
    color: var(--ac);
}

.tn-intro-text p {
    font-size: .88rem;
    color: var(--md);
    line-height: 1.8;
    margin-bottom: 1rem;
}

.tn-intro-visual {
    position: relative;
}

.tn-intro-visual .tn-img-main {
    width: 100%;
    aspect-ratio: 4/5;
    object-fit: cover;
    border-radius: var(--r-lg);
    position: relative;
    z-index: 1;
}

.tn-intro-visual::before {
    content: '';
    position: absolute;
    inset: -16px -16px 16px 16px;
    border: 2px solid var(--bd);
    border-radius: var(--r-lg);
    z-index: 0;
}

.tn-img-badge {
    position: absolute;
    bottom: 1.5rem;
    left: -1.5rem;
    z-index: 2;
    background: var(--wh);
    border: 1px solid var(--bd);
    border-radius: var(--r);
    padding: .9rem 1.2rem;
    box-shadow: 0 8px 24px rgba(26,18,8,.10);
    display: flex;
    align-items: center;
    gap: .8rem;
}

.tn-img-badge-icon {
    width: 40px;
    height: 40px;
    background: rgba(184,92,42,.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.tn-img-badge-text strong {
    display: block;
    font-size: .95rem;
    font-weight: 600;
    color: var(--dk);
    line-height: 1;
}

.tn-img-badge-text span {
    font-size: .68rem;
    color: var(--lt);
    margin-top: .18rem;
    display: block;
}

/* ════════════════════════════════════════════════════════
   NILAI / PHILOSOPHY
   ════════════════════════════════════════════════════════ */
.tn-values {
    padding: 4rem var(--px) 6rem;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

.tn-value-card {
    background: var(--wh);
    border: 1px solid var(--bd);
    border-radius: var(--r-lg);
    padding: 2rem 1.8rem;
    transition: transform .25s ease, box-shadow .25s ease;
}

.tn-value-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 36px rgba(26,18,8,.09);
}

.tn-value-icon {
    width: 46px;
    height: 46px;
    background: rgba(184,92,42,.09);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.2rem;
}

.tn-value-icon svg { width: 22px; height: 22px; color: var(--ac); }

.tn-value-card h4 {
    font-family: var(--fh);
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--dk);
    margin-bottom: .5rem;
}

.tn-value-card p {
    font-size: .8rem;
    color: var(--md);
    line-height: 1.75;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .tn-intro     { grid-template-columns: 1fr; gap: 2.5rem; }
    .tn-intro-visual { max-width: 440px; margin: 0 auto; }
    .tn-values    { grid-template-columns: 1fr; gap: 1rem; }
    .tn-hero-body h1 { font-size: 2.2rem; }
}

@media (max-width: 560px) {
    :root { --px: 4%; }
    .tn-hero { height: 240px; }
    .tn-hero-body h1 { font-size: 1.8rem; }
    .tn-img-badge { left: .5rem; }
    .tn-intro-text h2 { font-size: 1.9rem; }
}
</style>
@endsection

@section('content')

{{-- HERO --}}
<section class="tn-hero">
    <img class="tn-hero-img"
         src="{{ asset('assets/frontend/img/bg-img/breadcumb1.jpg') }}"
         alt="About FoodNote">
    <div class="tn-hero-overlay"></div>
    <div class="tn-hero-body">
        <span class="tn-hero-label">Tentang Kami</span>
        <h1>Dapur Digital <em>untuk</em><br>Semua Orang</h1>
    </div>
</section>

{{-- INTRO --}}
<section class="tn-intro">
    <div class="tn-intro-text">
        <span class="tn-label">Siapa Kami</span>
        <h2>Berbagi Cita Rasa,<br><em>Mempererat Kebersamaan</em></h2>
        <p>FoodNote lahir dari kecintaan terhadap masakan rumahan. Kami percaya bahwa setiap resep menyimpan cerita — tentang keluarga, kenangan, dan kehangatan dapur yang tak tergantikan.</p>
        <p>Platform kami hadir sebagai ruang bagi siapa saja untuk menemukan, menyimpan, dan berbagi resep masakan terbaik dari seluruh penjuru nusantara. Dari sarapan sederhana hingga hidangan istimewa, semuanya ada di sini.</p>
    </div>

    <div class="tn-intro-visual">
        <img class="tn-img-main"
             src="{{ asset('assets/frontend/img/bg-img/about.png') }}"
             alt="FoodNote – Tentang Kami">

        <div class="tn-img-badge">
            <div class="tn-img-badge-icon">🍳</div>
            <div class="tn-img-badge-text">
                <strong>1.200+ Resep</strong>
                <span>Terus bertambah setiap hari</span>
            </div>
        </div>
    </div>
</section>

{{-- NILAI / PHILOSOPHY --}}
<section class="tn-values">
    <div class="tn-value-card">
        <div class="tn-value-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/>
                <circle cx="12" cy="10" r="3"/>
            </svg>
        </div>
        <h4>Dari Hati, Untuk Dapur</h4>
        <p>Setiap resep yang kami kurasi dipilih dengan cermat — bukan sekadar daftar bahan, melainkan pengalaman memasak yang sesungguhnya dan terasa di lidah.</p>
    </div>

    <div class="tn-value-card">
        <div class="tn-value-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <h4>Komunitas yang Hangat</h4>
        <p>FoodNote bukan sekadar platform — ini adalah komunitas pecinta masakan yang saling berbagi, menginspirasi, dan mendukung satu sama lain setiap harinya.</p>
    </div>

    <div class="tn-value-card">
        <div class="tn-value-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
        </div>
        <h4>Mudah & Terpercaya</h4>
        <p>Resep kami dirancang agar mudah diikuti oleh siapa saja — dari pemula hingga koki rumahan berpengalaman, dengan bahan-bahan yang mudah ditemukan.</p>
    </div>
</section>

@endsection

@section('scripts')
{{-- Script counter dihapus karena section stats sudah tidak ada --}}
@endsection