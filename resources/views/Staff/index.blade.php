@extends('layout.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Data Staff</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Kelola seluruh data karyawan di semua station.</p>
            </div>
            @if(Auth::user()->role == 'Admin')
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('staff.export', ['station' => request('station')]) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bx bx-download me-1"></i>Export CSV
                </a>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bx bx-upload me-1"></i>Import Staff
                </button>
                <a href="{{ route('stations.create') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bx bx-plus me-1"></i>Station Baru
                </a>
                <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
                    <i class="bx bx-plus-circle me-1"></i>Tambah Staff
                </a>
            </div>
            @endif
        </div>

        <div class="card">
            {{-- Tab Station --}}
            <div class="card-header" style="padding-bottom:0 !important;">
                <div class="nav-scroller">
                    <div class="nav nav-tabs">
                        <a class="nav-link {{ request('station') == null ? 'active' : '' }}" href="{{ route('staff.index') }}">
                            <i class="fas fa-globe me-1"></i> Global
                        </a>
                        @foreach($stations as $st)
                        <a class="nav-link {{ request('station') == $st->code ? 'active' : '' }}" href="{{ route('staff.index', ['station' => $st->code]) }}">
                            {{ $st->code }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if(request('station'))
                <div class="d-flex align-items-center gap-2 mb-3 pb-3" style="border-bottom: 1px solid #f3f4f6;">
                    <i class="bx bx-info-circle text-muted"></i>
                    <small class="text-muted">Menampilkan data staff area: <strong>{{ request('station') }}</strong></small>
                </div>
                @endif

                {{-- Toolbar --}}
                <div class="dt-toolbar">
                    <form action="{{ route('staff.index') }}" method="GET" class="dt-search">
                        <input type="hidden" name="station" value="{{ request('station') }}">
                        <i class="bx bx-search search-icon"></i>
                        <input type="text" name="search" class="form-control" placeholder="Cari NIP / Nama..." value="{{ request('search') }}">
                    </form>
                </div>

                {{-- Tabel --}}
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>NIP / ID</th>
                                <th>Jabatan</th>
                                <th>Station</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($staffs as $staff)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            @if($staff->profile_picture)
                                            <img src="{{ asset('storage/photo/'.$staff->profile_picture) }}" alt="Avatar" class="rounded-circle" style="object-fit: cover; width:100%; height:100%;">
                                            @else
                                            <img src="{{ asset('storage/photo/user.jpg') }}" alt="Avatar" class="rounded-circle">
                                            @endif
                                        </div>
                                        <strong>{{ $staff->fullname }}</strong>
                                    </div>
                                </td>
                                <td>{{ $staff->id }}</td>
                                <td><span class="badge bg-label-primary">{{ $staff->role }}</span></td>
                                <td>
                                    <span class="badge bg-label-info">{{ $staff->station }}</span>
                                </td>
                                <td>
                                    @if(Auth::user()->role == 'Admin')
                                    <form action="{{ route('staff.toggle', $staff->id) }}" method="POST">
                                        @csrf
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" onchange="this.form.submit()" style="cursor: pointer;" {{ $staff->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label ms-1">
                                                @if($staff->is_active)
                                                <span class="badge bg-label-success">ON</span>
                                                @else
                                                <span class="badge bg-label-danger">OFF</span>
                                                @endif
                                            </label>
                                        </div>
                                    </form>
                                    @else
                                    @if($staff->is_active)
                                    <span class="badge bg-label-success">Active</span>
                                    @else
                                    <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('users.userProfile', $staff->id) }}" class="action-btn" title="Detail">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        @if(Auth::user()->role == 'Admin')
                                        <button type="button" class="action-btn" onclick="openBanModal('{{ $staff->id }}', '{{ addslashes($staff->fullname) }}')" title="Blacklist" style="color:#dc2626; border-color:#fecaca;">
                                            <i class="bx bx-block"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="bx bx-user-x d-block"></i>
                                        <p>Belum ada data staff di station ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="dt-pagination-wrapper">
                    {{ $staffs->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL IMPORT STAFF --}}
@if(Auth::user()->role == 'Admin')
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Data Staff (Bulk)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('staff.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning text-small" style="font-size: 0.85rem;">
                        <i class="bx bx-info-circle me-1"></i>
                        Pastikan file CSV sesuai format. Password user baru otomatis: <b>password123</b>
                    </div>

                    <div class="mb-3 border-bottom pb-3">
                        <label class="form-label fw-bold">Langkah 1: Download Template</label>
                        <a href="{{ route('staff.template') }}" class="btn btn-outline-secondary w-100 btn-sm">
                            <i class="bx bx-download me-1"></i> Download Template CSV
                        </a>
                    </div>

                    <div class="mb-1">
                        <label class="form-label fw-bold">Langkah 2: Upload File CSV</label>
                        <input type="file" name="file" class="form-control" required accept=".csv, .xlsx">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="global-ban-form" action="{{ route('blacklist.store') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="user_id" id="swal-ban-user-id">
    <input type="hidden" name="reason" id="swal-ban-reason">
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openBanModal(id, name) {
        Swal.fire({
            icon: 'warning',
            title: 'Blacklist Staff',
            html: `
                <div style="background:#fef2f2; border-radius:0.75rem; padding:1rem 1.25rem; margin:0.5rem 0; text-align:left;">
                    <div style="margin-bottom:0.75rem; display:flex; align-items:flex-start; gap:0.75rem;">
                        <span style="flex-shrink:0; background:#fecaca; color:#dc2626; border-radius:999px; padding:0.15rem 0.65rem; font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; margin-top:2px;">Staff</span>
                        <span style="font-weight:600; color:#111827; font-size:0.9375rem;">${name}</span>
                    </div>
                </div>
                <p style="color:#dc2626; font-size:0.8125rem; margin-top:0.75rem; padding:0.5rem 0.75rem; background:#fff5f5; border-radius:0.5rem; border-left: 3px solid #dc2626; text-align: left;">
                    ⚠ Tindakan ini akan <strong>mematikan akun</strong> staff dan mencatat namanya ke dalam daftar hitam perusahaan selamanya.
                </p>
                <div style="text-align: left; margin-top: 1rem;">
                    <label style="font-size: 0.8125rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem; display: block;">Alasan Pelanggaran (Wajib)</label>
                    <textarea id="ban-reason-input" class="form-control" rows="3" placeholder="Contoh: Terbukti mencuri aset perusahaan pada tanggal..."></textarea>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '✕ Ya, Blacklist',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#e5e7eb',
            reverseButtons: true,
            focusCancel: true,
            preConfirm: () => {
                const reason = document.getElementById('ban-reason-input').value;
                if (!reason.trim()) {
                    Swal.showValidationMessage('Alasan pelanggaran wajib diisi');
                    return false;
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('swal-ban-user-id').value = id;
                document.getElementById('swal-ban-reason').value = result.value;
                document.getElementById('global-ban-form').submit();
            }
        });
    }
</script>
@endif

@endsection
