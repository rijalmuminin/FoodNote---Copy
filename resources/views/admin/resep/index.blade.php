@extends('layouts.backend')

@section('content')
<div class="container-fluid px-3 px-md-4">

    {{-- HEADER --}}
    <div class="header-box mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold text-dark mb-1">Daftar Resep</h4>
            <p class="text-muted small mb-0">Kelola semua resep kuliner dengan mudah</p>
        </div>

        <a href="{{ route('admin.resep.create') }}" class="btn-add text-decoration-none">
            <i class="fas fa-plus me-1"></i> Tambah Resep
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert-box mb-4">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- FILTER & SORT BOX --}}
    <div class="filter-box mb-4">
        <form method="GET" action="{{ route('admin.resep.index') }}" class="row g-3 align-items-end">

            <div class="col-xl-3 col-lg-3 col-md-6">
                <label class="label">CARI JUDUL</label>
                <input type="text" name="search" class="input"
                    placeholder="Contoh: Nasi Goreng..." value="{{ request('search') }}">
            </div>

            <div class="col-xl-2 col-lg-2 col-md-6">
                <label class="label">KATEGORI</label>
                <select name="kategori" class="input">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->nama_kategori }}"
                        {{ request('kategori') == $kat->nama_kategori ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-xl-2 col-lg-2 col-md-6">
                <label class="label">DURASI</label>
                <select name="waktu" class="input">
                    <option value="">Semua Waktu</option>
                    <option value="kilat" {{ request('waktu') == 'kilat' ? 'selected' : '' }}>⚡ ≤ 15m (Kilat)</option>
                    <option value="sedang" {{ request('waktu') == 'sedang' ? 'selected' : '' }}>⏰ 16-45m (Sedang)</option>
                    <option value="lama" {{ request('waktu') == 'lama' ? 'selected' : '' }}>🍲 > 45m (Lama)</option>
                </select>
            </div>

            <div class="col-xl-2 col-lg-2 col-md-6">
                <label class="label">URUTKAN</label>
                <select name="sort" class="input">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>🆕 Terbaru</option>
                    <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>⏳ Terlama</option>
                    <option value="rating_tertinggi" {{ request('sort') == 'rating_tertinggi' ? 'selected' : '' }}>⭐ Rating Tertinggi</option>
                    <option value="rating_terendah" {{ request('sort') == 'rating_terendah' ? 'selected' : '' }}>📉 Rating Terendah</option>
                    <option value="judul_az" {{ request('sort') == 'judul_az' ? 'selected' : '' }}>🔤 Judul A-Z</option>
                </select>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12">
                <label class="label">RATING (MIN - MAX)</label>
                <div class="d-flex gap-2">
                    <input type="number" step="0.1" name="rating_min" class="input text-center"
                        placeholder="Min" value="{{ request('rating_min') }}">
                    
                    <button type="submit" class="btn-filter px-3">
                        <i class="fas fa-filter"></i>
                    </button>

                    <a href="{{ route('admin.resep.index') }}" class="btn-reset text-decoration-none">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>
            </div>

        </form>
    </div>

    {{-- LIST RESEP --}}
    @if($resep->count())
    <div class="row g-4">
        @foreach($resep as $item)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card-resep shadow-sm border-0">
                
                {{-- IMAGE --}}
                <div class="image-box">
                    @if($item->foto)
                        <img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->judul }}">
                    @else
                        <div class="no-img"><i class="fas fa-utensils fa-2x text-muted opacity-50"></i></div>
                    @endif

                    <div class="overlay"></div>

                    {{-- BADGE STATUS (BARU) --}}
                    <div class="status-badge status-{{ $item->status }}">
                        {{ $item->status }}
                    </div>

                    {{-- BADGE KATEGORI --}}
                    <div class="kategori">
                        @foreach($item->kategori->take(1) as $k)
                            <span>{{ $k->nama_kategori }}</span>
                        @endforeach
                    </div>
                </div>

                {{-- CARD BODY --}}
                <div class="body d-flex flex-column p-3">
                    <div class="content mb-3">
                        <h6 class="title text-dark fw-bold mb-1">{{ Str::limit($item->judul, 40) }}</h6>
                        
                        <div class="rating mb-2">
                            <span class="text-warning">⭐</span> 
                            <span class="fw-bold">{{ number_format($item->avg_rating ?? 0, 1) }}</span>
                            <small class="text-muted">({{ $item->rating_count ?? 0 }})</small>

                            @if(($item->avg_rating ?? 0) >= 4.5)
                                <span class="top-badge ms-1">🔥 Top</span>
                            @endif
                        </div>

                        <div class="author small text-muted mb-2">
                            <i class="far fa-user me-1"></i> {{ $item->user->name ?? 'Admin' }}
                        </div>

                        @php $w = $item->waktu_masak ?? 0; @endphp
                        <div class="time-badge">
                            @if($w <= 15)
                                <span class="badge-fast">⚡ ≤ 15 menit</span>
                            @elseif($w <= 45)
                                <span class="badge-mid">⏰ 16 - 45 menit</span>
                            @else
                                <span class="badge-slow">🍲 > 45 menit</span>
                            @endif
                        </div>
                    </div>

                    {{-- ACTIONS (MODIFIKASI TERIMA/TOLAK) --}}
                    <div class="actions mt-auto d-flex gap-2">
                        <a href="{{ route('admin.resep.show', $item->id) }}" class="btn-action view" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>

                        @if($item->status == 'pending')
                            {{-- Form Terima --}}
                            <form action="{{ route('admin.resep.approve', $item->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn-action approve w-100" title="Terima Resep">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>

                            {{-- Form Tolak --}}
                            <form action="{{ route('admin.resep.reject', $item->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn-action reject w-100" title="Tolak Resep">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        @else
                            {{-- Tombol Edit & Hapus muncul jika sudah bukan pending --}}
                            <a href="{{ route('admin.resep.edit', $item->id) }}" class="btn-action edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.resep.destroy', $item->id) }}" method="POST" class="flex-grow-1">
                                @csrf @method('DELETE')
                                <button class="btn-action delete w-100" onclick="return confirm('Hapus resep ini?')" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="mt-5 d-flex justify-content-center">
        {{ $resep->links('pagination::bootstrap-5') }}
    </div>

    @else
    <div class="empty-state text-center py-5">
        <i class="fas fa-search fa-4x text-muted mb-3 opacity-25"></i>
        <h5 class="text-muted">Resep tidak ditemukan</h5>
        <p class="small text-muted">Coba ganti kata kunci atau reset filter.</p>
        <a href="{{ route('admin.resep.index') }}" class="btn btn-sm btn-primary">Reset Filter</a>
    </div>
    @endif

