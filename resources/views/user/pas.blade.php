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
                    <p class="mb-0 mt-1 small opacity-75">Informasi masa berlaku PAS pegawai PT. Angkasa Pratama Sejahtera
                    </p>
                </div>
                <div class="card-body">
                    <div class="p-3">
                        {{-- Form Pencarian --}}
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <form action="{{ route('users.pas') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari berdasarkan NIP atau Nama" value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-search me-1"></i>Cari
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Tabel PAS --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover kontrak-table">
                                            <thead>
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
                                                        <td>{{ \Carbon\Carbon::parse($users->pas_registered)->translatedFormat('d M Y') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($users->pas_expired)->translatedFormat('d M Y') }}
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $statusClass }}">
                                                                <i
                                                                    class="bx {{ $statusIcon }} me-1"></i>{{ $statusText }}
                                                            </span>
                                                            @if ($months <= 2 && $months >= 0)
                                                                <small class="d-block text-muted mt-1">Sisa:
                                                                    {{ $months }} bulan</small>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('users.PASEdit', $users->id) }}"
                                                                class="action-btn" title="Edit Pas">
                                                                <i class="bx bx-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Empty State -->
                                    {{-- @if ($shifts->isEmpty())
                    <div class="text-center py-5">
                        <i class="bx bx-time bx-lg text-muted mb-3" style="font-size: 4rem;"></i>
                        <h5 class="text-muted">Belum ada shift</h5>
                        <p class="text-muted">Mulai dengan membuat shift pertama Anda</p>
                        <a href="{{ route('shift.create') }}" class="create-btn mt-3">
                            <i class="bx bx-plus-circle"></i> Create First Shift
                        </a>
                    </div>
                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- Pagination --}}
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-2">
                        <div class="text-muted small text-center text-md-start">
                            Menampilkan {{ $user->firstItem() }} - {{ $user->lastItem() }} dari {{ $user->total() }} data
                        </div>
                        <nav class="pagination-container">
                            {{ $user->onEachSide(1)->links('pagination::bootstrap-5') }}
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
        .table td,
        .table th {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.75rem;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            overflow-x: auto;
            /* kalau halaman terlalu banyak, bisa digeser horizontal */
            -webkit-overflow-scrolling: touch;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .pagination .page-item {
            flex: 0 0 auto;
        }

        .pagination .page-link {
            min-width: 38px;
            text-align: center;
        }

        .kontrak-table {
            width: 100%;
            table-layout: auto;
        }

        .kontrak-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #566a7f;
            padding: 1rem;
            border-bottom: 2px solid #e9ecef;
        }

        .kontrak-table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .kontrak-table tr:hover {
            background-color: #f8f9fa;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background: #667eea;
            color: white;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background: #5a6fd8;
            transform: translateY(-1px);
            color: white;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert untuk notifikasi
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
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
