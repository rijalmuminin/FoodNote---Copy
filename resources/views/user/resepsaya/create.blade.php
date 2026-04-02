@extends('layouts.frontend')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* ========== GENERAL RESET & TYPOGRAPHY ========== */
    .recepie_details_area * { box-sizing: border-box; }
    .recepie_details_area label {
        font-family: "Poppins", sans-serif !important;
        font-size: 15px !important; 
        font-weight: 600 !important;
        color: #2d3436 !important;
        margin-bottom: 8px !important;
        display: block;
    }
    .recepie_details_area label .required { color: #ff4a52; margin-left: 3px; }
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
    }
    .recepie_details_area textarea.form-control { height: auto !important; min-height: 100px !important; resize: vertical; }

    /* ========== FILE INPUT ========== */
    .file-input-wrapper { position: relative; overflow: hidden; display: inline-block; width: 100%; }
    .file-input-wrapper input[type=file] { position: absolute; left: -9999px; }
    .file-input-label {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        padding: 40px 20px; background: #f8f9fa; border: 2px dashed #dee2e6;
        border-radius: 8px; cursor: pointer; transition: all 0.3s ease; text-align: center;
    }
    .file-input-label:hover { border-color: #ff4a52; background: #fff4f4; }
    .file-input-label i { font-size: 24px; color: #ff4a52; }
    .file-preview { margin-top: 15px; display: none; }
    .file-preview img { max-width: 200px; border-radius: 8px; border: 2px solid #e8e8e8; }

    /* ========== DROPDOWN KATEGORI ========== */
    .btn-dropdown-custom {
        min-height: 50px !important; height: auto !important; background: #fff !important;
        border: 2px solid #e8e8e8 !important; border-radius: 8px !important;
        width: 100%; text-align: left; padding: 8px 40px 8px 12px !important;
        display: flex; flex-wrap: wrap; align-items: center; gap: 6px; position: relative;
    }
    .dropdown-menu-custom {
        width: 100%; max-height: 280px; overflow-y: auto; padding: 8px;
        border: 2px solid #e8e8e8; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .category-item { padding: 10px 12px; display: flex; align-items: center; cursor: pointer; border-radius: 6px; font-size: 14px; }
    .category-item:hover { background: #fff4f4; }
    .badge-category-inline {
        background: #f1f3f5 !important; color: #2d3436 !important; padding: 5px 10px;
        border-radius: 6px; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; border: 1px solid #dee2e6;
    }
    .badge-category-inline .remove-tag { cursor: pointer; color: #adb5bd; }
    .badge-category-inline .remove-tag:hover { color: #ff4a52; }

    /* ========== DYNAMIC SECTIONS ========== */
    .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f1f3f5; }
    .input-group-wrapper { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 12px; border: 1px solid #e9ecef; animation: fadeIn 0.3s ease; }
    .input-number { width: 35px; height: 35px; background: #ff4a52; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; margin-right: 10px; flex-shrink: 0; }
    
    .btn-add { background: linear-gradient(135deg, #10ac84 0%, #1dd1a1 100%); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; }
    .btn-remove { width: 40px; height: 40px; background: #ff6b6b; border: none; border-radius: 8px; color: white; display: flex; align-items: center; justify-content: center; }
    .btn-primary-custom { background: linear-gradient(135deg, #ff4a52 0%, #ff6b72 100%) !important; border: none !important; color: white !important; padding: 16px 50px !important; font-weight: 600 !important; border-radius: 10px !important; text-transform: uppercase; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection


@section('content')
<div class="bradcam_area bradcam_bg_1">
    <div class="container text-center">
        <h3>Tambah Resep Baru</h3>
    </div>
</div>

<div class="recepie_details_area">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        
                        {{-- Alert Error Global di Atas --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <strong>Waduh! Ada yang salah:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="recipeForm" action="{{ route('user.resepsaya.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mb-4">
                                <label>Nama Resep <span class="required">*</span></label>
                                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Contoh: Ayam Bakar Madu" value="{{ old('judul') }}">
                                @error('judul')
                                    <small class="text-danger font-weight-bold">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label>Deskripsi Resep</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" placeholder="Ceritakan singkat tentang resep ini...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <small class="text-danger font-weight-bold">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label>Waktu Masak (Menit) <span class="required">*</span></label>
                                        <input type="number" name="waktu_masak" class="form-control @error('waktu_masak') is-invalid @enderror" placeholder="30" min="1" value="{{ old('waktu_masak') }}">
                                        @error('waktu_masak')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label>Kategori (Maksimal 4) <span class="required">*</span></label>
                                        <div class="dropdown">
                                            <button class="btn btn-dropdown-custom dropdown-toggle @error('kategori_id') is-invalid @enderror" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                                <span class="placeholder-text">Pilih Kategori</span>
                                                <i class="fas fa-chevron-down ml-auto"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-custom">
                                                @foreach ($kategoris as $kategori)
                                                <label class="category-item w-100 mb-0">
                                                    <input type="checkbox" name="kategori_id[]" value="{{ $kategori->id }}" 
                                                        data-nama="{{ $kategori->nama_kategori }}" 
                                                        class="category-checkbox mr-2"
                                                        {{ (is_array(old('kategori_id')) && in_array($kategori->id, old('kategori_id'))) ? 'checked' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @error('kategori_id')
                                            <small class="text-danger font-weight-bold">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label>Tanggal Publish <span class="required">*</span></label>
                                        <input type="date" name="tanggal_publish" class="form-control" value="{{ old('tanggal_publish', date('Y-m-d')) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label>Foto Masakan <span class="required">*</span></label>
                                <div class="file-input-wrapper @error('foto') border-danger @enderror" style="border: 1px dashed #ddd; border-radius: 10px;">
                                    <input type="file" name="foto" id="foto-input" accept="image/*">
                                    <label for="foto-input" class="file-input-label">
                                        <i class="fas fa-cloud-upload-alt mr-3"></i>
                                        <span><strong>Klik untuk upload foto</strong><br><small>JPG, PNG (Max 2MB)</small></span>
                                    </label>
                                </div>
                                @error('foto')
                                    <small class="text-danger font-weight-bold">{{ $message }}</small>
                                @enderror
                                <div class="file-preview" id="foto-preview" style="display: none; margin-top: 15px;">
                                    <img src="" alt="Preview" style="max-width: 200px; border-radius: 10px;">
                                </div>
                            </div>

                            <hr class="my-5">

                            {{-- SECTION BAHAN --}}
                            <div class="section-header d-flex justify-content-between align-items-center mb-3">
                                <h4><i class="fas fa-shopping-basket text-danger mr-2"></i> Bahan-bahan</h4>
                                <button type="button" class="btn btn-add" id="btn-tambah-bahan">
                                    <i class="fas fa-plus"></i> Tambah Bahan
                                </button>
                            </div>
                            <div id="bahan-wrapper">
                                @if(old('bahan'))
                                    @foreach(old('bahan') as $index => $val)
                                    <div class="input-group-wrapper mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="input-number mr-2">{{ $index + 1 }}</div>
                                            <div class="flex-grow-1">
                                                <div class="row">
                                                    <div class="col-md-7 mb-2 mb-md-0">
                                                        <input type="text" name="bahan[]" class="form-control" placeholder="Bahan" value="{{ $val }}">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" name="jumlah[]" class="form-control" placeholder="Jumlah" value="{{ old('jumlah')[$index] }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-remove ml-3 {{ $index == 0 ? '' : 'remove-bahan' }}" {{ $index == 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="input-group-wrapper mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="input-number mr-2">1</div>
                                            <div class="flex-grow-1">
                                                <div class="row">
                                                    <div class="col-md-7 mb-2 mb-md-0"><input type="text" name="bahan[]" class="form-control" placeholder="Bahan"></div>
                                                    <div class="col-md-5"><input type="text" name="jumlah[]" class="form-control" placeholder="Jumlah"></div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-remove ml-3" disabled><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <hr class="my-5">

                            {{-- SECTION LANGKAH --}}
                            <div class="section-header d-flex justify-content-between align-items-center mb-3">
                                <h4><i class="fas fa-list-ol text-danger mr-2"></i> Langkah Memasak</h4>
                                <button type="button" class="btn btn-add" id="btn-tambah-langkah">
                                    <i class="fas fa-plus"></i> Tambah Langkah
                                </button>
                            </div>
                            <div id="langkah-wrapper">
                                @if(old('langkah'))
                                    @foreach(old('langkah') as $index => $val)
                                    <div class="input-group-wrapper mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="input-number mr-2">{{ $index + 1 }}</div>
                                            <div class="flex-grow-1">
                                                <textarea name="langkah[]" class="form-control" rows="3" placeholder="Langkah {{ $index + 1 }}...">{{ $val }}</textarea>
                                            </div>
                                            <button type="button" class="btn btn-remove ml-3 {{ $index == 0 ? '' : 'remove-langkah' }}" {{ $index == 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="input-group-wrapper mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="input-number mr-2">1</div>
                                            <div class="flex-grow-1">
                                                <textarea name="langkah[]" class="form-control" rows="3" placeholder="Langkah 1..."></textarea>
                                            </div>
                                            <button type="button" class="btn btn-remove ml-3" disabled><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn-primary-custom">Simpan Resep</button>
                                <a href="{{ route('user.resepsaya.index') }}" class="btn btn-light py-3 px-5 ml-2" style="border-radius:10px; font-weight:600;">Batal</a>
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
<script>
    $(document).ready(function() {
        // Panggil fungsi tag kategori saat pertama kali load untuk old values
        updateKategoriTags();

        // ========== PREVIEW FOTO ==========
        $('#foto-input').on('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    $('#foto-preview img').attr('src', e.target.result);
                    $('#foto-preview').fadeIn();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // ========== KATEGORI LOGIC ==========
        $('.category-checkbox').on('change', function() {
            if ($('.category-checkbox:checked').length > 4) {
                $(this).prop('checked', false);
                alert('Maksimal 4 kategori saja ya!');
                return;
            }
            updateKategoriTags();
        });

        function updateKategoriTags() {
            const container = $('#dropdownMenuButton');
            const checked = $('.category-checkbox:checked');
            container.find('.badge-category-inline').remove();
            container.find('.placeholder-text').remove();

            if (checked.length === 0) {
                container.prepend('<span class="placeholder-text">Pilih Kategori</span>');
            } else {
                checked.each(function() {
                    container.prepend(`
                        <span class="badge-category-inline mr-1" style="background: #ff4a52; color: white; padding: 2px 8px; border-radius: 5px; font-size: 12px;">
                            ${$(this).data('nama')}
                            <i class="fas fa-times remove-tag ml-1" data-id="${$(this).val()}" style="cursor:pointer"></i>
                        </span>
                    `);
                });
            }
        }

        $(document).on('click', '.remove-tag', function(e) {
            e.stopPropagation();
            $(`.category-checkbox[value="${$(this).data('id')}"]`).prop('checked', false).trigger('change');
        });

        $('.dropdown-menu-custom').on('click', (e) => e.stopPropagation());

        // ========== DINAMIS BAHAN ==========
        $('#btn-tambah-bahan').on('click', function() {
            const index = $('#bahan-wrapper .input-group-wrapper').length + 1;
            const html = `
                <div class="input-group-wrapper mb-3">
                    <div class="d-flex align-items-center">
                        <div class="input-number mr-2">${index}</div>
                        <div class="flex-grow-1">
                            <div class="row">
                                <div class="col-md-7 mb-2 mb-md-0"><input type="text" name="bahan[]" class="form-control" placeholder="Bahan" required></div>
                                <div class="col-md-5"><input type="text" name="jumlah[]" class="form-control" placeholder="Jumlah" required></div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-remove ml-3 remove-bahan"><i class="fas fa-trash"></i></button>
                    </div>
                </div>`;
            $('#bahan-wrapper').append(html);
        });

        $(document).on('click', '.remove-bahan', function() {
            $(this).closest('.input-group-wrapper').remove();
            $('#bahan-wrapper .input-number').each((i, el) => $(el).text(i + 1));
        });

        // ========== DINAMIS LANGKAH ==========
        $('#btn-tambah-langkah').on('click', function() {
            const index = $('#langkah-wrapper .input-group-wrapper').length + 1;
            const html = `
                <div class="input-group-wrapper mb-3">
                    <div class="d-flex align-items-start">
                        <div class="input-number mr-2">${index}</div>
                        <div class="flex-grow-1">
                            <textarea name="langkah[]" class="form-control" rows="3" placeholder="Langkah ${index}..." required></textarea>
                        </div>
                        <button type="button" class="btn btn-remove ml-3 remove-langkah"><i class="fas fa-trash"></i></button>
                    </div>
                </div>`;
            $('#langkah-wrapper').append(html);
        });

        $(document).on('click', '.remove-langkah', function() {
            $(this).closest('.input-group-wrapper').remove();
            $('#langkah-wrapper .input-number').each((i, el) => $(el).text(i + 1));
        });

        // ========== VALIDASI SUBMIT ==========
        $('#recipeForm').on('submit', function(e) {
            if ($('.category-checkbox:checked').length === 0) {
                e.preventDefault();
                alert('Pilih minimal 1 kategori!');
            }
        });
    });
</script>
@endsection