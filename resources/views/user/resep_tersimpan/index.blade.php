@extends('layouts.frontend')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,500&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')

<div class="sp-page">

    {{-- PAGE HEADER --}}
    <div class="sp-header">
        <div class="sp-header-inner">
            <div class="sp-header-left">
                <a href="{{ route('user.resep.index') }}" class="sp-back-link">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <p class="sp-header-eyebrow">Koleksi Saya</p>
                    <h1 class="sp-header-title">Resep Disimpan</h1>
                </div>
            </div>
            @if($reseps->count())
            <div class="sp-header-right">
                <div class="sp-count-badge">
                    <span class="sp-count-num">{{ $reseps->count() }}</span>
                    <span class="sp-count-label">resep</span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="sp-container">

        @if($reseps->count())

        {{-- FEATURED + GRID --}}
        @php $first = $reseps->first(); @endphp

        {{-- FEATURED CARD (first item, large) --}}
        <div class="sp-featured">
            @php
                $avgFirst = $first->interaksi ? $first->interaksi->whereNotNull('rating')->avg('rating') : 0;
                $ixFirst  = $first->interaksi ? $first->interaksi->where('user_id', auth()->id())->where('simpan_resep', true)->first() : null;
            @endphp
            <a href="{{ route('user.resep.show', $first->id) }}?from=simpan" class="sp-featured-img-link">
                @if($first->foto)
                    <img src="{{ asset('storage/' . $first->foto) }}" alt="{{ $first->judul }}" class="sp-featured-img">
                @else
                    <div class="sp-featured-img sp-no-img"><i class="fas fa-image"></i></div>
                @endif
                <div class="sp-featured-overlay"></div>
            </a>
            <div class="sp-featured-body">
                @if($first->kategori->isNotEmpty())
                <div class="sp-cats">
                    @foreach($first->kategori as $k)
                        <span class="sp-cat">{{ $k->nama_kategori }}</span>
                    @endforeach
                </div>
                @endif
                <a href="{{ route('user.resep.show', $first->id) }}?from=simpan" class="sp-featured-title-link">
                    <h2 class="sp-featured-title">{{ $first->judul }}</h2>
                </a>
                @if($first->deskripsi)
                <p class="sp-featured-desc">{{ \Illuminate\Support\Str::limit($first->deskripsi, 160) }}</p>
                @endif
                <div class="sp-featured-meta">
                    <div class="sp-meta-row">
                        <span class="sp-meta-chip"><i class="fas fa-user"></i> {{ $first->user->name }}</span>
                        @if($first->waktu_masak)
                        <span class="sp-meta-chip"><i class="fas fa-clock"></i> {{ $first->waktu_masak }} menit</span>
                        @endif
                        <span class="sp-meta-chip sp-rating"><i class="fas fa-star"></i> {{ number_format($avgFirst, 1) }}</span>
                    </div>
                    @if($ixFirst?->created_at)
                    <span class="sp-saved-time"><i class="fas fa-heart"></i> Disimpan {{ $ixFirst->created_at->diffForHumans() }}</span>
                    @endif
                </div>
                <div class="sp-featured-actions">
                    <a href="{{ route('user.resep.show', $first->id) }}?from=simpan" class="sp-btn-view">
                        <i class="fas fa-arrow-right"></i> Lihat Resep
                    </a>
                    <form action="{{ route('resep.simpan', $first->id) }}" method="POST" onsubmit="return confirm('Hapus dari simpanan?')" class="sp-unsave-form">
                        @csrf
                        <button type="submit" class="sp-btn-unsave" title="Hapus dari simpanan">
                            <i class="fas fa-heart-broken"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- REST GRID --}}
        @if($reseps->count() > 1)
        <div class="sp-divider">
            <span>Resep Lainnya</span>
        </div>

        <div class="sp-grid">
            @foreach($reseps->skip(1) as $resep)
            @php
                $avg = $resep->interaksi ? $resep->interaksi->whereNotNull('rating')->avg('rating') : 0;
                $ix  = $resep->interaksi ? $resep->interaksi->where('user_id', auth()->id())->where('simpan_resep', true)->first() : null;
            @endphp
            <div class="sp-card" style="--delay: {{ $loop->index * 0.06 }}s">
                <a href="{{ route('user.resep.show', $resep->id) }}?from=simpan" class="sp-card-img-wrap">
                    @if($resep->foto)
                        <img src="{{ asset('storage/' . $resep->foto) }}" alt="{{ $resep->judul }}" class="sp-card-img">
                    @else
                        <div class="sp-card-img sp-no-img-sm"><i class="fas fa-image"></i></div>
                    @endif
                    <div class="sp-card-img-overlay">
                        <span class="sp-card-rating"><i class="fas fa-star"></i> {{ number_format($avg, 1) }}</span>
                    </div>
                </a>

                <div class="sp-card-body">
                    @if($resep->kategori->isNotEmpty())
                    <p class="sp-card-cat">{{ $resep->kategori->pluck('nama_kategori')->join(' · ') }}</p>
                    @endif
                    <a href="{{ route('user.resep.show', $resep->id) }}?from=simpan" class="sp-card-title-link">
                        <h3 class="sp-card-title">{{ $resep->judul }}</h3>
                    </a>
                    @if($resep->deskripsi)
                    <p class="sp-card-desc">{{ \Illuminate\Support\Str::limit($resep->deskripsi, 80) }}</p>
                    @endif

                    <div class="sp-card-meta">
                        <span><i class="fas fa-user"></i> {{ $resep->user->name }}</span>
                        @if($resep->waktu_masak)
                        <span><i class="fas fa-clock"></i> {{ $resep->waktu_masak }}m</span>
                        @endif
                    </div>
                </div>

                <div class="sp-card-footer">
                    <span class="sp-card-time">
                        @if($ix?->created_at) {{ $ix->created_at->diffForHumans() }} @endif
                    </span>
                    <div class="sp-card-actions">
                        <a href="{{ route('user.resep.show', $resep->id) }}?from=simpan" class="sp-card-btn-view">Lihat</a>
                        <form action="{{ route('resep.simpan', $resep->id) }}" method="POST" onsubmit="return confirm('Hapus dari simpanan?')">
                            @csrf
                            <button type="submit" class="sp-card-btn-unsave" title="Hapus">
                                <i class="fas fa-heart-broken"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @else

        {{-- EMPTY STATE --}}
        <div class="sp-empty">
            <div class="sp-empty-icon">
                <i class="fas fa-heart"></i>
            </div>
            <h3 class="sp-empty-title">Koleksimu masih kosong</h3>
            <p class="sp-empty-sub">Simpan resep favorit kamu dan temukan kembali kapan saja.</p>
            <a href="{{ route('user.resep.index') }}" class="sp-btn-explore">
                <i class="fas fa-compass"></i> Jelajahi Resep
            </a>
        </div>

        @endif
    </div>
