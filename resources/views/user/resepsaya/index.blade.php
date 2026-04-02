@extends('layouts.frontend')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')
<div class="rs-page">

    {{-- HEADER --}}
    <div class="rs-header">
        <div class="rs-header-inner">
            <div>
                <p class="rs-eyebrow">
                    @if(auth()->user()->role == 'admin')
                        <i class="fas fa-shield-alt"></i> Mode Admin
                    @else
                        <i class="fas fa-utensils"></i> Dapur Saya
                    @endif
                </p>
                <h1 class="rs-title">
                    {{ auth()->user()->role == 'admin' ? 'Semua Resep' : 'Resep Saya' }}
                </h1>
            </div>
            <a href="{{ route('user.resepsaya.create') }}" class="rs-btn-add">
                <i class="fas fa-plus"></i>
                <span>Tambah Resep</span>
            </a>
        </div>
    </div>

    <div class="rs-container">

        @if($reseps->count())

        {{-- STATS BAR --}}
        <div class="rs-stats">
            <div class="rs-stat">
                <span class="rs-stat-num">{{ $reseps->count() }}</span>
                <span class="rs-stat-label">Total Resep</span>
            </div>
            <div class="rs-stat-div"></div>
            <div class="rs-stat">
                <span class="rs-stat-num">{{ $reseps->flatMap->kategori->unique('id')->count() }}</span>
                <span class="rs-stat-label">Kategori</span>
            </div>
            <div class="rs-stat-div"></div>
            <div class="rs-stat">
                <span class="rs-stat-num">{{ $reseps->filter(fn($r) => $r->created_at->isCurrentMonth())->count() }}</span>
                <span class="rs-stat-label">Bulan Ini</span>
            </div>
        </div>

        {{-- RECIPE LIST --}}
        <div class="rs-list">
            @foreach($reseps as $resep)
            <div class="rs-item" style="--i:{{ $loop->index }}">
                {{-- THUMBNAIL --}}
                <a href="{{ route('user.resepsaya.show', $resep->id) }}" class="rs-thumb-wrap">
                    @if($resep->foto)
                        <img src="{{ asset('storage/' . $resep->foto) }}" alt="{{ $resep->judul }}" class="rs-thumb">
                    @else
                        <div class="rs-thumb rs-thumb-empty">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                    
                    {{-- Badge Status di Pojok Foto (Mobile friendly) --}}
                    @if(auth()->user()->role != 'admin')
                        <div class="rs-badge-floating">
                            @if($resep->status == 'pending')
                                <span class="rs-status-badge rs-status-pending"><i class="fas fa-clock"></i> Pending</span>
                            @elseif($resep->status == 'approved')
                                <span class="rs-status-badge rs-status-approved"><i class="fas fa-check-circle"></i> Terbit</span>
                            @else
                                <span class="rs-status-badge rs-status-rejected"><i class="fas fa-times-circle"></i> Ditolak</span>
                            @endif
                        </div>
                    @endif
                    <div class="rs-thumb-shine"></div>
                </a>

                {{-- INFO --}}
                <div class="rs-item-info">
                    @if($resep->kategori->isNotEmpty())
                    <p class="rs-item-cat">{{ $resep->kategori->pluck('nama_kategori')->join(' · ') }}</p>
                    @endif
                    
                    <a href="{{ route('user.resepsaya.show', $resep->id) }}" class="rs-item-title-link">
                        <h3 class="rs-item-title">{{ $resep->judul }}</h3>
                    </a>

                    @if($resep->deskripsi)
                    <p class="rs-item-desc">{{ \Illuminate\Support\Str::limit($resep->deskripsi, 110) }}</p>
                    @endif

                    <div class="rs-item-meta">
                        @if(auth()->user()->role == 'admin')
                        <span class="rs-meta-chip rs-chip-admin"><i class="fas fa-user"></i> {{ $resep->user->name ?? 'Anonim' }}</span>
                        @endif
                        @if($resep->waktu_masak)
                        <span class="rs-meta-chip"><i class="fas fa-clock"></i> {{ $resep->waktu_masak }} menit</span>
                        @endif
                        <span class="rs-meta-chip"><i class="fas fa-calendar-alt"></i> {{ $resep->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="rs-item-actions">
                    <a href="{{ route('user.resepsaya.show', $resep->id) }}" class="rs-action-btn rs-action-view" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                        <span>Lihat</span>
                    </a>

                    {{-- Tombol Edit: Hanya muncul jika Pending atau User adalah Admin --}}
                    @if(auth()->user()->role == 'admin' || $resep->status == 'pending')
                    <a href="{{ route('user.resepsaya.edit', $resep->id) }}" class="rs-action-btn rs-action-edit" title="Edit Resep">
                        <i class="fas fa-pencil-alt"></i>
                        <span>Edit</span>
                    </a>
                    @endif

                    <form action="{{ route('user.resepsaya.destroy', $resep->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus resep ini?')" style="margin:0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rs-action-btn rs-action-del" title="Hapus Resep">
                            <i class="fas fa-trash-alt"></i>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        @if(method_exists($reseps, 'links'))
        <div class="rs-pagination">
            {{ $reseps->links() }}
        </div>
        @endif

        @else

        {{-- EMPTY STATE --}}
        <div class="rs-empty">
            <div class="rs-empty-plate">
                <i class="fas fa-utensils"></i>
            </div>
            <h3 class="rs-empty-title">Dapur masih kosong</h3>
            <p class="rs-empty-sub">Bagikan resep andalan kamu dan inspirasi orang lain!</p>
            <a href="{{ route('user.resepsaya.create') }}" class="rs-btn-add rs-btn-add-lg">
                <i class="fas fa-plus"></i>
                <span>Tambah Resep Pertama</span>
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
    --grn:  #2e7d52;
    --grn-l:#edf7f2;
    --ylw:  #c47c0a;
    --ylw-l:#fdf6e3;
    --red:  #c0392b;
    --red-l:#fdf0ef;
    --ink:  #2a1a10;
    --ink-s:#6b4e3d;
    --ink-m:#a88070;
    --bdr:  #e8d0c0;
    --bg:   #fdf8f4;
    --wh:   #ffffff;
    --r:    14px;
    --sh:   0 2px 16px rgba(100,40,10,.09);
    --sh-h: 0 8px 32px rgba(100,40,10,.16);
    --ff-d: 'Playfair Display', Georgia, serif;
    --ff-b: 'DM Sans', sans-serif;
}

.rs-page { background: var(--bg); min-height: 100vh; font-family: var(--ff-b); color: var(--ink); }

/* ── HEADER ── */
.rs-header { background: var(--wh); border-bottom: 1px solid var(--bdr); }
.rs-header-inner { max-width: 1100px; margin: 0 auto; padding: 28px 40px; display: flex; align-items: center; justify-content: space-between; }
.rs-eyebrow { margin: 0 0 5px; font-size: 11px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--pr); }
.rs-title { font-family: var(--ff-d); font-size: 2rem; font-weight: 700; color: var(--ink); margin: 0; line-height: 1; }

