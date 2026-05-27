@extends('layout.admin')

@section('title', 'Manajemen Staff Kantor')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="py-4">
            {{-- Header --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Manajemen Staff Kantor</h4>
                    <p class="text-muted mb-0" style="font-size:0.875rem;">Informasi staff kantor PT. Angkasa Pratama Sejahtera</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-plus-circle me-1"></i> Tambah Staff
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    {{-- Toolbar --}}
                    <div class="dt-toolbar">
                        <form action="{{ route('users.office') }}" method="GET" class="dt-search">
                            <i class="bx bx-search search-icon"></i>
                            <input type="text" name="search" class="form-control" placeholder="Cari NIP atau Nama..." value="{{ request('search') }}">
                        </form>
                        @if (request('search'))
                        <div class="dt-actions">
                            <a href="{{ route('users.office') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                        </div>
                        @endif
                    </div>

                    {{-- Tabel --}}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jabatan</th>
                                    <th>Role</th>
                                    <th>Kantor</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $item)
                                    <tr>
                                        <td><strong>{{ $item->id }}</strong></td>
                                        <td>{{ $item->fullname }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->job_title }}</td>
                                        <td><span class="badge bg-label-primary">{{ $item->role }}</span></td>
                                        <td>{{ $item->station }}</td>
                                        <td class="text-center">
                                            <form id="resetPasswordForm-{{ $item->id }}" action="{{ route('user.resetPassword', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="action-btn border-0" onclick="confirmReset({{ $item->id }})" title="Reset Password">
                                                    <i class="bx bx-refresh"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 gap-2" style="border-top: 1px solid #f3f4f6;">
                        <div class="text-muted" style="font-size: 0.8125rem;">
                            Menampilkan {{ $user->firstItem() }} - {{ $user->lastItem() }} dari {{ $user->total() }} data
                        </div>
                        <nav>
                            {{ $user->links('vendor.pagination.custom') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmReset(userId) {
            Swal.fire({
                title: 'Reset Password?',
                text: 'Apakah Anda ingin mereset password pengguna ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#111827',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('resetPasswordForm-' + userId).submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false });
            @endif
            @if (session('error'))
                Swal.fire({ icon: 'error', title: 'Gagal', text: '{{ session('error') }}', timer: 3000, showConfirmButton: false });
            @endif
        });
    </script>
@endsection
