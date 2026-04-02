@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="h4 mb-0 text-gray-800">Edit Resep</h4>
        <a href="{{ route('admin.resep.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.resep.update', $resep->id) }}" method="POST" enctype="multipart/form-data">
                @csrf   
                @method('PUT')

                <div class="row">
                    {{-- INFO DASAR --}}
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Judul Resep</label>
                            <input type="text" name="judul" value="{{ old('judul', $resep->judul) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', trim($resep->deskripsi)) }}</textarea>
                        </div>
                    </div>

                    {{-- META DATA & FOTO --}}
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Kategori (Maksimal 4)</label>
                            <select name="kategori_id[]" multiple class="form-control select2" required>
                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat->id }}"
                                        {{ $resep->kategori->contains($kat->id) ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Waktu Masak (Menit)</label>
                            <input type="number" name="waktu_masak" value="{{ old('waktu_masak', $resep->waktu_masak) }}" class="form-control">
                        </div>
                        {{-- TANGGAL PUBLISH --}}
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Tanggal Publish</label>
                            <input type="datetime-local" 
                                name="tanggal_publish" 
                                class="form-control"
                                value="{{ old('tanggal_publish', isset($resep) ? $resep->tanggal_publish : '') }}">
                            <small class="text-muted">Kosongkan jika ingin langsung publish sekarang</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Foto</label><br>
                            @if ($resep->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$resep->foto) }}" width="150" class="img-thumbnail shadow-sm">
                                </div>
                            @endif
                            <input type="file" name="foto" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    {{-- BAHAN --}}
                    <div class="col-md-6 border-right">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="m-0 font-weight-bold text-primary">Bahan-bahan</h6>
                            <button type="button" class="btn btn-sm btn-success" onclick="tambahBahan()">+ Tambah</button>
                        </div>
                        <div id="bahan-wrapper">
                            @foreach ($resep->bahan as $b)
                                <div class="row mb-2 bahan-item">
                                    <div class="col-md-7">
                                        <input type="text" name="bahan[]" class="form-control" value="{{ $b->nama_bahan }}" required>
                                    </div>
                                    <div class="col-md p-0">
                                        <input type="text" name="jumlah[]" class="form-control" value="{{ $b->jumlah }}" required>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- LANGKAH --}}
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="m-0 font-weight-bold text-primary">Langkah Memasak</h6>
                            <button type="button" class="btn btn-sm btn-success" onclick="tambahLangkah()">+ Tambah</button>
                        </div>
                        <div id="langkah-wrapper">
                            @foreach ($resep->langkah as $index => $l)
                                <div class="d-flex mb-2 langkah-item">
                                    <textarea name="langkah[]" rows="2" class="form-control" placeholder="Langkah {{ $index + 1 }}" required>{{ $l->deskripsi_langkah }}</textarea>
                                    <div class="ml-2">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Update Resep
                    </button>
                    <a href="{{ route('admin.resep.index') }}" class="btn btn-secondary px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Inisialisasi Select2 dengan batasan 4 kategori
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
    document.getElementById('bahan-wrapper').insertAdjacentHTML('beforeend', `
        <div class="row mb-2 bahan-item">
            <div class="col-md-7">
                <input type="text" name="bahan[]" class="form-control" placeholder="Nama bahan" required>
            </div>
            <div class="col-md p-0">
                <input type="text" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
            </div>
            <div class="col-md-1 text-right">
                <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `);
}

function tambahLangkah() {
    const wrapper = document.getElementById('langkah-wrapper');
    const nomor = wrapper.querySelectorAll('.langkah-item').length + 1;

    wrapper.insertAdjacentHTML('beforeend', `
        <div class="d-flex mb-2 langkah-item">
            <textarea name="langkah[]" rows="2" class="form-control" placeholder="Langkah ${nomor}" required></textarea>
            <div class="ml-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `);
}

function hapusBaris(btn) {
    btn.closest('.bahan-item, .langkah-item').remove();
    // Reset nomor placeholder langkah setelah penghapusan
    document.querySelectorAll('#langkah-wrapper textarea').forEach((el, i) => {
        el.placeholder = "Langkah " + (i + 1);
    });
}
</script>
@endsection