.rs-btn-add { 
    display: inline-flex; align-items: center; gap: 9px; padding: 12px 24px; 
    background: var(--pr); color: var(--wh); border-radius: 10px; font-weight: 600; 
    font-size: 14px; text-decoration: none; transition: .25s; border: none; cursor: pointer; 
}
.rs-btn-add:hover { background: var(--pr-d); color: var(--wh); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(184,74,30,.3); }

/* ── CONTAINER ── */
.rs-container { max-width: 1100px; margin: 0 auto; padding: 40px 40px 80px; }

/* ── STATS ── */
.rs-stats { 
    display: flex; align-items: center; background: var(--wh); border: 1px solid var(--bdr); 
    border-radius: var(--r); padding: 22px 32px; margin-bottom: 32px; box-shadow: var(--sh); 
}
.rs-stat { display: flex; flex-direction: column; align-items: center; flex: 1; }
.rs-stat-num { font-family: var(--ff-d); font-size: 2.2rem; font-weight: 700; color: var(--pr); line-height: 1; }
.rs-stat-label { font-size: 12px; color: var(--ink-m); margin-top: 4px; }
.rs-stat-div { width: 1px; height: 40px; background: var(--bdr); margin: 0 16px; }

/* ── LIST ── */
.rs-list { display: flex; flex-direction: column; gap: 16px; }
.rs-item { 
    background: var(--wh); border: 1px solid var(--bdr); border-radius: var(--r); 
    box-shadow: var(--sh); display: flex; align-items: center; overflow: hidden; 
    transition: .3s; animation: rs-in .45s ease both; animation-delay: calc(var(--i, 0) * 0.05s);
}
.rs-item:hover { box-shadow: var(--sh-h); transform: translateY(-2px); }

