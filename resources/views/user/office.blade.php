@extends('layout.admin')

@section('title', 'Manajemen Staff Kantor')

@section('styles')
    <style>
        .table-responsive table {
            min-width: 100%;
            border-collapse: collapse;
        }

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
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="py-4">

            {{-- Header dengan Breadcrumb --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Manajemen Staff Kantor</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                        <li class="breadcrumb-item active">Staff Kantor</li>
                    </ol>
                </nav>
            </div>

            {{-- Card Utama --}}
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0 text-white">
                        <i class="bx bx-user me-2"></i>Data Staff Kantor
                    </h5>
                    <p class="mb-0 mt-1 small opacity-75">Informasi staff kantor PT. Angkasa Pratama Sejahtera</p>
                </div>
                <div class="card-body">
                    <div class="p-3">
                        {{-- Form Pencarian --}}
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <form action="{{ route('users.index') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari berdasarkan NIP atau Nama" value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-search me-1"></i>Cari
                                        </button>
                                        @if (request('search'))
                                            <a href="{{ route('users.index') }}" class="btn btn-outline-danger">Reset</a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('users.create') }}" class="btn btn-success">
                                    <i class="bx bx-plus-circle me-1"></i> Tambah Staff
                                </a>
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
                                                    <th width="12%">NIP</th>
                                                    <th width="18%">Nama</th>
                                                    <th width="18%">Email</th>
                                                    <th width="15%">Jabatan</th>
                                                    <th width="12%">Role</th>
                                                    <th width="15%">Kantor</th>
                                                    <th width="10%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($user as $item)
                                                    <tr>
                                                        <td><strong>{{ $item->id }}</strong></td>
                                                        <td>{{ $item->fullname }}</td>
                                                        <td>{{ $item->email }}</td>
                                                        <td>{{ $item->job_title }}</td>
                                                        <td>
                                                            <span class="badge bg-primary">
                                                                {{ $item->role }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $item->station }}</td>
                                                        <td class="text-center">
                                                            <form id="resetPasswordForm-{{ $item->id }}"
                                                                action="{{ route('user.resetPassword', $item->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="button" class="action-btn border-0"
                                                                    onclick="confirmReset({{ $item->id }})"
                                                                    title="Reset Password" style="background: #667eea;">
                                                                    <i class="bx bx-refresh"></i>
                                                                </button>
                                                            </form>
                                                        </td>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmReset(userId) {
            Swal.fire({
                title: 'Reset Password?',
                text: 'Apakah Anda ingin mereset password pengguna ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('resetPasswordForm-' + userId).submit();
                }
            });
        }

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
