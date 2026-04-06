@extends('layouts.backend')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;1,9..40,400&family=Lora:wght@500;600&display=swap" rel="stylesheet">

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

    /* ── Page header ── */
    .show-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.75rem;
        gap: 1rem;
    }
    .show-header-left h1 {
        font-family: 'Lora', serif;
        font-size: 22px;
        font-weight: 500;
        color: #1c1c1c;
        margin: 0 0 4px;
        letter-spacing: -0.02em;
        line-height: 1.3;
    }
    .show-header-left p {
        font-size: 12px;
        color: #aaa;
        margin: 0;
    }
    .header-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }
    .hbtn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 500;
        border-radius: 9px;
        padding: 8px 14px;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: background 0.15s, transform 0.1s;
        white-space: nowrap;
    }
    .hbtn:active { transform: scale(0.97); }
    .hbtn svg { width: 13px; height: 13px; flex-shrink: 0; }
    .hbtn-edit   { background: #FBF2E3; color: #9A6C18; }
    .hbtn-edit:hover { background: #f5e5c8; color: #9A6C18; text-decoration: none; }
    .hbtn-delete { background: #FCEAEA; color: #A03030; }
    .hbtn-delete:hover { background: #f8d5d5; color: #A03030; }
    .hbtn-back   { background: #f0ede8; color: #555; }
    .hbtn-back:hover { background: #e5e2dc; color: #333; text-decoration: none; }

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

    /* ── Layout ── */
    .show-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 20px;
        align-items: start;
    }

    /* ── Card ── */
    .scard {
        background: #fff;
        border: 1px solid #eae9e5;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 16px;
    }
    .scard:last-child { margin-bottom: 0; }
    .scard-head {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f0ede8;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .scard-head h2 {
        font-size: 13px;
        font-weight: 500;
        color: #1c1c1c;
        margin: 0;
        letter-spacing: -0.01em;
    }
    .count-tag {
        font-size: 11px;
        background: #f0ede8;
        color: #888;
        padding: 2px 8px;
        border-radius: 99px;
    }
    .scard-body { padding: 1.25rem; }

    /* ── Hero image ── */
    .hero-img {
        width: 100%;
        height: 340px;
        object-fit: cover;
        display: block;
    }
    .hero-desc {
        padding: 1.25rem;
    }
    .hero-desc p {
        font-size: 14px;
        color: #444;
        line-height: 1.7;
        margin: 0;
    }
    .section-label {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: #bbb;
        margin-bottom: 10px;
        display: block;
    }

    /* ── Two-col inside main ── */
    .main-cols {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    /* ── Bahan list ── */
    .bahan-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 9px 0;
        border-bottom: 1px solid #f5f4f1;
        font-size: 13px;
    }
    .bahan-row:last-child { border-bottom: none; padding-bottom: 0; }
    .bahan-name { color: #333; }
    .bahan-qty  { color: #888; font-weight: 500; font-size: 12px; }

    /* ── Langkah list ── */
    .step-row {
        display: flex;
        gap: 12px;
        margin-bottom: 14px;
    }
    .step-row:last-child { margin-bottom: 0; }
    .step-num {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #f0ede8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 500;
        color: #555;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .step-text {
        font-size: 13px;
        color: #444;
        line-height: 1.65;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    /* ── Sidebar ── */
    /* Approve/Reject banner */
    .moderation-card {
        background: #fff;
        border: 1px solid #eae9e5;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 16px;
    }
    .mod-head {
        padding: 12px 16px;
        background: #FBF2E3;
        border-bottom: 1px solid #f5e0bb;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .mod-head svg { width: 14px; height: 14px; color: #B07A20; flex-shrink: 0; }
    .mod-head span { font-size: 12px; font-weight: 500; color: #9A6C18; }
    .mod-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .mod-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        font-size: 13px;
        font-weight: 500;
        border: none;
        border-radius: 10px;
        padding: 10px;
        cursor: pointer;
        width: 100%;
        transition: background 0.15s, transform 0.1s;
    }
    .mod-btn:active { transform: scale(0.98); }
    .mod-btn svg { width: 14px; height: 14px; flex-shrink: 0; }
    .mod-approve { background: #EBF5EC; color: #256B33; }
    .mod-approve:hover { background: #d5edda; }
    .mod-reject  { background: #FCEAEA; color: #A03030; }
    .mod-reject:hover  { background: #f8d5d5; }

    /* Already approved/rejected state */
    .status-state {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 16px;
    }
    .status-state svg { width: 15px; height: 15px; flex-shrink: 0; }
    .state-approved { background: #EBF5EC; color: #256B33; border: 1px solid #c8e6cb; }
    .state-rejected { background: #FCEAEA; color: #A03030; border: 1px solid #f5c6c6; }

    /* Rating display */
    .rating-big {
        text-align: center;
        padding: 1.25rem 1rem;
    }
    .rating-num {
        font-family: 'Lora', serif;
        font-size: 40px;
        font-weight: 500;
        color: #1c1c1c;
        line-height: 1;
        margin-bottom: 4px;
    }
    .rating-stars {
        font-size: 18px;
        color: #F5C754;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 6px;
    }
    .rating-sub { font-size: 12px; color: #bbb; }

    /* Info rows */
    .info-row {
        padding: 10px 0;
        border-bottom: 1px solid #f5f4f1;
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-row-label { font-size: 11px; color: #bbb; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 3px; }
    .info-row-val { font-size: 13px; font-weight: 500; color: #333; }

    /* Kategori tags */
    .kat-list { display: flex; flex-wrap: wrap; gap: 6px; }
    .kat-tag {
        font-size: 12px;
        background: #f0ede8;
        color: #555;
        border-radius: 7px;
        padding: 4px 10px;
        font-weight: 500;
    }

    @media (max-width: 900px) {
        .show-layout { grid-template-columns: 1fr; }
        .main-cols { grid-template-columns: 1fr; }
    }
    @media (max-width: 560px) {
        .page-root { padding: 1.25rem 1rem; }
        .show-header { flex-direction: column; }
    }
</style>

<div class="page-root">

    {{-- Header --}}
    <div class="show-header">
        <div class="show-header-left">
            <h1>{{ $resep->judul }}</h1>
            <p>Dibuat oleh {{ $resep->user->name ?? 'Anonim' }} &bull; {{ $resep->created_at->diffForHumans() }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.resep.edit', $resep->id) }}" class="hbtn hbtn-edit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.resep.destroy', $resep->id) }}" method="POST" style="display:contents;">
                @csrf @method('DELETE')
                <button type="submit" class="hbtn hbtn-delete" onclick="return confirm('Hapus resep ini?')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M9 6V4h6v2"/></svg>
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.resep.index') }}" class="hbtn hbtn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert-ok">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="show-layout">

        {{-- ── MAIN CONTENT ── --}}
        <div>
            {{-- Foto + Deskripsi --}}
            <div class="scard">
                @if($resep->foto)
                    <img src="{{ asset('storage/' . $resep->foto) }}" alt="{{ $resep->judul }}" class="hero-img">
                @endif
                <div class="hero-desc">
                    <span class="section-label">Deskripsi</span>
                    <p>{{ $resep->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                </div>
            </div>

            {{-- Bahan & Langkah --}}
            <div class="main-cols">

                {{-- Bahan --}}
                <div class="scard">
                    <div class="scard-head">
                        <h2>Bahan-bahan</h2>
                        <span class="count-tag">{{ $resep->bahan->count() }}</span>
                    </div>
                    <div class="scard-body">
                        @forelse($resep->bahan as $b)
                            <div class="bahan-row">
                                <span class="bahan-name">{{ $b->nama_bahan }}</span>
                                <span class="bahan-qty">{{ $b->jumlah }}</span>
                            </div>
                        @empty
                            <p style="font-size:13px;color:#bbb;margin:0;">Belum ada bahan.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Langkah --}}
                <div class="scard">
                    <div class="scard-head">
                        <h2>Langkah-langkah</h2>
                        <span class="count-tag">{{ $resep->langkah->count() }}</span>
                    </div>
                    <div class="scard-body">
                        @forelse($resep->langkah->sortBy('nomor_langkah') as $l)
                            <div class="step-row">
                                <div class="step-num">{{ $l->nomor_langkah }}</div>
                                <p class="step-text">{{ $l->deskripsi_langkah }}</p>
                            </div>
                        @empty
                            <p style="font-size:13px;color:#bbb;margin:0;">Belum ada langkah.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

        {{-- ── SIDEBAR ── --}}
        <div>

            {{-- Moderasi --}}
            @if($resep->status == 'pending')
            <div class="moderation-card">
                <div class="mod-head">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>Menunggu Persetujuan</span>
                </div>
                <div class="mod-body">
                    <form action="{{ route('admin.resep.approve', $resep->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="mod-btn mod-approve">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Setujui Resep
                        </button>
                    </form>
                    <form action="{{ route('admin.resep.reject', $resep->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="mod-btn mod-reject" onclick="return confirm('Tolak resep ini?')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Tolak Resep
                        </button>
                    </form>
                </div>
            </div>
            @elseif($resep->status == 'approved')
            <div class="status-state state-approved">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                Resep telah disetujui
            </div>
            @else
            <div class="status-state state-rejected">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Resep telah ditolak
            </div>
            @endif

            {{-- Rating --}}
            <div class="scard">
                <div class="rating-big">
                    <div class="rating-num">{{ number_format($resep->avg_rating ?? 0, 1) }}</div>
                    @php
                        $stars = round($resep->avg_rating ?? 0);
                    @endphp
                    <span class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $stars ? '★' : '☆' }}
                        @endfor
                    </span>
                    <span class="rating-sub">{{ $resep->rating_count ?? 0 }} ulasan &bull; {{ $resep->saved_count ?? 0 }} disimpan</span>
                </div>
            </div>

            {{-- Informasi --}}
            <div class="scard">
                <div class="scard-head"><h2>Informasi</h2></div>
                <div class="scard-body">
                    <div class="info-row">
                        <div class="info-row-label">Waktu Memasak</div>
                        <div class="info-row-val">{{ $resep->waktu_masak ?? '—' }} menit</div>
                    </div>
                    <div class="info-row">
                        <div class="info-row-label">Tanggal Publish</div>
                        <div class="info-row-val">
                            {{ $resep->tanggal_publish
                                ? \Carbon\Carbon::parse($resep->tanggal_publish)->format('d M Y, H:i')
                                : '—' }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-row-label">Terakhir Diupdate</div>
                        <div class="info-row-val">{{ $resep->updated_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-row-label">Status</div>
                        <div class="info-row-val">
                            @if($resep->status == 'pending')
                                <span style="color:#B07A20;">Pending</span>
                            @elseif($resep->status == 'approved')
                                <span style="color:#256B33;">Approved</span>
                            @else
                                <span style="color:#A03030;">Rejected</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kategori --}}
            <div class="scard">
                <div class="scard-head"><h2>Kategori</h2></div>
                <div class="scard-body">
                    @forelse($resep->kategori as $kat)
                        <div class="kat-list">
                            <span class="kat-tag">{{ $kat->nama_kategori }}</span>
                        </div>
                    @empty
                        <p style="font-size:13px;color:#bbb;margin:0;">Belum ada kategori.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

@endsection