@keyframes rs-in { from { opacity: 0; transform: translateX(-12px); } to { opacity: 1; transform: translateX(0); } }

/* THUMBNAIL */
.rs-thumb-wrap { flex-shrink: 0; width: 180px; height: 140px; position: relative; overflow: hidden; }
.rs-thumb { width: 100%; height: 100%; object-fit: cover; transition: transform 6s ease; }
.rs-item:hover .rs-thumb { transform: scale(1.1); }
.rs-thumb-empty { background: #f0ddd0; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--ink-m); font-size: 2rem; }

/* BADGES */
.rs-badge-floating { position: absolute; top: 10px; left: 10px; z-index: 2; }
.rs-status-badge { 
    font-size: 10px; font-weight: 700; text-transform: uppercase; padding: 4px 10px; 
    border-radius: 6px; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.rs-status-pending { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
.rs-status-approved { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
.rs-status-rejected { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

/* INFO */
.rs-item-info { flex: 1; padding: 20px 24px; min-width: 0; }
.rs-item-cat { margin: 0 0 5px; font-size: 10.5px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--pr); }
.rs-item-title { font-family: var(--ff-d); font-size: 1.25rem; font-weight: 700; color: var(--ink); margin: 0 0 7px; transition: .2s; }
.rs-item-title-link { text-decoration: none; }
.rs-item-title-link:hover .rs-item-title { color: var(--pr); }
.rs-item-desc { font-size: 13.5px; color: var(--ink-s); line-height: 1.5; margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.rs-item-meta { display: flex; gap: 12px; flex-wrap: wrap; }
.rs-meta-chip { font-size: 11.5px; color: var(--ink-m); display: flex; align-items: center; gap: 5px; }
.rs-meta-chip i { color: var(--acc); font-size: 10px; }

/* ACTIONS */
.rs-item-actions { 
    display: flex; flex-direction: column; gap: 8px; padding: 20px; 
    border-left: 1px solid #f5e8df; background: #fdf9f7; justify-content: center;
}
.rs-action-btn { 
    display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; 
    border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; transition: .2s; border: none; cursor: pointer;
}
.rs-action-view { background: #edf7f2; color: #2e7d52; }
.rs-action-view:hover { background: #2e7d52; color: #fff; }
.rs-action-edit { background: #fef3c7; color: #d97706; }
.rs-action-edit:hover { background: #d97706; color: #fff; }
.rs-action-del { background: #fee2e2; color: #dc2626; width: 100%; }
.rs-action-del:hover { background: #dc2626; color: #fff; }

@media (max-width: 768px) {
    .rs-item { flex-direction: column; align-items: flex-start; }
    .rs-thumb-wrap { width: 100%; height: 200px; }
    .rs-item-actions { flex-direction: row; width: 100%; border-left: none; border-top: 1px solid #f5e8df; }
    .rs-action-btn { flex: 1; justify-content: center; }
}
</style>
@endsection