@extends('layouts.backend')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;1,9..40,400&family=Lora:wght@500&display=swap" rel="stylesheet">

<style>
    .page-root * { box-sizing: border-box; }
    .page-root {
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: #1c1c1c;
        padding: 2rem 2.5rem;
        background: #f7f6f3;
        min-height: 100vh;
    }

    /* ── Header ── */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.75rem;
    }
    .page-header h1 {
        font-family: 'Lora', serif;
        font-size: 22px;
        font-weight: 500;
        margin: 0 0 4px;
        letter-spacing: -0.02em;
        color: #1c1c1c;
    }
    .page-header p {
        font-size: 13px;
        color: #999;
        margin: 0;
    }
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 500;
        color: #fff;
        background: #1c1c1c;
        border: none;
        border-radius: 10px;
        padding: 9px 18px;
        text-decoration: none;
        transition: background 0.15s, transform 0.15s;
        white-space: nowrap;
    }
    .btn-add:hover { background: #333; color: #fff; text-decoration: none; transform: translateY(-1px); }

    /* ── Alert ── */
    .alert-ok {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #EBF5EC;
        color: #2E8B41;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 1.5rem;
        border: 1px solid #c8e6cb;
    }

    /* ── Filter Box ── */
    .filter-box {
        background: #fff;
        border: 1px solid #eae9e5;
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.75rem;
    }
    .filter-label {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #bbb;
        display: block;
        margin-bottom: 6px;
    }
    .filter-input {
        width: 100%;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        color: #1c1c1c;
        background: #faf9f7;
        border: 1px solid #eae9e5;
        border-radius: 8px;
        padding: 8px 12px;
        outline: none;
        transition: border-color 0.15s;
        -webkit-appearance: none;
    }
    .filter-input:focus { border-color: #aaa; background: #fff; }
    .btn-filter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 500;
        color: #fff;
        background: #1c1c1c;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        cursor: pointer;
        transition: background 0.15s;
        white-space: nowrap;
    }
    .btn-filter:hover { background: #333; }
    .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: #999;
        background: #f0ede8;
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
    }
    .btn-reset:hover { background: #e5e2dc; color: #555; text-decoration: none; }

    /* ── Cards Grid ── */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 2rem;
    }

    /* ── Recipe Card ── */
    .recipe-card {
        background: #fff;
        border: 1px solid #eae9e5;
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .recipe-card:hover {
        box-shadow: 0 6px 24px rgba(0,0,0,0.07);
        transform: translateY(-2px);
    }

    /* ── Image ── */
    .card-img-wrap {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: #f0ede8;
    }
    .card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .recipe-card:hover .card-img-wrap img { transform: scale(1.04); }
    .no-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ccc;
    }
    .no-img svg { width: 36px; height: 36px; }

    /* Status badge on image */
    .status-pill {
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 3px 9px;
        border-radius: 99px;
        backdrop-filter: blur(4px);
    }
    .status-pill.pending  { background: rgba(251,242,227,0.92); color: #9A6C18; }
    .status-pill.approved { background: rgba(235,245,236,0.92); color: #256B33; }
    .status-pill.rejected { background: rgba(252,234,234,0.92); color: #A03030; }

    /* Kategori badge */
    .kat-pill {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 10px;
        font-weight: 500;
        color: #fff;
        background: rgba(28,28,28,0.55);
        backdrop-filter: blur(4px);
        padding: 3px 9px;
        border-radius: 99px;
    }

    /* ── Card Body ── */
    .card-body-inner {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .card-title {
        font-size: 14px;
        font-weight: 500;
        color: #1c1c1c;
        margin: 0 0 6px;
        line-height: 1.4;
    }
    .card-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        color: #aaa;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }
    .card-meta span { display: flex; align-items: center; gap: 4px; }
    .card-rating {
        font-size: 12px;
        font-weight: 500;
        color: #B07A20;
        display: flex;
        align-items: center;
        gap: 3px;
        margin-bottom: 10px;
    }
    .rating-dot { color: #F5C754; font-size: 13px; }

    /* Time badge */
    .time-tag {
        display: inline-block;
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 6px;
        font-weight: 500;
        margin-bottom: 12px;
    }
    .time-fast { background: #E4F4F1; color: #1F8A76; }
    .time-mid  { background: #FBF2E3; color: #B07A20; }
    .time-slow { background: #FCEAEA; color: #C04040; }

    /* ── Actions ── */
    .card-actions {
        margin-top: auto;
        display: flex;
        gap: 6px;
    }
    .card-actions form { display: contents; }

    .act-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        padding: 7px 12px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s, transform 0.1s;
        white-space: nowrap;
    }
    .act-btn:active { transform: scale(0.97); }
    .act-btn svg { width: 13px; height: 13px; flex-shrink: 0; }

    .act-view   { background: #EBF2FC; color: #2E72C2; flex-shrink: 0; }
    .act-view:hover { background: #d6e7f8; color: #2E72C2; text-decoration: none; }

    .act-approve { background: #EBF5EC; color: #256B33; flex: 1; }
    .act-approve:hover { background: #d5edda; color: #256B33; text-decoration: none; }

    .act-reject  { background: #FCEAEA; color: #A03030; flex: 1; }
    .act-reject:hover { background: #f8d5d5; color: #A03030; text-decoration: none; }

    .act-edit    { background: #FBF2E3; color: #9A6C18; flex: 1; }
    .act-edit:hover { background: #f5e5c8; color: #9A6C18; text-decoration: none; }

    .act-delete  { background: #FCEAEA; color: #A03030; flex-shrink: 0; }
    .act-delete:hover { background: #f8d5d5; color: #A03030; }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #bbb;
    }
    .empty-state svg { width: 56px; height: 56px; margin-bottom: 1rem; opacity: 0.35; }
    .empty-state h5 { font-size: 16px; color: #888; margin-bottom: 6px; }
    .empty-state p  { font-size: 13px; color: #bbb; margin-bottom: 1rem; }
    .btn-reset-empty {
        font-size: 13px;
        font-weight: 500;
        color: #2E72C2;
        background: #EBF2FC;
        border: none;
        border-radius: 8px;
        padding: 8px 18px;
        cursor: pointer;
        text-decoration: none;
    }
    .btn-reset-empty:hover { background: #d6e7f8; color: #2E72C2; text-decoration: none; }

    /* ── Pagination ── */
    .pagination-wrap {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }
    .pagination-wrap .pagination .page-link {
        font-size: 13px;
        border-radius: 8px !important;
        border: 1px solid #eae9e5;
        color: #555;
        padding: 6px 12px;
        margin: 0 2px;
    }
    .pagination-wrap .pagination .page-item.active .page-link {
        background: #1c1c1c;
        border-color: #1c1c1c;
        color: #fff;
    }

    @media (max-width: 1100px) { .cards-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 800px)  { .cards-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px)  {
        .page-root { padding: 1.25rem 1rem; }
        .cards-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="page-root">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1>Daftar Resep</h1>
            <p>Kelola semua resep kuliner dengan mudah</p>
        </div>
        <a href="{{ route('admin.resep.create') }}" class="btn-add">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Resep
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert-ok">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Filter --}}
    <div class="filter-box">
        <form method="GET" action="{{ route('admin.resep.index') }}">
            <div class="row g-3 align-items-end">

                <div class="col-xl-3 col-lg-3 col-md-6">
                    <label class="filter-label">Cari Judul</label>
                    <input type="text" name="search" class="filter-input"
                        placeholder="Contoh: Nasi Goreng..." value="{{ request('search') }}">
                </div>

                <div class="col-xl-2 col-lg-2 col-md-6">
                    <label class="filter-label">Kategori</label>
                    <select name="kategori" class="filter-input">
                        <option value="">Semua</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->nama_kategori }}"
                                {{ request('kategori') == $kat->nama_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-6">
                    <label class="filter-label">Durasi</label>
                    <select name="waktu" class="filter-input">
                        <option value="">Semua</option>
                        <option value="kilat"  {{ request('waktu') == 'kilat'  ? 'selected' : '' }}>≤ 15 menit</option>
                        <option value="sedang" {{ request('waktu') == 'sedang' ? 'selected' : '' }}>16–45 menit</option>
                        <option value="lama"   {{ request('waktu') == 'lama'   ? 'selected' : '' }}>> 45 menit</option>
                    </select>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-6">
                    <label class="filter-label">Urutkan</label>
                    <select name="sort" class="filter-input">
                        <option value="terbaru"         {{ request('sort','terbaru') == 'terbaru'         ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama"         {{ request('sort') == 'terlama'                   ? 'selected' : '' }}>Terlama</option>
                        <option value="rating_tertinggi"{{ request('sort') == 'rating_tertinggi'          ? 'selected' : '' }}>Rating Tertinggi</option>
                        <option value="rating_terendah" {{ request('sort') == 'rating_terendah'           ? 'selected' : '' }}>Rating Terendah</option>
                        <option value="judul_az"        {{ request('sort') == 'judul_az'                  ? 'selected' : '' }}>Judul A–Z</option>
                    </select>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-12">
                    <label class="filter-label">Rating Minimum</label>
                    <div class="d-flex gap-2">
                        <input type="number" step="0.1" min="0" max="5" name="rating_min" class="filter-input"
                            style="width:90px;" placeholder="0.0" value="{{ request('rating_min') }}">
                        <button type="submit" class="btn-filter">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                            Filter
                        </button>
                        <a href="{{ route('admin.resep.index') }}" class="btn-reset" title="Reset">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- Cards --}}
    @if($resep->count())
    <div class="cards-grid">
        @foreach($resep as $item)
        @php $w = $item->waktu_masak ?? 0; @endphp
        <div class="recipe-card">

            {{-- Image --}}
            <div class="card-img-wrap">
                @if($item->foto)
                    <img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->judul }}">
                @else
                    <div class="no-img">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                            <path d="M3 2h18l-2 13H5L3 2z"/><path d="M3 2 1 0"/><circle cx="9" cy="20" r="1"/><circle cx="20" cy="20" r="1"/>
                        </svg>
                    </div>
                @endif

                <span class="status-pill {{ $item->status }}">{{ $item->status }}</span>

                @if($item->kategori->count())
                <span class="kat-pill">{{ $item->kategori->first()->nama_kategori }}</span>
                @endif
            </div>

            {{-- Body --}}
            <div class="card-body-inner">
                <p class="card-title">{{ Str::limit($item->judul, 42) }}</p>

                <div class="card-meta">
                    <span>
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        {{ $item->user->name ?? 'Admin' }}
                    </span>
                </div>

                <div class="card-rating">
                    <span class="rating-dot">★</span>
                    {{ number_format($item->avg_rating ?? 0, 1) }}
                    <span style="color:#ccc;font-weight:400;">({{ $item->rating_count ?? 0 }})</span>
                    @if(($item->avg_rating ?? 0) >= 4.5)
                        <span style="font-size:10px;background:#FBF2E3;color:#B07A20;padding:2px 7px;border-radius:99px;margin-left:4px;font-weight:500;">Top</span>
                    @endif
                </div>

                <div>
                    @if($w <= 15)
                        <span class="time-tag time-fast">≤ 15 menit</span>
                    @elseif($w <= 45)
                        <span class="time-tag time-mid">16–45 menit</span>
                    @else
                        <span class="time-tag time-slow">> 45 menit</span>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="card-actions">
                    <a href="{{ route('admin.resep.show', $item->id) }}" class="act-btn act-view" title="Lihat Detail">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>

                    @if($item->status == 'pending')
                        <form action="{{ route('admin.resep.approve', $item->id) }}" method="POST" style="flex:1;">
                            @csrf
                            <button type="submit" class="act-btn act-approve w-100">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Setuju
                            </button>
                        </form>
                        <form action="{{ route('admin.resep.reject', $item->id) }}" method="POST" style="flex:1;">
                            @csrf
                            <button type="submit" class="act-btn act-reject w-100" onclick="return confirm('Tolak resep ini?')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Tolak
                            </button>
                        </form>
                    @else
                        <a href="{{ route('admin.resep.edit', $item->id) }}" class="act-btn act-edit" style="flex:1;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.resep.destroy', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="act-btn act-delete" onclick="return confirm('Hapus resep ini?')" title="Hapus">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="pagination-wrap">
        {{ $resep->links('pagination::bootstrap-5') }}
    </div>

    @else
    <div class="empty-state">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <h5>Resep tidak ditemukan</h5>
        <p>Coba ganti kata kunci atau reset filter.</p>
        <a href="{{ route('admin.resep.index') }}" class="btn-reset-empty">Reset Filter</a>
    </div>
    @endif

</div>

@endsection