</div>

<style>
:root {
    --pr:   #b84a1e;
    --pr-d: #7c3010;
    --pr-l: #fdf0e8;
    --acc:  #e07040;
    --gold: #d4930a;
    --ink:  #2a1a10;
    --ink-s:#6b4e3d;
    --ink-m:#a88070;
    --bdr:  #e8d0c0;
    --bg:   #fdf8f4;
    --wh:   #ffffff;
    --r:    14px;
    --sh:   0 2px 20px rgba(100,40,10,.10);
    --sh-h: 0 8px 36px rgba(100,40,10,.18);
    --ff-d: 'Playfair Display', Georgia, serif;
    --ff-b: 'DM Sans', sans-serif;
}
*, *::before, *::after { box-sizing: border-box; }
.sp-page { background: var(--bg); min-height: 100vh; font-family: var(--ff-b); }

/* ── HEADER ── */
.sp-header {
    background: var(--wh);
    border-bottom: 1px solid var(--bdr);
    padding: 0;
}
.sp-header-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 28px 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.sp-header-left { display: flex; align-items: center; gap: 18px; }
.sp-back-link {
    width: 40px; height: 40px;
    border-radius: 50%;
    border: 1.5px solid var(--bdr);
    display: flex; align-items: center; justify-content: center;
    color: var(--ink-s); text-decoration: none; font-size: 14px;
    transition: .25s; flex-shrink: 0;
}
.sp-back-link:hover { background: var(--pr); border-color: var(--pr); color: var(--wh); }
.sp-header-eyebrow { margin: 0; font-size: 11px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--pr); }
.sp-header-title { margin: 4px 0 0; font-family: var(--ff-d); font-size: 2rem; font-weight: 700; color: var(--ink); line-height: 1; }
.sp-count-badge {
    display: flex; flex-direction: column; align-items: center;
    width: 62px; height: 62px; border-radius: 50%;
    background: var(--pr-l); border: 2px solid var(--bdr);
    justify-content: center;
}
.sp-count-num { font-size: 1.4rem; font-weight: 700; color: var(--pr); line-height: 1; }
.sp-count-label { font-size: 10px; font-weight: 600; letter-spacing: .5px; color: var(--ink-m); }

