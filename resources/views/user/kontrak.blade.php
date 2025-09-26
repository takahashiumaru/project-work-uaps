@extends('layout.admin')

@section('title', 'Manajemen Kontrak Karyawan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">

        {{-- Header dengan Breadcrumb --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Manajemen Kontrak Karyawan</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                    <li class="breadcrumb-item active">Kontrak</li>
                </ol>
            </nav>
        </div>

        {{-- Card Utama --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0 text-white">
                    <i class="bx bx-calendar me-2"></i>Data Kontrak Karyawan
                </h5>
                <p class="mb-0 mt-1 small opacity-75">Informasi masa kontrak pegawai PT. Angkasa Pratama Sejahtera</p>
            </div>
            <div class="card-body">

                {{-- Form Pencarian --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form action="{{ route('users.kontrak') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari berdasarkan NIP atau Nama" 
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-search me-1"></i>Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Tabel Kontrak --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="15%">NIP</th>
                                <th width="20%">Nama Lengkap</th>
                                <th width="15%">Kontrak Mulai</th>
                                <th width="15%">Kontrak Berakhir</th>
                                <th width="15%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $users)
                            @php
                            $now = strtotime(date('Y-m-d'));
                            $expired = strtotime($users->contract_end);
                            $diff = $expired - $now;
                            $months = floor($diff / (30 * 60 * 60 * 24));
                            
                            $statusClass = '';
                            $statusText = '';
                            $statusIcon = '';
                            
                            if ($months <= 2 && $months >= 0) {
                                $statusClass = 'warning';
                                $statusText = 'Akan Berakhir';
                                $statusIcon = 'bx-time-five';
                            } elseif ($months < 0) {
                                $statusClass = 'danger';
                                $statusText = 'Kadaluarsa';
                                $statusIcon = 'bx-x-circle';
                            } else {
                                $statusClass = 'success';
                                $statusText = 'Aktif';
                                $statusIcon = 'bx-check-circle';
                            }
                            @endphp
                            <tr>
                                <td><strong>{{ $users->id }}</strong></td>
                                <td>{{ $users->fullname }}</td>
                                <td>{{ \Carbon\Carbon::parse($users->contract_start)->translatedFormat('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($users->contract_end)->translatedFormat('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $statusClass }}">
                                        <i class="bx {{ $statusIcon }} me-1"></i>{{ $statusText }}
                                    </span>
                                    @if ($months <= 2 && $months >= 0)
                                    <small class="d-block text-muted mt-1">Sisa: {{ $months }} bulan</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('users.KontrakEdit', ['id' => $users->id, 'page' => request('page')]) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Edit Kontrak">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                {{-- Pagination --}}
<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted small">
        Menampilkan {{ $user->firstItem() }} - {{ $user->lastItem() }} dari {{ $user->total() }} data
    </div>
    <nav>
        <ul class="pagination pagination-sm mb-0">
            {{-- Previous --}}
            <li class="page-item {{ $user->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $user->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            
            {{-- Page Numbers --}}
            @for ($i = 1; $i <= $user->lastPage(); $i++)
                <li class="page-item {{ $user->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $user->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            
            {{-- Next --}}
            <li class="page-item {{ !$user->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $user->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

                {{-- Legend Status --}}
                <div class="card mt-4">
                    <div class="card-body">
                        <small class="d-block mb-2 fw-semibold">Keterangan Status:</small>
                        <div class="row small">
                            <div class="col-md-4">
                                <span class="badge bg-success me-2"><i class="bx bx-check-circle"></i></span>
                                Aktif = Kontrak masih berlaku (lebih dari 2 bulan)
                            </div>
                            <div class="col-md-4">
                                <span class="badge bg-warning me-2"><i class="bx bx-time-five"></i></span>
                                Akan Berakhir = Kontrak berakhir dalam 2 bulan atau kurang
                            </div>
                            <div class="col-md-4">
                                <span class="badge bg-danger me-2"><i class="bx bx-x-circle"></i></span>
                                Kadaluarsa = Kontrak sudah berakhir
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .table td, .table th {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.75rem;
    }
    .pagination {
        margin-bottom: 0;
    }
</style>
@endsection

@section('scripts')
<script>
    // SweetAlert untuk konfirmasi jika ada
    document.addEventListener('DOMContentLoaded', function() {
        // Jika ada pesan sukses dari controller
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endsection