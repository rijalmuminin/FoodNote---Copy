@extends('layouts.backend') {{-- Sesuaikan dengan layout admin kamu --}}

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="h4 mb-0 text-gray-800">Tambah Resep Baru (Admin)</h4>
        <a href="{{ route('admin.resep.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.resep.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- INFO DASAR --}}
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Judul Resep</label>
                            <input type="text" name="judul" class="form-control" placeholder="Masukkan judul masakan" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Deskripsi</label>
                            <textarea name="deskripsi" rows="4" class="form-control" placeholder="Ceritakan singkat tentang masakan ini..." required></textarea>
                        </div>
                    </div>

                    {{-- META DATA --}}
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Kategori (Maksimal 4)</label>
                            <select name="kategori_id[]" class="form-control select2" multiple required>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Waktu Memasak (Menit)</label>
                            <input type="number" name="waktu_masak" class="form-control" placeholder="Contoh: 30" min="1">
                        </div>

                        {{-- TANGGAL PUBLISH --}}
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Tanggal Publish</label>
                            <input type="datetime-local" name="tanggal_publish" class="form-control">
                            <small class="text-muted">Kosongkan jika ingin publish langsung sekarang</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Foto Resep</label>
                            <input type="file" name="foto" class="form-control shadow-none">
                            <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    {{-- BAGIAN BAHAN --}}
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="m-0 font-weight-bold text-primary">Bahan-bahan</h6>
                            <button type="button" class="btn btn-sm btn-success" onclick="tambahBahan()">+ Tambah</button>
                        </div>
                        <div id="bahan-wrapper">
                            <div class="row mb-2">
                                <div class="col-md-7">
                                    <input type="text" name="bahan[]" class="form-control" placeholder="Nama bahan" required>
                                </div>
                                <div class="col-md-4 p-0">
                                    <input type="text" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                    </div>

                    {{-- BAGIAN LANGKAH --}}
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="m-0 font-weight-bold text-primary">Langkah Memasak</h6>
                            <button type="button" class="btn btn-sm btn-success" onclick="tambahLangkah()">+ Tambah</button>
                        </div>
                        <div id="langkah-wrapper">
                            <div class="d-flex mb-2">
                                <textarea name="langkah[]" class="form-control" rows="2" placeholder="Langkah 1" required></textarea>
                                <div style="width: 45px"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 border-top pt-4">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-save"></i> Simpan Resep
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Pilih kategori",
        allowClear: true,
        width: '100%',
        maximumSelectionLength: 4,
        language: {
            maximumSelected: function (e) {
                return "Maksimal pilih " + e.maximum + " kategori";
            }
        }
    });
});

function tambahBahan() {
    const html = `
        <div class="row mb-2">
            <div class="col-md-7">
                <input type="text" name="bahan[]" class="form-control" placeholder="Nama bahan" required>
            </div>
            <div class="col-md-4 p-0">
                <input type="text" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
            </div>
            <div class="col-md-1 text-right">
                <button type="button" class="btn btn-danger btn-sm btn-remove"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;
    $('#bahan-wrapper').append(html);
}

function tambahLangkah() {
    const wrapper = $('#langkah-wrapper');
    const nomor = wrapper.find('textarea').length + 1;
    const html = `
        <div class="d-flex mb-2">
            <textarea name="langkah[]" class="form-control" rows="2" placeholder="Langkah ${nomor}" required></textarea>
            <div style="width: 45px" class="text-right ml-2">
                <button type="button" class="btn btn-danger btn-sm btn-remove"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;
    wrapper.append(html);
}

$(document).on('click', '.btn-remove', function() {
    $(this).closest('.row, .d-flex').remove();
    $('#langkah-wrapper textarea').each(function(index) {
        $(this).attr('placeholder', 'Langkah ' + (index + 1));
    });
});
</script>
@endsection
