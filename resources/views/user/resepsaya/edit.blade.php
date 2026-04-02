@extends('layouts.frontend')

@section('styles')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* ========== GENERAL RESET ========== */
    .recepie_details_area * {
        box-sizing: border-box;
    }

    /* ========== TYPOGRAPHY ========== */
    .recepie_details_area label {
        font-family: "Poppins", sans-serif !important;
        font-size: 15px !important; 
        font-weight: 600 !important;
        color: #2d3436 !important;
        margin-bottom: 8px !important;
        display: block;
    }

    .recepie_details_area label .required {
        color: #ff4a52;
        margin-left: 3px;
    }

    .recepie_details_area h4 {
        font-family: "Poppins", sans-serif !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        color: #2d3436 !important;
        margin-bottom: 0 !important;
    }

    /* ========== FORM CONTROLS ========== */
    .recepie_details_area .form-control {
        height: 50px !important;
        background: #ffffff !important;
        border: 2px solid #e8e8e8 !important;
        border-radius: 8px !important;
        font-size: 14px !important;
        color: #2d3436 !important;
        padding: 12px 16px !important;
        transition: all 0.3s ease;
        font-family: "Poppins", sans-serif;
    }

    .recepie_details_area .form-control:focus {
        border-color: #ff4a52 !important;
        box-shadow: 0 0 0 3px rgba(255, 74, 82, 0.1) !important;
        background: #fff !important;
    }

    .recepie_details_area textarea.form-control {
        height: auto !important;
        min-height: 100px !important;
        resize: vertical;
    }

    .recepie_details_area .form-control::placeholder {
        color: #b2bec3 !important;
        font-size: 14px;
    }

    /* ========== FILE INPUT & PREVIEW ========== */
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .file-input-wrapper input[type=file] {
        position: absolute;
        left: -9999px;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 30px 20px;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .file-input-label:hover {
        border-color: #ff4a52;
        background: #fff4f4;
    }

    .file-input-label i {
        font-size: 24px;
        color: #ff4a52;
    }

    .file-input-label span {
        font-size: 14px;
        color: #636e72;
        font-weight: 500;
    }

    .current-image-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 15px;
    }

    .current-image-wrapper img {
        max-width: 250px;
        border-radius: 10px;
        border: 3px solid #e8e8e8;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .current-image-badge {
        position: absolute;
        top: -10px;
        left: -10px;
        background: linear-gradient(135deg, #ff4a52 0%, #ff6b72 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(255, 74, 82, 0.4);
    }

    .file-preview {
        margin-top: 15px;
        display: none;
    }

    .file-preview img {
        max-width: 250px;
        border-radius: 8px;
        border: 2px solid #e8e8e8;
    }

    /* ========== DROPDOWN KATEGORI ========== */
    .kategori-input-wrapper {
        position: relative;
    }

    .btn-dropdown-custom {
        min-height: 50px !important;
        height: auto !important;
        background: #ffffff !important;
        border: 2px solid #e8e8e8 !important;
        border-radius: 8px !important;
        font-size: 14px !important;
        color: #2d3436 !important;
        width: 100%;
        text-align: left;
        padding: 8px 40px 8px 12px !important;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        font-family: "Poppins", sans-serif;
        font-weight: 400;
        position: relative;
    }

    .btn-dropdown-custom:hover,
    .btn-dropdown-custom:focus {
        border-color: #ff4a52 !important;
        background: #fff !important;
        box-shadow: 0 0 0 3px rgba(255, 74, 82, 0.1) !important;
    }

    .btn-dropdown-custom .placeholder-text {
        color: #b2bec3;
        font-size: 14px;
        font-weight: 400;
    }

    .btn-dropdown-custom .dropdown-arrow {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12px;
        color: #636e72;
    }

    .dropdown-menu-custom {
        width: 100%;
        max-height: 280px;
        overflow-y: auto;
        padding: 8px;
        border: 2px solid #e8e8e8;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-top: 5px !important;
    }

    .category-item {
        padding: 10px 12px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        cursor: pointer;
        border-radius: 6px;
        margin-bottom: 4px;
        font-size: 14px;
        color: #2d3436;
    }

    .category-item:hover {
        background: #fff4f4;
    }

    .category-item input[type="checkbox"] {
        margin-right: 10px;
        cursor: pointer;
        width: 18px;
        height: 18px;
        accent-color: #ff4a52;
    }

    /* Tags Inside Input */
    .badge-category-inline {
        background: #f1f3f5 !important;
        color: #2d3436 !important;
        padding: 5px 10px 5px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #dee2e6;
        transition: all 0.2s ease;
    }

    .badge-category-inline:hover {
        background: #e9ecef !important;
        border-color: #ced4da;
    }

    .badge-category-inline .remove-tag {
        width: 16px;
        height: 16px;
        background: #adb5bd;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 10px;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .badge-category-inline .remove-tag:hover {
        background: #ff4a52;
    }

    /* ========== DYNAMIC INPUT SECTIONS ========== */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f3f5;
    }

    .input-group-wrapper {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 12px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .input-group-wrapper:hover {
        border-color: #dee2e6;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .input-number {
        width: 35px;
        height: 35px;
        background: #ff4a52;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        margin-right: 10px;
        flex-shrink: 0;
    }

    /* ========== BUTTONS ========== */
    .btn-add {
        background: linear-gradient(135deg, #10ac84 0%, #1dd1a1 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 3px 8px rgba(16, 172, 132, 0.3);
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(16, 172, 132, 0.4);
        color: white;
    }

    .btn-remove {
        width: 40px;
        height: 40px;
        background: #ff6b6b;
        border: none;
        border-radius: 8px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .btn-remove:hover {
        background: #ee5a6f;
        transform: scale(1.05);
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #ff4a52 0%, #ff6b72 100%) !important;
        border: none !important;
        color: white !important;
        padding: 16px 50px !important;
        font-weight: 600 !important;
        border-radius: 10px !important;
        font-size: 16px !important;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(255, 74, 82, 0.4);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-primary-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(255, 74, 82, 0.5);
    }

    .btn-secondary {
        background: #dfe6e9 !important;
        border: none !important;
        color: #2d3436 !important;
        padding: 16px 50px !important;
        font-weight: 600 !important;
        border-radius: 10px !important;
        font-size: 16px !important;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #b2bec3 !important;
        transform: translateY(-3px);
    }

    /* ========== ALERT ========== */
    .alert {
        border-radius: 10px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 25px;
    }

    .alert-danger {
        background: #fff5f5;
        color: #c53030;
        border-left: 4px solid #ff4a52;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    /* ========== CARD STYLING ========== */
    .card {
        border: none !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
    }

    /* ========== DIVIDER ========== */
    .divider {
        height: 2px;
        background: linear-gradient(to right, transparent, #e8e8e8, transparent);
        margin: 40px 0;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .btn-primary-custom,
        .btn-secondary {
            padding: 14px 30px !important;
            font-size: 14px !important;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .input-group-wrapper {
            padding: 12px;
        }

        .current-image-wrapper img {
            max-width: 100%;
        }
    }

    /* ========== ANIMATION ========== */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .input-group-wrapper {
        animation: fadeIn 0.3s ease;
    }

    /* ========== CUSTOM SCROLLBAR ========== */
    .dropdown-menu-custom::-webkit-scrollbar {
        width: 6px;
    }

    .dropdown-menu-custom::-webkit-scrollbar-track {
        background: #f1f3f5;
        border-radius: 10px;
    }

    .dropdown-menu-custom::-webkit-scrollbar-thumb {
        background: #ff4a52;
        border-radius: 10px;
    }

    .dropdown-menu-custom::-webkit-scrollbar-thumb:hover {
        background: #ff6b72;
    }
</style>
@endsection

@section('content')
<div class="bradcam_area bradcam_bg_1">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 text-center">
                <h3>Edit Resep</h3>
            </div>
        </div>
    </div>
</div>

<div class="recepie_details_area">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">

                        {{-- Alert Error Validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong><i class="fas fa-exclamation-triangle mr-2"></i>Terdapat kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('user.resepsaya.update', $resep->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- INFORMASI UMUM -->
                            <div class="form-group mb-4">
                                <label>Nama Resep <span class="required">*</span></label>
                                <input type="text" name="judul" class="form-control" placeholder="Contoh: Ayam Bakar Madu" required value="{{ old('judul', $resep->judul) }}">
                            </div>

                            <div class="form-group mb-4">
                                <label>Deskripsi Resep</label>
                                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Ceritakan singkat tentang resep ini...">{{ old('deskripsi', $resep->deskripsi) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label>Waktu Masak (Menit) <span class="required">*</span></label>
                                        <input type="number" name="waktu_masak" class="form-control" placeholder="30" min="1" required value="{{ old('waktu_masak', $resep->waktu_masak) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label>Kategori (Maksimal 4) <span class="required">*</span></label>
                                        <div class="kategori-input-wrapper">
                                            <div class="dropdown">
                                                <button class="btn btn-dropdown-custom dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="placeholder-text">Pilih Kategori</span>
                                                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-custom" aria-labelledby="dropdownMenuButton">
                                                    @foreach ($kategoris as $kategori)
                                                    <label class="category-item w-100 mb-0">
                                                        <input type="checkbox" 
                                                               name="kategori_id[]" 
                                                               value="{{ $kategori->id }}" 
                                                               data-nama="{{ $kategori->nama_kategori }}" 
                                                               class="category-checkbox"
                                                               {{ $resep->kategori->contains($kategori->id) ? 'checked' : '' }}>
                                                        {{ $kategori->nama_kategori }}
                                                    </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label>Tanggal Publish <span class="required">*</span></label>
                                        <input type="date" name="tanggal_publish" class="form-control" 
                                               value="{{ old('tanggal_publish', $resep->tanggal_publish ? \Carbon\Carbon::parse($resep->tanggal_publish)->format('Y-m-d') : date('Y-m-d')) }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- UPLOAD FOTO -->
                            <div class="form-group mb-4">
                                <label>Foto Masakan</label>
                                
                                @if($resep->foto)
                                    <div class="current-image-wrapper">
                                        <span class="current-image-badge">
                                            <i class="fas fa-image mr-1"></i> Foto Saat Ini
                                        </span>
                                        <img src="{{ asset('storage/'.$resep->foto) }}" alt="Current Photo" id="current-photo">
                                    </div>
                                @endif

                                <div class="file-input-wrapper">
                                    <input type="file" name="foto" id="foto-input" accept="image/*">
                                    <label for="foto-input" class="file-input-label">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <div>
                                            <span><strong>Klik untuk upload foto baru</strong></span><br>
                                            <small style="color: #95a5a6;">Format: JPG, PNG, JPEG (Max 2MB) - Kosongkan jika tidak ingin mengganti</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="file-preview" id="foto-preview">
                                    <strong class="d-block mb-2" style="color: #10ac84;">
                                        <i class="fas fa-check-circle mr-1"></i> Preview Foto Baru:
                                    </strong>
                                    <img src="" alt="Preview">
                                </div>
                            </div>

                            <div class="divider"></div>

                            <!-- SECTION BAHAN -->
                            <div class="section-header">
                                <h4><i class="fas fa-shopping-basket" style="color: #ff4a52; margin-right: 10px;"></i> Bahan-bahan</h4>
                                <button type="button" class="btn btn-add" onclick="tambahBahan()">
                                    <i class="fas fa-plus"></i> Tambah Bahan
                                </button>
                            </div>
                            <div id="bahan-wrapper">
                                @foreach($resep->bahan as $index => $b)
                                <div class="input-group-wrapper">
                                    <div class="d-flex align-items-center">
                                        <div class="input-number">{{ $index + 1 }}</div>
                                        <div class="flex-grow-1">
                                            <div class="row">
                                                <div class="col-md-7 mb-2 mb-md-0">
                                                    <input type="text" name="bahan[]" class="form-control" placeholder="Contoh: Ayam fillet" value="{{ $b->nama_bahan }}" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" name="jumlah[]" class="form-control" placeholder="Contoh: 500 gram" value="{{ $b->jumlah }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-remove ml-3 remove-bahan">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="divider"></div>

                            <!-- SECTION LANGKAH -->
                            <div class="section-header">
                                <h4><i class="fas fa-list-ol" style="color: #ff4a52; margin-right: 10px;"></i> Langkah Memasak</h4>
                                <button type="button" class="btn btn-add" onclick="tambahLangkah()">
                                    <i class="fas fa-plus"></i> Tambah Langkah
                                </button>
                            </div>
                            <div id="langkah-wrapper">
                                @foreach($resep->langkah as $index => $l)
                                <div class="input-group-wrapper">
                                    <div class="d-flex align-items-start">
                                        <div class="input-number">{{ $index + 1 }}</div>
                                        <div class="flex-grow-1">
                                            <textarea name="langkah[]" class="form-control" rows="3" placeholder="Jelaskan langkah..." required>{{ $l->deskripsi_langkah }}</textarea>
                                        </div>
                                        <button type="button" class="btn btn-remove ml-3 remove-langkah">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="divider"></div>

                            <!-- SUBMIT BUTTONS -->
                            <div class="text-center mt-5">
                                <button type="submit" class="btn-primary-custom">
                                    <i class="fas fa-save mr-2"></i> Update Resep
                                </button>
                                <a href="{{ route('user.resepsaya.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-times mr-2"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ========== PREVIEW FOTO ==========
    document.getElementById('foto-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('foto-preview');
                preview.querySelector('img').src = event.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // ========== DROPDOWN KATEGORI ==========
    $(document).ready(function() {
        // Initialize tags on page load
        updateKategoriTags();
    });

    $(document).on('change', '.category-checkbox', function() {
        const limit = 4;
        const checkedCount = $('.category-checkbox:checked').length;
        
        if (checkedCount > limit) {
            $(this).prop('checked', false);
            Swal.fire({
                icon: 'warning',
                title: 'Batas Kategori',
                text: 'Maksimal hanya boleh memilih 4 kategori',
                confirmButtonColor: '#ff4a52'
            });
            return;
        }

        updateKategoriTags();
    });

    function updateKategoriTags() {
        const button = $('#dropdownMenuButton');
        button.empty(); // Clear button content
        
        const checkedBoxes = $('.category-checkbox:checked');
        
        if (checkedBoxes.length === 0) {
            // Show placeholder
            button.html('<span class="placeholder-text">Pilih Kategori</span><i class="fas fa-chevron-down dropdown-arrow"></i>');
        } else {
            // Show tags
            checkedBoxes.each(function() {
                const nama = $(this).data('nama');
                const id = $(this).val();
                const tag = $(`
                    <span class="badge-category-inline" data-id="${id}">
                        ${nama}
                        <span class="remove-tag" onclick="removeKategoriTag(${id}, event)">
                            <i class="fas fa-times"></i>
                        </span>
                    </span>
                `);
                button.append(tag);
            });
            // Add arrow
            button.append('<i class="fas fa-chevron-down dropdown-arrow"></i>');
        }
    }

    function removeKategoriTag(id, event) {
        event.stopPropagation(); // Prevent dropdown from toggling
        $(`.category-checkbox[value="${id}"]`).prop('checked', false);
        updateKategoriTags();
    }

    // Make removeKategoriTag available globally
    window.removeKategoriTag = removeKategoriTag;

    // Mencegah dropdown tertutup saat klik checkbox
    $('.dropdown-menu-custom').on('click', function(e) {
        e.stopPropagation();
    });

    // ========== DINAMIS BAHAN ==========
    let bahanCount = {{ count($resep->bahan) }};

    function tambahBahan() {
        bahanCount++;
        $('#bahan-wrapper').append(`
            <div class="input-group-wrapper">
                <div class="d-flex align-items-center">
                    <div class="input-number">${bahanCount}</div>
                    <div class="flex-grow-1">
                        <div class="row">
                            <div class="col-md-7 mb-2 mb-md-0">
                                <input type="text" name="bahan[]" class="form-control" placeholder="Contoh: Bawang putih" required>
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="jumlah[]" class="form-control" placeholder="Contoh: 5 siung" required>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-remove ml-3 remove-bahan">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `);
        updateBahanNumbers();
    }

    $(document).on('click', '.remove-bahan', function() {
        if ($('#bahan-wrapper .input-group-wrapper').length > 1) {
            $(this).closest('.input-group-wrapper').remove();
            bahanCount--;
            updateBahanNumbers();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Bisa Dihapus',
                text: 'Minimal harus ada 1 bahan',
                confirmButtonColor: '#ff4a52'
            });
        }
    });

    function updateBahanNumbers() {
        $('#bahan-wrapper .input-number').each(function(index) {
            $(this).text(index + 1);
        });
    }

    // ========== DINAMIS LANGKAH ==========
    let langkahCount = {{ count($resep->langkah) }};

    function tambahLangkah() {
        langkahCount++;
        $('#langkah-wrapper').append(`
            <div class="input-group-wrapper">
                <div class="d-flex align-items-start">
                    <div class="input-number">${langkahCount}</div>
                    <div class="flex-grow-1">
                        <textarea name="langkah[]" class="form-control" rows="3" placeholder="Jelaskan langkah selanjutnya..." required></textarea>
                    </div>
                    <button type="button" class="btn btn-remove ml-3 remove-langkah">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `);
        updateLangkahNumbers();
    }

    $(document).on('click', '.remove-langkah', function() {
        if ($('#langkah-wrapper .input-group-wrapper').length > 1) {
            $(this).closest('.input-group-wrapper').remove();
            langkahCount--;
            updateLangkahNumbers();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Bisa Dihapus',
                text: 'Minimal harus ada 1 langkah',
                confirmButtonColor: '#ff4a52'
            });
        }
    });

    function updateLangkahNumbers() {
        $('#langkah-wrapper .input-number').each(function(index) {
            $(this).text(index + 1);
        });
    }

    // ========== FORM VALIDATION ==========
    $('form').on('submit', function(e) {
        const kategoriChecked = $('.category-checkbox:checked').length;
        
        if (kategoriChecked === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Kategori Wajib Dipilih',
                text: 'Silakan pilih minimal 1 kategori resep',
                confirmButtonColor: '#ff4a52'
            });
            return false;
        }
    });
</script>
@endsection