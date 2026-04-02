@extends('layouts.frontend')

@section('styles')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* ========== GENERAL STYLING ========== */
    .recipe-detail-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* ========== HEADER SECTION ========== */
    .recipe-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .recipe-title {
        font-family: "Poppins", sans-serif;
        font-size: 42px;
        font-weight: 700;
        color: #2d3436;
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .recipe-meta {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap;
        margin-top: 15px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
        color: #636e72;
        font-weight: 500;
    }

    .meta-item i {
        color: #ff4a52;
        font-size: 18px;
    }

    .meta-divider {
        width: 1px;
        height: 20px;
        background: #dfe6e9;
    }

    /* ========== FEATURED IMAGE ========== */
    .featured-image-wrapper {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        margin-bottom: 50px;
    }

    .featured-image-wrapper img {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: cover;
        display: block;
    }

    .image-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 100%);
        padding: 30px;
    }

    /* ========== DESCRIPTION ========== */
    .recipe-description {
        font-size: 18px;
        line-height: 1.8;
        color: #2d3436;
        margin-bottom: 40px;
        padding: 25px;
        background: #f8f9fa;
        border-left: 4px solid #ff4a52;
        border-radius: 8px;
        font-family: "Poppins", sans-serif;
    }

    /* ========== CATEGORY BADGES ========== */
    .category-section {
        margin-bottom: 40px;
    }

    .category-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .category-badge {
        background: linear-gradient(135deg, #ff4a52 0%, #ff6b72 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(255, 74, 82, 0.3);
        transition: all 0.3s ease;
    }

    .category-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 74, 82, 0.4);
    }

    .category-badge i {
        font-size: 12px;
    }

    /* ========== SECTION HEADERS ========== */
    .section-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 3px solid #f1f3f5;
    }

    .section-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #ff4a52 0%, #ff6b72 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        box-shadow: 0 4px 12px rgba(255, 74, 82, 0.3);
    }

    .section-title {
        font-family: "Poppins", sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: #2d3436;
        margin: 0;
    }

    /* ========== INGREDIENTS SECTION ========== */
    .ingredients-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 15px;
        margin-bottom: 50px;
    }

    .ingredient-item {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .ingredient-item:hover {
        border-color: #ff4a52;
        box-shadow: 0 4px 12px rgba(255, 74, 82, 0.1);
        transform: translateX(5px);
    }

    .ingredient-icon {
        width: 40px;
        height: 40px;
        background: #fff4f4;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff4a52;
        font-size: 18px;
        flex-shrink: 0;
    }

    .ingredient-content {
        flex: 1;
    }

    .ingredient-name {
        font-weight: 600;
        color: #2d3436;
        font-size: 15px;
        margin-bottom: 3px;
    }

    .ingredient-amount {
        color: #636e72;
        font-size: 14px;
    }

    /* ========== STEPS SECTION ========== */
    .steps-list {
        margin-bottom: 50px;
    }

    .step-item {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        display: flex;
        gap: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .step-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: linear-gradient(135deg, #ff4a52 0%, #ff6b72 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .step-item:hover {
        border-color: #ff4a52;
        box-shadow: 0 4px 12px rgba(255, 74, 82, 0.1);
    }

    .step-item:hover::before {
        opacity: 1;
    }

    .step-number {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #ff4a52 0%, #ff6b72 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        font-weight: 700;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(255, 74, 82, 0.3);
    }

    .step-content {
        flex: 1;
        padding-top: 5px;
    }

    .step-description {
        font-size: 16px;
        line-height: 1.7;
        color: #2d3436;
    }

    /* ========== INFO CARD ========== */
    .info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .info-card-content {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .info-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .info-text h4 {
        margin: 0 0 5px 0;
        font-size: 18px;
        font-weight: 600;
    }

    .info-text p {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
    }

    /* ========== BACK BUTTON ========== */
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 50px;
    }

    .btn-back {
        background: #dfe6e9;
        color: #2d3436;
        border: none;
        padding: 15px 40px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-back:hover {
        background: #b2bec3;
        color: #2d3436;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-edit {
        background: linear-gradient(135deg, #10ac84 0%, #1dd1a1 100%);
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(16, 172, 132, 0.3);
    }

    .btn-edit:hover {
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(16, 172, 132, 0.4);
    }

    /* ========== DIVIDER ========== */
    .section-divider {
        height: 2px;
        background: linear-gradient(to right, transparent, #e8e8e8, transparent);
        margin: 50px 0;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .recipe-title {
            font-size: 32px;
        }

        .recipe-meta {
            gap: 15px;
        }

        .meta-divider {
            display: none;
        }

        .ingredients-grid {
            grid-template-columns: 1fr;
        }

        .section-title {
            font-size: 22px;
        }

        .step-item {
            flex-direction: column;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-back,
        .btn-edit {
            width: 100%;
            justify-content: center;
        }
    }

    /* ========== ANIMATIONS ========== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .ingredient-item,
    .step-item {
        animation: fadeInUp 0.5s ease forwards;
    }

    .ingredient-item:nth-child(1) { animation-delay: 0.1s; }
    .ingredient-item:nth-child(2) { animation-delay: 0.2s; }
    .ingredient-item:nth-child(3) { animation-delay: 0.3s; }
    .ingredient-item:nth-child(4) { animation-delay: 0.4s; }
    .ingredient-item:nth-child(5) { animation-delay: 0.5s; }

    .step-item:nth-child(1) { animation-delay: 0.1s; }
    .step-item:nth-child(2) { animation-delay: 0.2s; }
    .step-item:nth-child(3) { animation-delay: 0.3s; }
    .step-item:nth-child(4) { animation-delay: 0.4s; }
    .step-item:nth-child(5) { animation-delay: 0.5s; }
</style>
@endsection

@section('content')
<div class="recipe-detail-container">

    <!-- HEADER -->
    <div class="recipe-header">
        <h1 class="recipe-title">{{ $resep->judul }}</h1>
        
        <div class="recipe-meta">
            <div class="meta-item">
                <i class="fas fa-clock"></i>
                <span>{{ $resep->waktu_masak }} Menit</span>
            </div>
            
            <div class="meta-divider"></div>
            
            <div class="meta-item">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ \Carbon\Carbon::parse($resep->tanggal_publish)->format('d M Y') }}</span>
            </div>
            
            <div class="meta-divider"></div>
            
            <div class="meta-item">
                <i class="fas fa-user"></i>
                <span>{{ $resep->user->name ?? 'Admin' }}</span>
            </div>
        </div>
    </div>

    <!-- FEATURED IMAGE -->
    @if ($resep->foto)
    <div class="featured-image-wrapper">
        <img 
            src="{{ asset('storage/'.$resep->foto) }}" 
            alt="Foto {{ $resep->judul }}"
        >
    </div>
    @endif

    <!-- DESCRIPTION -->
    @if($resep->deskripsi)
    <div class="recipe-description">
        <i class="fas fa-quote-left" style="color: #ff4a52; margin-right: 10px;"></i>
        {{ $resep->deskripsi }}
    </div>
    @endif

    <!-- CATEGORIES -->
    @if($resep->kategori->count() > 0)
    <div class="category-section">
        <div class="category-badges">
            @foreach ($resep->kategori as $kat)
            <span class="category-badge">
                <i class="fas fa-tag"></i>
                {{ $kat->nama_kategori }}
            </span>
            @endforeach
        </div>
    </div>
    @endif

    <div class="section-divider"></div>

    <!-- COOKING TIME INFO CARD -->
    <div class="info-card">
        <div class="info-card-content">
            <div class="info-icon">
                <i class="fas fa-fire"></i>
            </div>
            <div class="info-text">
                <h4>Waktu Memasak</h4>
                <p>{{ $resep->waktu_masak }} Menit</p>
            </div>
        </div>
    </div>

    <!-- INGREDIENTS -->
    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-shopping-basket"></i>
        </div>
        <h2 class="section-title">Bahan-bahan</h2>
    </div>

    <div class="ingredients-grid">
        @foreach ($resep->bahan as $b)
        <div class="ingredient-item">
            <div class="ingredient-icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="ingredient-content">
                <div class="ingredient-name">{{ $b->nama_bahan }}</div>
                <div class="ingredient-amount">{{ $b->jumlah }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="section-divider"></div>

    <!-- COOKING STEPS -->
    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-list-ol"></i>
        </div>
        <h2 class="section-title">Langkah Memasak</h2>
    </div>

    <div class="steps-list">
        @foreach ($resep->langkah as $index => $l)
        <div class="step-item">
            <div class="step-number">{{ $index + 1 }}</div>
            <div class="step-content">
                <p class="step-description">{{ $l->deskripsi_langkah }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- ACTION BUTTONS -->
    <div class="action-buttons">
        <a href="{{ route('user.resepsaya.edit', $resep->id) }}" class="btn-edit">
            <i class="fas fa-edit"></i>
            Edit Resep
        </a>
        <a href="{{ route('user.resepsaya.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

</div>
@endsection