/* ── CONTAINER ── */
.sp-container { max-width: 1200px; margin: 0 auto; padding: 48px 40px 80px; }

/* ── FEATURED ── */
.sp-featured {
    display: grid;
    grid-template-columns: 1fr 1fr;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: var(--sh-h);
    border: 1px solid var(--bdr);
    background: var(--wh);
    margin-bottom: 60px;
    min-height: 420px;
}
.sp-featured-img-link { display: block; position: relative; overflow: hidden; }
.sp-featured-img {
    width: 100%; height: 100%; min-height: 420px;
    object-fit: cover; display: block;
    transition: transform 7s ease;
}
.sp-featured-img-link:hover .sp-featured-img { transform: scale(1.05); }
.sp-no-img {
    background: linear-gradient(135deg, #f0ddd0 0%, #e8c4a8 100%);
    display: flex; align-items: center; justify-content: center;
    color: var(--ink-m); font-size: 3rem;
}
.sp-featured-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to right, rgba(0,0,0,0) 60%, rgba(28,14,6,.08) 100%);
    pointer-events: none;
}
.sp-featured-body {
    padding: 44px 40px;
    display: flex; flex-direction: column; justify-content: center;
}
.sp-cats { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 14px; }
.sp-cat {
    padding: 4px 12px; border-radius: 100px;
    background: var(--pr-l); color: var(--pr);
    font-size: 11px; font-weight: 600; letter-spacing: .5px;
    border: 1px solid #f0c0a0;
}
.sp-featured-title-link { text-decoration: none; }
.sp-featured-title {
    font-family: var(--ff-d); font-size: 2rem; font-weight: 700;
    color: var(--ink); line-height: 1.2; margin: 0 0 14px;
    transition: color .2s;
}
.sp-featured-title-link:hover .sp-featured-title { color: var(--pr); }
.sp-featured-desc { color: var(--ink-s); font-size: 14.5px; line-height: 1.8; margin: 0 0 24px; }
.sp-featured-meta { margin-bottom: 28px; }
.sp-meta-row { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 10px; }
.sp-meta-chip {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px; border-radius: 100px;
    background: #f8f2ee; color: var(--ink-s);
    font-size: 12.5px; font-weight: 500;
}
.sp-meta-chip.sp-rating { color: var(--gold); background: #fdf8ec; }
.sp-meta-chip i { font-size: 11px; }
.sp-saved-time { font-size: 12px; color: var(--ink-m); display: flex; align-items: center; gap: 5px; }
.sp-saved-time i { color: var(--pr); font-size: 10px; }
.sp-featured-actions { display: flex; align-items: center; gap: 12px; }
.sp-btn-view {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 24px; background: var(--pr); color: var(--wh);
    border-radius: 9px; font-weight: 600; font-size: 14px;
    text-decoration: none; transition: .25s;
}
.sp-btn-view:hover { background: var(--pr-d); transform: translateY(-1px); color: var(--wh); }
.sp-unsave-form { margin: 0; }
.sp-btn-unsave {
    width: 42px; height: 42px; border-radius: 50%;
    border: 1.5px solid var(--bdr); background: var(--wh);
    color: var(--ink-m); cursor: pointer; font-size: 15px;
    transition: .25s; display: flex; align-items: center; justify-content: center;
}
.sp-btn-unsave:hover { border-color: #e74c3c; background: #fef0ef; color: #e74c3c; }

/* ── DIVIDER ── */
.sp-divider {
    display: flex; align-items: center; gap: 16px;
    margin-bottom: 32px;
}
.sp-divider::before,.sp-divider::after { content:''; flex:1; height:1px; background:var(--bdr); }
.sp-divider span { font-size: 12px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: var(--ink-m); white-space: nowrap; }

/* ── CARD GRID ── */
.sp-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.sp-card {
    background: var(--wh);
    border-radius: var(--r);
    border: 1px solid var(--bdr);
    box-shadow: var(--sh);
    overflow: hidden;
    display: flex; flex-direction: column;
    transition: box-shadow .3s, transform .3s;
    animation: sp-fadein .5s ease both;
    animation-delay: var(--delay, 0s);
}
.sp-card:hover { box-shadow: var(--sh-h); transform: translateY(-4px); }

@keyframes sp-fadein {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

.sp-card-img-wrap {
    position: relative; display: block;
    overflow: hidden; height: 190px;
}
.sp-card-img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 6s ease; }
.sp-card:hover .sp-card-img { transform: scale(1.06); }
.sp-no-img-sm {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, #f0ddd0, #e8c4a8);
    display: flex; align-items: center; justify-content: center;
    color: var(--ink-m); font-size: 2rem;
}
.sp-card-img-overlay {
    position: absolute; top: 12px; right: 12px;
}
.sp-card-rating {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 4px 10px; border-radius: 100px;
    background: rgba(20,8,2,.78); backdrop-filter: blur(5px);
    color: var(--gold); font-size: 12px; font-weight: 700;
}

.sp-card-body { padding: 18px 18px 10px; flex: 1; }
.sp-card-cat { margin: 0 0 6px; font-size: 11px; font-weight: 600; letter-spacing: .8px; text-transform: uppercase; color: var(--pr); }
.sp-card-title-link { text-decoration: none; }
.sp-card-title { font-family: var(--ff-d); font-size: 1.12rem; font-weight: 700; color: var(--ink); margin: 0 0 8px; line-height: 1.3; transition: color .2s; }
.sp-card-title-link:hover .sp-card-title { color: var(--pr); }
.sp-card-desc { font-size: 13px; color: var(--ink-s); line-height: 1.65; margin: 0 0 12px; }
.sp-card-meta { display: flex; gap: 12px; font-size: 12px; color: var(--ink-m); }
.sp-card-meta i { font-size: 11px; margin-right: 3px; color: var(--acc); }

.sp-card-footer {
    padding: 12px 18px;
    border-top: 1px solid #f5e8df;
    display: flex; align-items: center; justify-content: space-between;
}
.sp-card-time { font-size: 11px; color: var(--ink-m); }
.sp-card-actions { display: flex; align-items: center; gap: 8px; }
.sp-card-btn-view {
    padding: 6px 14px; border-radius: 7px;
    background: var(--pr); color: var(--wh);
    font-size: 12px; font-weight: 600; text-decoration: none;
    transition: .2s;
}
.sp-card-btn-view:hover { background: var(--pr-d); color: var(--wh); }
.sp-card-btn-unsave {
    width: 30px; height: 30px; border-radius: 50%;
    border: 1.5px solid var(--bdr); background: transparent;
    color: var(--ink-m); cursor: pointer; font-size: 12px;
    transition: .2s; display: flex; align-items: center; justify-content: center;
}
.sp-card-btn-unsave:hover { border-color: #e74c3c; background: #fef0ef; color: #e74c3c; }

/* ── EMPTY ── */
.sp-empty {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; padding: 100px 20px; text-align: center;
}
.sp-empty-icon {
    width: 100px; height: 100px; border-radius: 50%;
    background: var(--pr-l); border: 2px solid var(--bdr);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 24px;
}
.sp-empty-icon i { font-size: 2.5rem; color: var(--pr); opacity: .5; }
.sp-empty-title { font-family: var(--ff-d); font-size: 1.6rem; color: var(--ink); margin: 0 0 10px; }
.sp-empty-sub { color: var(--ink-m); font-size: 15px; margin: 0 0 28px; }
.sp-btn-explore {
    display: inline-flex; align-items: center; gap: 9px;
    padding: 13px 28px; background: var(--pr); color: var(--wh);
    border-radius: 10px; font-weight: 600; font-size: 14px;
    text-decoration: none; transition: .25s;
}
.sp-btn-explore:hover { background: var(--pr-d); transform: translateY(-2px); color: var(--wh); }

/* ── RESPONSIVE ── */
@media (max-width: 960px) {
    .sp-featured { grid-template-columns: 1fr; }
    .sp-featured-img { min-height: 280px; }
    .sp-featured-body { padding: 28px; }
    .sp-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .sp-header-inner { padding: 20px; }
    .sp-container { padding: 28px 20px 60px; }
    .sp-header-title { font-size: 1.5rem; }
    .sp-featured-title { font-size: 1.5rem; }
    .sp-grid { grid-template-columns: 1fr; }
}
</style>

@endsection