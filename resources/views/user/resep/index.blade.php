@extends('layouts.frontend')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endpush

@section('content')

{{-- SECTION FILTER --}}
<div class="filter_area pt-5 pb-4">
    <div class="container">
        <div class="filter-card">
            <form action="{{ route('user.resep.index') }}" method="GET" id="filterForm">
                <div class="filter-flex">
                    {{-- LEFT: Rating --}}
                    <div class="filter-left">
                        <label class="filter-label">
                            <i class="fas fa-star"></i> Rating Minimum
                        </label>
                        <div class="rating-filter">
                            <input type="radio" name="rating_min" value="" id="rating_all" 
                                {{ request('rating_min') == '' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label for="rating_all" class="rating-option">
                                <span class="rating-text">Semua</span>
                            </label>

                            <input type="radio" name="rating_min" value="4.5" id="rating_45" 
                                {{ request('rating_min') == '4.5' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label for="rating_45" class="rating-option">
                                <div class="stars">
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="fas fa-star-half-alt star-half"></i>
                                </div>
                                <span class="rating-text">4.5+</span>
                            </label>

                            <input type="radio" name="rating_min" value="4.0" id="rating_40" 
                                {{ request('rating_min') == '4.0' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label for="rating_40" class="rating-option">
                                <div class="stars">
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="far fa-star star-empty"></i>
                                </div>
                                <span class="rating-text">4.0+</span>
                            </label>

                            <input type="radio" name="rating_min" value="3.0" id="rating_30" 
                                {{ request('rating_min') == '3.0' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label for="rating_30" class="rating-option">
                                <div class="stars">
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="far fa-star star-empty"></i>
                                    <i class="far fa-star star-empty"></i>
                                </div>
                                <span class="rating-text">3.0+</span>
                            </label>

                            <input type="radio" name="rating_min" value="2.0" id="rating_20" 
                                {{ request('rating_min') == '2.0' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label for="rating_20" class="rating-option">
                                <div class="stars">
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="far fa-star star-empty"></i>
                                    <i class="far fa-star star-empty"></i>
                                    <i class="far fa-star star-empty"></i>
                                </div>
                                <span class="rating-text">2.0+</span>
                            </label>

                            <input type="radio" name="rating_min" value="1.0" id="rating_10" 
                                {{ request('rating_min') == '1.0' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label for="rating_10" class="rating-option">
                                <div class="stars">
                                    <i class="fas fa-star star-filled"></i>
                                    <i class="far fa-star star-empty"></i>
                                    <i class="far fa-star star-empty"></i>
                                    <i class="far fa-star star-empty"></i>
                                    <i class="far fa-star star-empty"></i>
                                </div>
                                <span class="rating-text">1.0+</span>
                            </label>
                        </div>
                    </div>

                    {{-- RIGHT: Kategori & Waktu Masak --}}
                    <div class="filter-right">
                        <label class="filter-label">
                            <i class="fas fa-tag"></i> Kategori
                        </label>
                        <div class="kategori-search-wrapper">
                            <input type="text" 
                                   name="kategori" 
                                   id="kategoriInput" 
                                   list="kategoriList" 
                                   class="form-select mb-2" 
                                   placeholder="Cari atau pilih kategori..."
                                   value="{{ request('kategori') }}"
                                   autocomplete="off">
                            <datalist id="kategoriList">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->nama_kategori }}">
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </datalist>
                            <button type="button" id="searchKategoriBtn" class="btn-search-kategori">
                                <i class="fas fa-search"></i> Cari Kategori
                            </button>
                        </div>

                        {{-- Waktu Masak dengan lebih banyak opsi hingga 9 jam --}}
                        <label class="filter-label mt-3">
                            <i class="fas fa-clock"></i> Waktu Masak
                        </label>
                        <select name="waktu" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Waktu</option>
                            <option value="15" {{ request('waktu') == '15' ? 'selected' : '' }}>≤ 15 menit</option>
                            <option value="30" {{ request('waktu') == '30' ? 'selected' : '' }}>≤ 30 menit</option>
                            <option value="45" {{ request('waktu') == '45' ? 'selected' : '' }}>≤ 45 menit</option>
                            <option value="60" {{ request('waktu') == '60' ? 'selected' : '' }}>≤ 1 jam</option>
                            <option value="90" {{ request('waktu') == '90' ? 'selected' : '' }}>≤ 1.5 jam</option>
                            <option value="120" {{ request('waktu') == '120' ? 'selected' : '' }}>≤ 2 jam</option>
                            <option value="180" {{ request('waktu') == '180' ? 'selected' : '' }}>≤ 3 jam</option>
                            <option value="240" {{ request('waktu') == '240' ? 'selected' : '' }}>≤ 4 jam</option>
                            <option value="300" {{ request('waktu') == '300' ? 'selected' : '' }}>≤ 5 jam</option>
                            <option value="360" {{ request('waktu') == '360' ? 'selected' : '' }}>≤ 6 jam</option>
                            <option value="420" {{ request('waktu') == '420' ? 'selected' : '' }}>≤ 7 jam</option>
                            <option value="480" {{ request('waktu') == '480' ? 'selected' : '' }}>≤ 8 jam</option>
                            <option value="540" {{ request('waktu') == '540' ? 'selected' : '' }}>≤ 9 jam</option>
                        </select>
                    </div>
                </div>
                
                {{-- Active Filters --}}
                @if(request('kategori') || request('rating_min') || request('waktu'))
                <div class="active-filters mt-3">
                    <span class="me-2 text-muted small">Filter aktif:</span>
                    @if(request('kategori'))
                        <span class="filter-badge">
                            Kategori: {{ request('kategori') }}
                            <a href="{{ route('user.resep.index', array_merge(request()->except('kategori'), ['kategori' => null])) }}" class="remove-filter">×</a>
                        </span>
                    @endif
                    @if(request('waktu'))
                    <span class="filter-badge">
                        Waktu: ≤ {{ request('waktu') }} menit
                        <a href="{{ route('user.resep.index', request()->except('waktu')) }}" class="remove-filter">×</a>
                    </span>
                    @endif
                    @if(request('rating_min'))
                        <span class="filter-badge">
                            Rating: {{ request('rating_min') }}+
                            <a href="{{ route('user.resep.index', request()->except('rating_min')) }}" class="remove-filter">×</a>
                        </span>
                    @endif
                    <a href="{{ route('user.resep.index') }}" class="btn btn-sm btn-link text-danger">Reset Semua</a>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

{{-- SECTION RESEP LIST --}}
<div class="recepie_area pb-5">
    <div class="container">
        
        {{-- Result Count --}}
        <div class="mb-4">
            <h5 class="mb-0">
                Menampilkan {{ $reseps->count() }} dari {{ $reseps->total() }} resep
            </h5>
        </div>

        <div class="row">
            @forelse($reseps as $resep)
            @php
                $avgRating = $resep->avg_rating ?? 0; 
                $ratingCount = $resep->rating_count ?? 0;
                $sudahSimpan = auth()->check() && $resep->interaksi->where('user_id', auth()->id())->where('simpan_resep', true)->isNotEmpty();
            @endphp

                <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                    <div class="recipe-card">
                        
                        {{-- Foto --}}
                        <div class="recipe-image">
                            <a href="{{ route('user.resep.show', $resep->id) }}">
                                <img src="{{ $resep->foto ? asset('storage/'.$resep->foto) : asset('assets/img/no-image.png') }}"
                                     alt="{{ $resep->judul }}">
                            </a>
                            
                            {{-- Rating Badge --}}
                            @if($avgRating > 0)
                            <div class="rating-badge">
                                <i class="fas fa-star"></i> {{ number_format($avgRating, 1) }}
                            </div>
                            @endif

                            {{-- Bookmark Button --}}
                            @auth
                            <form action="{{ route('resep.simpan', $resep->id) }}" method="POST" class="bookmark-form">
                                @csrf
                                <button type="submit" class="bookmark-btn {{ $sudahSimpan ? 'active' : '' }}">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </form>
                            @endauth
                        </div>

                        {{-- Content --}}
                        <div class="recipe-content">
                            
                            {{-- Kategori --}}
                            <div class="recipe-categories mb-2">
                                @foreach($resep->kategori->take(2) as $kat)
                                    <span class="category-tag">{{ $kat->nama_kategori }}</span>
                                @endforeach
                            </div>

                            {{-- Judul --}}
                            <h5 class="recipe-title">
                                <a href="{{ route('user.resep.show', $resep->id) }}">
                                    {{ Str::limit($resep->judul, 50) }}
                                </a>
                            </h5>

                            {{-- Meta Info --}}
                            <div class="recipe-meta">
                                <div class="meta-item">
                                    <i class="fas fa-user"></i>
                                    <span>{{ Str::limit($resep->user->name ?? 'Anonim', 15) }}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $resep->waktu_masak ?? 0 }} menit</span>
                                </div>
                            </div>

                            {{-- Rating Display --}}
                            <div class="recipe-rating">
                                <div class="stars-small">   
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($avgRating))
                                            <i class="fas fa-star star-filled"></i>
                                        @elseif($i == ceil($avgRating) && ($avgRating - floor($avgRating)) >= 0.5)
                                            <i class="fas fa-star-half-alt star-half"></i>
                                        @else
                                            <i class="far fa-star star-empty"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-count">({{ $ratingCount }})</span>
                            </div>

                            {{-- Button --}}
                            <a href="{{ route('user.resep.show', $resep->id) }}" class="btn-detail">
                                Lihat Detail <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <h5>Resep tidak ditemukan</h5>
                        <p>Coba ubah filter atau kata kunci pencarian Anda</p>
                        <a href="{{ route('user.resep.index') }}" class="btn btn-primary">Reset Filter</a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($reseps->hasPages())
        <div class="pagination-wrapper mt-5">
            {{ $reseps->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .filter-flex {
        display: flex;
        gap: 30px;
        align-items: flex-start;
    }

    .filter-left {
        flex: 1;
    }

    .filter-right {
        flex: 1;
    }

    /* Biar label & select selalu turun ke bawah (rapi) */
    .filter-right label {
        display: block;
        margin-bottom: 6px;
    }

    .filter-right select,
    .filter-right input {
        width: 100%;
        margin-bottom: 15px;
    }
    
    /* Kategori Search Wrapper */
    .kategori-search-wrapper {
        position: relative;
    }
    
    .btn-search-kategori {
        width: 100%;
        padding: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 5px;
    }
    
    .btn-search-kategori:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    /* Filter Card */
    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }

    .filter-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        display: block;
        font-size: 14px;
    }

    .filter-label i {
        color: #ff6b6b;
        margin-right: 5px;
    }

    .form-select {
        height: 45px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
        padding: 0 12px;
        padding-top: 0;
        line-height: 45px; 
    }

    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    /* Rating Filter */
    .rating-filter {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .rating-filter input[type="radio"] {
        display: none;
    }

    .rating-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
    }

    .rating-option:hover {
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    .rating-filter input[type="radio"]:checked + .rating-option {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .rating-filter input[type="radio"]:checked + .rating-option .star-filled {
        color: #ffc107;
    }

    .rating-filter input[type="radio"]:checked + .rating-option .star-half {
        color: #ffc107;
    }

    .rating-filter input[type="radio"]:checked + .rating-option .star-empty {
        color: rgba(255,255,255,0.4);
    }

    .stars {
        display: flex;
        gap: 2px;
        font-size: 16px;
    }

    .star-filled {
        color: #ffc107;
    }

    .star-half {
        color: #ffc107;
    }

    .star-empty {
        color: #ddd;
    }

    .rating-text {
        font-size: 12px;
        font-weight: 600;
    }

    /* Active Filters */
    .active-filters {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        background: #667eea;
        color: white;
        border-radius: 20px;
        font-size: 13px;
    }

    .remove-filter {
        color: white;
        text-decoration: none;
        font-size: 18px;
        line-height: 1;
        font-weight: bold;
    }

    .remove-filter:hover {
        color: #ff6b6b;
    }

    /* Recipe Card */
    .recipe-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        transition: all 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .recipe-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .recipe-image {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .recipe-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .recipe-card:hover .recipe-image img {
        transform: scale(1.1);
    }

    .rating-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255, 193, 7, 0.95);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .bookmark-form {
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .bookmark-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.9);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        color: #999;
        font-size: 16px;
    }

    .bookmark-btn:hover,
    .bookmark-btn.active {
        background: #ff6b6b;
        color: white;
        transform: scale(1.1);
    }

    .recipe-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .recipe-categories {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .category-tag {
        font-size: 11px;
        padding: 4px 10px;
        background: #f0f0f0;
        border-radius: 12px;
        color: #666;
        font-weight: 600;
    }

    .recipe-title {
        font-size: 18px;
        font-weight: 700;
        margin: 10px 0;
        line-height: 1.4;
    }

    .recipe-title a {
        color: #2c3e50;
        text-decoration: none;
        transition: color 0.3s;
    }

    .recipe-title a:hover {
        color: #667eea;
    }

    .recipe-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        font-size: 13px;
        color: #666;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .meta-item i {
        color: #ff6b6b;
    }

    .recipe-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 15px;
    }

    .stars-small {
        display: flex;
        gap: 2px;
        font-size: 14px;
    }

    .rating-count {
        font-size: 12px;
        color: #999;
    }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
        margin-top: auto;
        justify-content: center;
    }

    .btn-detail:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-state i {
        font-size: 80px;
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-state h5 {
        color: #666;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #999;
        margin-bottom: 20px;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .filter-flex {
            flex-direction: column;
        }
        
        .rating-filter {
            justify-content: center;
        }
        
        .recipe-image {
            height: 200px;
        }
        
    }
</style>

@push('scripts')
<script>
    // Manual submit untuk kategori
    const searchBtn = document.getElementById('searchKategoriBtn');
    const kategoriInput = document.getElementById('kategoriInput');
    const filterForm = document.getElementById('filterForm');
    
    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            filterForm.submit();
        });
    }
    
    // Optional: Submit ketika Enter ditekan di input kategori
    if (kategoriInput) {
        kategoriInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterForm.submit();
            }
        });
    }
</script>
@endpush

@endsection