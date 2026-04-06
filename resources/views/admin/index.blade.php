@extends('layouts.backend')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Overview</h1>
    </div>

    <div class="row mb-3">
        {{-- Total Resep & Rincian --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-left-primary shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Koleksi Resep</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_resep }}</div>
                            <div class="mt-2 mb-0 text-xs">
                                <span class="text-success mr-2">
                                    <i class="fas fa-check-circle"></i> {{ $resep_approved }} Disetujui
                                </span>
                                <br>
                                <span class="text-danger mr-2">
                                    <i class="fas fa-ban"></i> {{ $resep_rejected }} Ditolak
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book-open fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Menunggu Persetujuan --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-left-warning shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Butuh Persetujuan</div>
                            <div class="h5 mb-0 font-weight-bold text-warning">{{ $resep_pending }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-warning mr-2"><i class="fas fa-clock"></i></span>
                                <span>Menunggu moderasi</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total User --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-left-success shadow-sm">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_user }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fas fa-user-check"></i></span>
                                <span>User terdaftar</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Kategori --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 border-left-info shadow-sm">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Kategori Masakan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_kategori }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-info mr-2"><i class="fas fa-tags"></i></span>
                                <span>Pengelompokan menu</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list-alt fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Resep Terbaru --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Resep Terbaru yang Diunggah</h6>
                    <a href="{{ route('admin.resep.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Judul Resep</th>
                                <th>Penulis</th>
                                <th>Status</th>
                                <th>Tanggal Post</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resep_terbaru as $resep)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold text-dark">{{ Str::limit($resep->judul, 40) }}</td>
                                <td><span class="badge badge-outline-info">{{ $resep->user->name ?? 'Anonim' }}</span></td>
                                <td>
                                    @if($resep->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($resep->status == 'approved')
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $resep->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.resep.show', $resep->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data resep terbaru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 