</div>

<style>
/* STYLE ASLI KAMU */
.btn-add {
    background: linear-gradient(135deg,#6366f1,#4f46e5);
    color:white !important;
    padding:10px 20px;
    border-radius:12px;
    font-weight:600;
    transition: 0.3s;
}
.btn-add:hover { opacity: 0.9; transform: scale(1.02); }

.alert-box {
    background:#dcfce7;
    color: #15803d;
    padding:14px;
    border-radius:12px;
    font-weight: 500;
}

.filter-box {
    background:#fff;
    padding:24px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.03);
}

.label { font-size:11px; font-weight:700; color:#4b5563; margin-bottom:6px; text-transform: uppercase; letter-spacing: 0.5px; }

.input { 
    width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e5e7eb; 
    font-size: 13px; transition: 0.2s; background: #f9fafb;
}
.input:focus { border-color: #6366f1; background: #fff; outline: none; }

.btn-filter { background:#6366f1; color:white; border:none; border-radius:10px; height: 42px; width: 42px; }
.btn-reset { background:#f3f4f6; color:#4b5563; border-radius:10px; height: 42px; width: 42px; display:flex; align-items:center; justify-content:center; }

.card-resep { background:white; border-radius:20px; overflow:hidden; height:100%; transition:0.3s; position: relative; }
.card-resep:hover { transform:translateY(-8px); box-shadow:0 20px 40px rgba(0,0,0,0.08) !important; }

.image-box { position:relative; height:190px; }
.image-box img { width:100%; height:100%; object-fit:cover; }
.no-img { height:100%; background:#f3f4f6; display:flex; align-items:center; justify-content:center; }
.overlay { position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.4), transparent); }

.kategori { position:absolute; bottom:12px; left:12px; }
.kategori span { background:rgba(255,255,255,0.95); padding:4px 12px; border-radius:8px; font-size:10px; font-weight:700; color:#374151; }

/* STYLE STATUS BADGE (BARU) */
.status-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    z-index: 2;
}
.status-pending { background: #fef3c7; color: #d97706; }
.status-approved { background: #dcfce7; color: #16a34a; }
.status-rejected { background: #fee2e2; color: #dc2626; }

.title { font-size: 15px; line-height: 1.4; height: 42px; overflow: hidden; }
.top-badge { background:#22c55e; color:white; padding:2px 8px; border-radius:6px; font-size:10px; font-weight:bold; }

.badge-fast { background:#dcfce7; color:#16a34a; padding:4px 10px; border-radius:8px; font-size:11px; font-weight:600; }
.badge-mid { background:#fef3c7; color:#d97706; padding:4px 10px; border-radius:8px; font-size:11px; font-weight:600; }
.badge-slow { background:#fee2e2; color:#dc2626; padding:4px 10px; border-radius:8px; font-size:11px; font-weight:600; }

.btn-action { 
    height:38px; width:38px; border-radius:10px; display:flex; align-items:center; 
    justify-content:center; border:none; transition: 0.2s; text-decoration: none;
}
.view { background:#eef2ff; color:#4f46e5; }
.edit { background:#fff7ed; color:#ea580c; }
.delete { background:#fef2f2; color:#dc2626; }

/* STYLE TOMBOL TERIMA/TOLAK (BARU) */
.approve { background: #dcfce7; color: #16a34a; }
.approve:hover { background: #16a34a; color: white; }
.reject { background: #fee2e2; color: #dc2626; }
.reject:hover { background: #dc2626; color: white; }

.view:hover { background:#4f46e5; color:white; }
.edit:hover { background:#ea580c; color:white; }
.delete:hover { background:#dc2626; color:white; }

.empty-state { opacity: 0.6; }
</style>
@endsection