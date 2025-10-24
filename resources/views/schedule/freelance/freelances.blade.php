@extends('layout.admin')

@section('title', 'Freelance')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="py-4">

            {{-- Header dengan Breadcrumb --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Freelance</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Schedule</a></li>
                        <li class="breadcrumb-item active">Data Freelance</li>
                    </ol>
                </nav>
            </div>

            {{-- Card Utama --}}
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0 text-white">
                            <i class="bx bx-user me-2"></i>Data Freelance
                            <p class="mb-0 mt-1 small opacity-75">Sebuah informasi tentang jadwal yang terdaftar dalam
                                sistem</p>
                    </div>
                    <a href="{{ route('freelance.create') }}" class="btn btn-light btn-sm">
                        <i class="bx bx-plus me-1"></i>Tambah Freelance
                    </a>
                </div>
                <div class="card-body">
                    <div class="p-3">
                        {{-- Form Pencarian --}}
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <form action="{{ route('schedule.freelances') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari berdasarkan Nama" value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-search me-1"></i>Cari
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Tabel Data --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover kontrak-table">
                                            <thead>
                                                <tr>
                                                <tr>
                                                    <th width="40%">Fullname</th>
                                                    <th width="40%">Email</th>
                                                    <th width="20%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($user as $users)
                                                    <tr>
                                                        <td>{{ $users->name }}</td>
                                                        <td>{{ $users->email }}</td>
                                                        <td>
                                                            @if ($users->active == 1)
                                                                <span class="badge bg-success">
                                                                    <i class="bx bx-check-circle me-1"></i> Aktif
                                                                </span>
                                                            @else
                                                                <span class="badge bg-danger">
                                                                    <i class="bx bx-x-circle me-1"></i> Tidak Aktif
                                                                </span>
                                                            @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        .btn-group .btn {
            margin: 0 2px;
        }
    </style>
@endsection
