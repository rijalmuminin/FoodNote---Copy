@extends('layouts.frontend')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
/* ── TOKENS ── */
:root {
    --ac:     #b85c2a;
    --ac2:    #d4784a;
    --dk:     #1e1510;
    --ink2:   #4a3f38;
    --mute:   #8a7d76;
    --cream:  #f7f3ee;
    --paper:  #ffffff;
    --bd:     #e8e0d8;
    --danger: #dc3545;
    --fh:     'Cormorant Garamond', serif;
    --fb:     'Outfit', sans-serif;
    --r:      14px;
    --r-lg:   22px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--fb); background: var(--cream); color: var(--dk); }
a { text-decoration: none; }
img { display: block; }

/* ── PAGE ── */
.pf-page {
    max-width: 1060px;
    margin: 0 auto;
    padding: 2.8rem 1.5rem 5rem;
    animation: pf-fadein .5s ease both;
}

@keyframes pf-fadein {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── HERO CARD ── */
.pf-hero {
    background: var(--paper);
    border-radius: var(--r-lg);
    border: 1px solid var(--bd);
    margin-bottom: 1.6rem;
    overflow: hidden;
    position: relative;
}

.pf-hero-strip {
    height: 4px;
    background: linear-gradient(90deg, var(--ac) 0%, var(--ac2) 60%, #e8a060 100%);
}

.pf-hero-body {
    padding: 2.4rem 2.6rem 0;
    display: flex;
    align-items: flex-start;
    gap: 2rem;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}

.pf-avatar-wrap { flex-shrink: 0; position: relative; }
.pf-avatar, .pf-avatar-init { width: 100px; height: 100px; border-radius: 50%; }
.pf-avatar { object-fit: cover; border: 3px solid var(--bd); }
.pf-avatar-init {
    background: linear-gradient(135deg, var(--ac) 0%, var(--ac2) 100%);
    display: flex; align-items: center; justify-content: center;
    font-family: var(--fh); font-size: 2.4rem; font-weight: 600; color: #fff; border: 3px solid var(--bd);
}

.pf-info { flex: 1; padding-top: .2rem; }
.pf-name { font-family: var(--fh); font-size: 2rem; font-weight: 600; color: var(--dk); margin-bottom: .5rem; }
.pf-meta-list { display: flex; flex-direction: column; gap: .28rem; }
.pf-meta-item { display: flex; align-items: center; gap: .5rem; font-size: .78rem; color: var(--mute); }
.pf-meta-item i { width: 13px; text-align: center; color: var(--ac); font-size: .72rem; }

.pf-stats { display: flex; margin-top: 2rem; border-top: 1px solid var(--bd); }
.pf-stat { flex: 1; text-align: center; padding: 1.3rem .5rem; border-right: 1px solid var(--bd); }
.pf-stat:last-child { border-right: none; }
.pf-stat-val { font-family: var(--fh); font-size: 1.75rem; font-weight: 600; color: var(--dk); line-height: 1; }
.pf-stat-lbl { font-size: .67rem; color: var(--mute); text-transform: uppercase; font-weight: 500; }

/* ── TABS ── */
.pf-tabs { display: flex; gap: .35rem; padding: .4rem; background: var(--paper); border: 1px solid var(--bd); border-radius: 13px; margin-bottom: 1.6rem; }
.pf-tab { flex: 1; display: flex; align-items: center; justify-content: center; gap: .4rem; padding: .62rem 1rem; border-radius: 9px; font-size: .8rem; font-weight: 500; color: var(--mute); border: none; background: none; cursor: pointer; }
.pf-tab.active { background: var(--ac); color: #fff; }

/* ── PANELS ── */
.pf-panel { display: none; }
.pf-panel.active { display: block; animation: pf-fadein .3s ease both; }
.pf-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.1rem; }

/* ── RECIPE CARD ── */
.pf-card { background: var(--paper); border-radius: var(--r); border: 1px solid var(--bd); overflow: hidden; display: flex; flex-direction: column; transition: transform .22s; }
.pf-card-img { position: relative; height: 165px; overflow: hidden; background: var(--bd); }
.pf-card-img img { width: 100%; height: 100%; object-fit: cover; }

/* REJECTED STYLES */
.pf-card.is-rejected { opacity: 0.85; }
.pf-card.is-rejected .pf-card-img img { filter: grayscale(1); }

.pf-card-badge-rejected {
    position: absolute;
    top: 8px; left: 8px;
    background: var(--danger);
    color: #fff;
    font-size: .67rem;
    font-weight: 700;
    padding: .2rem .6rem;
    border-radius: 6px;
    z-index: 2;
    text-transform: uppercase;
}

.pf-card-body { padding: .95rem 1.1rem 1.1rem; display: flex; flex-direction: column; flex: 1; }
.pf-card-title { font-family: var(--fh); font-size: 1.05rem; font-weight: 600; color: var(--dk); margin-bottom: .55rem; }
.pf-card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: .7rem; }

.pf-card-link { font-size: .72rem; font-weight: 500; color: var(--ac); border: 1px solid var(--bd); padding: .3rem .8rem; border-radius: 999px; }
.pf-card-link.disabled { background: #f3f3f3; color: #aaa; border-color: #eee; cursor: not-allowed; pointer-events: none; }

/* ── EMPTY STATE ── */
.pf-empty { text-align: center; padding: 4.5rem 1rem; }
.pf-empty-btn { background: var(--ac); color: #fff; padding: .58rem 1.4rem; border-radius: 999px; font-size: .78rem; font-weight: 500; }

@media (max-width: 860px) { .pf-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px) { .pf-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="pf-page">

    {{-- HERO CARD --}}
    <div class="pf-hero">
        <div class="pf-hero-strip"></div>
        <div class="pf-hero-body">
            <div class="pf-avatar-wrap">
                @if($user->foto ?? null)
                    <img class="pf-avatar" src="{{ asset('storage/'.$user->foto) }}" alt="{{ $user->name }}">
                @else
                    <div class="pf-avatar-init">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                @endif
            </div>
            <div class="pf-info">
                <h1 class="pf-name">{{ $user->name }}</h1>
                <div class="pf-meta-list">
                    <span class="pf-meta-item"><i class="fas fa-envelope"></i> {{ $user->email }}</span>
                    <span class="pf-meta-item"><i class="fas fa-calendar-alt"></i> Bergabung {{ $user->created_at->translatedFormat('F Y') }}</span>
                </div>
            </div>
        </div>

        <div class="pf-stats">
            <div class="pf-stat">
                <div class="pf-stat-val">{{ $reseps->count() }}</div>
                <div class="pf-stat-lbl">Resep Dibuat</div>
            </div>
            <div class="pf-stat">
                <div class="pf-stat-val">{{ $resepSimpan->count() }}</div>
                <div class="pf-stat-lbl">Disimpan</div>
            </div>
            <div class="pf-stat">
                <div class="pf-stat-val">{{ number_format($reseps->avg('avg_rating') ?? 0, 1) }}</div>
                <div class="pf-stat-lbl">Avg Rating</div>
            </div>
        </div>
    </div>

    {{-- TABS --}}
    <div class="pf-tabs">
        <button class="pf-tab active" onclick="switchTab('resepku', this)">
            <i class="fas fa-utensils"></i> Resep Saya
        </button>
        <button class="pf-tab" onclick="switchTab('simpan', this)">
            <i class="fas fa-heart"></i> Disimpan
        </button>
    </div>

    {{-- PANEL: RESEP SAYA --}}
    <div class="pf-panel active" id="panel-resepku">
        @if($reseps->count())
            <div class="pf-grid">
                @foreach($reseps as $resep)
                <div class="pf-card {{ $resep->status == 'rejected' ? 'is-rejected' : '' }}">
                    <div class="pf-card-img">
                        <img src="{{ $resep->foto ? asset('storage/'.$resep->foto) : asset('assets/img/no-image.png') }}" alt="{{ $resep->judul }}">
                        
                        {{-- Badge Ditolak --}}
                        @if($resep->status == 'rejected')
                            <span class="pf-card-badge-rejected">
                                <i class="fas fa-times-circle me-1"></i> Ditolak
                            </span>
                        @endif
                    </div>
                    <div class="pf-card-body">
                        <h5 class="pf-card-title">{{ $resep->judul }}</h5>
                        <div class="pf-card-footer">
                            <span class="pf-card-meta">
                                <i class="fas fa-info-circle"></i> Status: {{ ucfirst($resep->status) }}
                            </span>

                            @if($resep->status == 'rejected')
                                <span class="pf-card-link disabled">Ditolak</span>
                            @else
                                <a href="{{ route('user.resep.show', $resep->id) }}" class="pf-card-link">Lihat</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="pf-empty">
                <h5>Belum ada resep</h5>
                <a href="{{ route('user.resepsaya.create') }}" class="pf-empty-btn">Buat Resep</a>
            </div>
        @endif
    </div>

    {{-- PANEL: DISIMPAN --}}
    <div class="pf-panel" id="panel-simpan">
        @if($resepSimpan->count())
            <div class="pf-grid">
                @foreach($resepSimpan as $resep)
                <div class="pf-card">
                    <div class="pf-card-img">
                        <img src="{{ $resep->foto ? asset('storage/'.$resep->foto) : asset('assets/img/no-image.png') }}" alt="{{ $resep->judul }}">
                    </div>
                    <div class="pf-card-body">
                        <h5 class="pf-card-title">{{ $resep->judul }}</h5>
                        <div class="pf-card-footer">
                            <span class="pf-card-meta"><i class="fas fa-user"></i> {{ Str::limit($resep->user->name ?? 'Anonim', 14) }}</span>
                            <a href="{{ route('user.resep.show', $resep->id) }}" class="pf-card-link">Lihat</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="pf-empty">
                <h5>Belum ada resep disimpan</h5>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function switchTab(panel, btn) {
    document.querySelectorAll('.pf-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.pf-tab').forEach(b => b.classList.remove('active'));
    document.getElementById('panel-' + panel).classList.add('active');
    btn.classList.add('active');
}
</script>
@endpush