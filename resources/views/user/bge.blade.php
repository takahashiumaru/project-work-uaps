@extends('layout.admin')

@section('title', 'Manajemen Porter BGE')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="py-4">

            {{-- Header dengan Breadcrumb --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Manajemen Porter BGE</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Daftar User</a></li>
                        <li class="breadcrumb-item active">Porter BGE</li>
                    </ol>
                </nav>
            </div>

            {{-- Card Utama --}}
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0 text-white">
                            <i class="bx bx-user me-2"></i>Data Porter BGE
                        </h5>
                        <p class="mb-0 mt-1 small opacity-75">Informasi pegawai porter BGE PT. Angkasa Pratama Sejahtera</p>
                    </div>
                    <a href="{{ route('users.create') }}" class="btn btn-light btn-sm">
                        <i class="bx bx-plus me-1"></i>Tambah User
                    </a>
                </div>
                <div class="card-body">
                    <div class="p-3">
                        {{-- Form Pencarian --}}
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <form action="{{ route('users.bge') }}" method="GET">
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
                                                    <th width="15%">NIP</th>
                                                    <th width="20%">Nama Lengkap</th>
                                                    <th width="15%">Role</th>
                                                    <th width="15%">Dibuat Pada</th>
                                                    <th width="15%">Diupdate Pada</th>
                                                    <th width="20%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($user as $users)
                                                    <tr>
                                                        <td><strong>{{ $users->id }}</strong></td>
                                                        <td>{{ $users->fullname }}</td>
                                                        <td>
                                                            <span class="badge bg-label-primary">{{ $users->role }}</span>
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($users->created_at)->translatedFormat('d M Y H:i') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($users->updated_at)->translatedFormat('d M Y H:i') }}
                                                        </td>
                                                        <td class="d-flex align-items-center gap-2">
                                                            <div>
                                                                {{-- Tombol Show --}}
                                                                <a href="{{ route('users.show', ['user' => $users->id, 'page' => request('page')]) }}"
                                                                    class="action-btn"
                                                                    style="background: rgb(93, 190, 222);"
                                                                    title="Lihat Detail">
                                                                    <i class="bx bx-show"></i>
                                                                </a>
                                                                {{-- Tombol Edit --}}
                                                                <a href="{{ route('users.edit', ['user' => $users->id, 'page' => request('page')]) }}"
                                                                    class="action-btn"; title="Edit Data">
                                                                    <i class="bx bx-edit"></i>
                                                                </a>

                                                                {{-- Tombol Reset Password --}}
                                                                <button type="submit" class="action-btn border-0"
                                                                    title="Reset Password" style="background: grey;"
                                                                    onclick="confirmReset({{ $users->id }}, '{{ $users->fullname }}')">
                                                                    <i class="bx bx-refresh"></i>
                                                                </button>
                                                                {{-- Tombol Delete --}}
                                                                <button type="submit" class="action-btn border-0 "
                                                                    title="Hapus User" style="background: red;"
                                                                    onclick="confirmDelete({{ $users->id }}, '{{ $users->fullname }}')">
                                                                    <i class="bx bx-trash"></i>
                                                                </button>
                                                            </div>

                                                            {{-- Form Hidden untuk Reset Password --}}
                                                            <form id="resetPasswordForm-{{ $users->id }}"
                                                                action="{{ route('user.resetPassword', $users->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('PUT')
                                                            </form>

                                                            {{-- Form Hidden untuk Delete --}}
                                                            <form id="deleteForm-{{ $users->id }}"
                                                                action="{{ route('users.destroy', $users->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
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

@section('scripts')
    <script>
        function confirmReset(userId, userName) {
            Swal.fire({
                title: 'Reset Password?',
                html: `Apakah Anda yakin ingin mereset password untuk <strong>${userName}</strong>?<br><small>Password akan direset ke default</small>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4180c3',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'sweetalert-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`resetPasswordForm-${userId}`).submit();
                }
            });
        }

        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Hapus User?',
                html: `Apakah Anda yakin ingin menghapus user <strong>${userName}</strong>?<br><small>Data yang dihapus tidak dapat dikembalikan</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'sweetalert-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deleteForm-${userId}`).submit();
                }
            });
        }

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
