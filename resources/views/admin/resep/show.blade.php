@extends('layouts.backend')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $resep->judul }}</h4>
            <p class="text-muted small mb-0">Dibuat oleh {{ $resep->user->name }} • {{ $resep->created_at->diffForHumans() }}</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.resep.edit', $resep->id) }}" class="btn btn-outline-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('admin.resep.destroy', $resep->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Hapus resep ini?')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Main Content --}}
        <div class="col-lg-8">
            {{-- Foto & Deskripsi --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    @if ($resep->foto)
                        <img src="{{ asset('storage/' . $resep->foto) }}" 
                             alt="{{ $resep->judul }}"
                             class="w-100 rounded-top"
                             style="height: 400px; object-fit: cover;">
                    @endif
                    <div class="p-4">
                        <h6 class="text-muted mb-2">Deskripsi</h6>
                        <p class="mb-0">{{ $resep->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                    </div>
                </div>
            </div>

            {{-- Bahan & Langkah --}}
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="mb-3">Bahan-bahan <span class="badge bg-light text-dark">{{ $resep->bahan->count() }}</span></h6>
                            @forelse($resep->bahan as $b)
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span>{{ $b->nama_bahan }}</span>
                                    <strong class="text-muted">{{ $b->jumlah }}</strong>
                                </div>
                            @empty
                                <p class="text-muted mb-0">Belum ada bahan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="mb-3">Langkah-langkah <span class="badge bg-light text-dark">{{ $resep->langkah->count() }}</span></h6>
                            @forelse($resep->langkah->sortBy('nomor_langkah') as $l)
                                <div class="d-flex mb-3">
                                    <div class="step-number me-3">{{ $l->nomor_langkah }}</div>
                                    {{-- Tambahkan class text-break di sini --}}
                                    <p class="mb-0 small text-break">{{ $l->deskripsi_langkah }}</p>
                                </div>
                            @empty
                                <p class="text-muted mb-0">Belum ada langkah.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Rating Card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    <div class="display-4 text-warning mb-2">
                        ★ {{ number_format($resep->avg_rating ?? 0, 1) }}
                    </div>
                    <p class="text-muted mb-2">{{ $resep->rating_count ?? 0 }} ulasan</p>
                    <small class="text-muted">{{ $resep->saved_count ?? 0 }} kali disimpan</small>
                </div>
            </div>

            {{-- Info Card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="mb-3">Informasi</h6>
                    <div class="info-item">
                        <small class="text-muted">Waktu Memasak</small>
                        <p class="mb-3">{{ $resep->waktu_masak ?? '—' }} menit</p>
                    </div>
                    <div class="info-item">
                        <small class="text-muted">Tanggal Publish</small>
                        <p class="mb-3">
                            {{ $resep->tanggal_publish 
                                ? \Carbon\Carbon::parse($resep->tanggal_publish)->format('d M Y, H:i') 
                                : '—' }}
                        </p>
                    </div>
                    <div class="info-item">
                        <small class="text-muted">Terakhir Diupdate</small>
                        <p class="mb-0">{{ $resep->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Kategori Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Kategori</h6>
                    @forelse($resep->kategori as $kat)
                        <span class="badge bg-light text-dark border me-2 mb-2 px-3 py-2">
                            {{ $kat->nama_kategori }}
                        </span>
                    @empty
                        <p class="text-muted mb-0 small">Belum ada kategori</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Back Button --}}
    <div class="mt-4">
        <a href="{{ route('admin.resep.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
</div>

<style>
<style>
    /* ... kode lama kamu ... */

    .step-number {
        width: 30px;
        height: 30px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
    }

    /* Tambahkan ini untuk jaga-jaga di seluruh card */
    .card-body p {
        word-break: break-word; /* Ini kunci biar gak keluar kotak */
        overflow-wrap: break-word;
    }

    .card {
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .info-item p {
        font-weight: 500;
    }
</style>
@endsection