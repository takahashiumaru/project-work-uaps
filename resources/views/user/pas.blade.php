@extends('layout.admin')

@section('title', 'Manajemen PAS Tahunan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">

        {{-- Header dengan Breadcrumb --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Manajemen PAS Tahunan</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                    <li class="breadcrumb-item active">PAS Tahunan</li>
                </ol>
            </nav>
        </div>

        {{-- Card Utama --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0 text-white">
                    <i class="bx bx-id-card me-2"></i>Data PAS (Izin Masuk Area Terbatas)
                </h5>
                <p class="mb-0 mt-1 small opacity-75">Informasi masa berlaku PAS pegawai PT. Angkasa Pratama Sejahtera</p>
            </div>
            <div class="card-body">


                {{-- Tabel PAS --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="15%">NIP</th>
                                <th width="20%">Nama Lengkap</th>
                                <th width="15%">PAS Terdaftar</th>
                                <th width="15%">PAS Habis</th>
                                <th width="15%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $users)
                            @php
                            $now = strtotime(date('Y-m-d'));
                            $expired = strtotime($users->pas_expired);
                            $diff = $expired - $now;
                            $months = floor($diff / (30 * 60 * 60 * 24));
                            
                            $statusClass = '';
                            $statusText = '';
                            $statusIcon = '';
                            
                            if ($months <= 2 && $months >= 0) {
                                $statusClass = 'warning';
                                $statusText = 'Akan Habis';
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
                                <td>{{ \Carbon\Carbon::parse($users->pas_registered)->translatedFormat('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($users->pas_expired)->translatedFormat('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $statusClass }}">
                                        <i class="bx {{ $statusIcon }} me-1"></i>{{ $statusText }}
                                    </span>
                                    @if ($months <= 2 && $months >= 0)
                                    <small class="d-block text-muted mt-1">Sisa: {{ $months }} bulan</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('users.PASEdit', $users->id) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Edit PAS">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Menampilkan {{ $user->firstItem() }} - {{ $user->lastItem() }} dari {{ $user->total() }} data
                    </div>
                    <nav>
                        {{ $user->links('pagination::bootstrap-5') }}
                    </nav>
                </div>

                {{-- Legend Status --}}
                <div class="card mt-4">
                    <div class="card-body">
                        <small class="d-block mb-2 fw-semibold">Keterangan Status:</small>
                        <div class="row small">
                            <div class="col-md-4">
                                <span class="badge bg-success me-2"><i class="bx bx-check-circle"></i></span>
                                Aktif = PAS masih berlaku (lebih dari 2 bulan)
                            </div>
                            <div class="col-md-4">
                                <span class="badge bg-warning me-2"><i class="bx bx-time-five"></i></span>
                                Akan Habis = PAS berakhir dalam 2 bulan atau kurang
                            </div>
                            <div class="col-md-4">
                                <span class="badge bg-danger me-2"><i class="bx bx-x-circle"></i></span>
                                Kadaluarsa = PAS sudah berakhir
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
    
    /* Custom Pagination Styling */
    .pagination .page-item {
        margin: 2px;
    }
    
    .pagination .page-link {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
        border: 1px solid #d9dee3;
        color: #697a8d;
        background-color: #fff;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #4180c3;
        border-color: #4180c3;
        color: #fff;
    }
    
    .pagination .page-link:hover {
        background-color: #e7e7ff;
        border-color: #4180c3;
        color: #4180c3;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // SweetAlert untuk notifikasi
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

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bootstrapAlert = new bootstrap.Alert(alert);
                bootstrapAlert.close();
            });
        }, 5000);
    });
</script>
@endsection