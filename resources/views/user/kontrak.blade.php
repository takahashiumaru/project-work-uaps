@extends('layout.admin')

@section('title', 'Manajemen Kontrak Karyawan')

@section('content')
@section('styles')
    <style>
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

        .table-responsive {
            border-radius: 0.75rem;
            overflow: hidden;
            overflow-x: auto;
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

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #4180c3 100%);
            color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            opacity: 0.9;
            font-size: 0.875rem;
        }

        .create-btn {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .create-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
            color: white;
        }

        .badge-shift {
            background: #667eea;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .time-badge {
            background: #e9ecef;
            color: #566a7f;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }

        .manpower-badge {
            background: #ffeaa7;
            color: #2d3436;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }

            .kontrak-table th,
            .kontrak-table td {
                padding: 0.75rem 0.5rem;
            }

            .create-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection

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
                <div class="p-3">
                    {{-- Form Pencarian --}}
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <form action="{{ route('users.kontrak') }}" method="GET">
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

                {{-- Tabel Kontrak --}}
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
                                                    <td>{{ \Carbon\Carbon::parse($users->contract_start)->translatedFormat('d M Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($users->contract_end)->translatedFormat('d M Y') }}
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
                                                        <a href="{{ route('users.KontrakEdit', ['id' => $users->id, 'page' => request('page')]) }}"
                                                            class="action-btn" title="Edit Kontrak">
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

                {{-- <div class="table-responsive" style="overflow-x: auto;">
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
                </div> --}}

                {{-- Pagination --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-2">
                    <div class="text-muted small text-center text-md-start">
                        Menampilkan {{ $user->firstItem() }} - {{ $user->lastItem() }} dari {{ $user->total() }} data
                    </div>
                    <nav class="pagination-container">
                        {{ $user->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
                {{-- Pagination --}}


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
    .table td,
    .table th {
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
    });
</script>
@endsection
