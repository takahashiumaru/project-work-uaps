@extends('layout.admin')

@section('styles')
<style>
    /* CSS Khusus untuk Horizontal Scrollable Tabs */
    .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
    }

    .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    /* Hilangkan scrollbar jelek */
    .nav-scroller .nav::-webkit-scrollbar {
        height: 4px;
    }

    .nav-scroller .nav::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .nav-scroller .nav::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    /* Style Tab */
    .nav-tabs .nav-link {
        color: #697a8d;
        border: none;
        font-weight: 600;
        padding: 0.7rem 1.5rem;
    }

    .nav-tabs .nav-link:hover {
        color: #5f61e6;
        background: #f5f5f9;
    }

    .nav-tabs .nav-link.active {
        color: #696cff;
        border-bottom: 3px solid #696cff;
        background: transparent;
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Monitoring /</span> Data Staff Global
        </h4>

        {{-- BAGIAN TOMBOL ACTION (Admin Only) --}}
        @if(Auth::user()->role == 'Admin')
        <div class="d-flex gap-2">
            <a href="{{ route('staff.export', ['station' => request('station')]) }}" class="btn btn-sm btn-outline-success">
                <i class="fas fa-file-csv me-1"></i> Export CSV
            </a>

            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-upload me-1"></i> Import Staff
            </button>

            <a href="{{ route('stations.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Station Baru
            </a>
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-success">
                <i class="fas fa-plus-circle me-1"></i> Tambah Staff
            </a>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="card-header border-bottom p-0">
            <div class="nav-scroller px-3 pt-2">
                <div class="nav nav-tabs">

                    <a class="nav-link {{ request('station') == null ? 'active' : '' }}"
                        href="{{ route('staff.index') }}">
                        <i class="fas fa-globe me-2"></i> GLOBAL
                    </a>

                    @foreach($stations as $st)
                    <a class="nav-link {{ request('station') == $st->code ? 'active' : '' }}"
                        href="{{ route('staff.index', ['station' => $st->code]) }}">
                        <i class="fas fa-plane-departure me-2"></i> {{ $st->code }}
                    </a>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="card-body pt-4">

            @if(request('station'))
            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <div>
                    Menampilkan data staff khusus area: <strong>{{ request('station') }}</strong>
                </div>
            </div>
            @endif

            <div class="text-right">
                <form action="{{ route('staff.index') }}" method="GET" class="form-inline" style="margin-top: 10px;">
                    <input type="hidden" name="station" value="{{ request('station') }}">

                    <div class="input-group">
                        <input type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari NIP / Nama"
                            value="{{ request('search') }}">

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
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
                    <tbody class="table-border-bottom-0">
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
                                @if($staff->station == 'CGK')
                                <span class="badge bg-info">CGK</span>
                                @elseif($staff->station == 'SUB')
                                <span class="badge bg-success">SUB</span>
                                @else
                                <span class="badge bg-secondary">{{ $staff->station }}</span>
                                @endif
                            </td>
                            <td>
                                {{-- Form Toggle Switch User --}}
                                @if(Auth::user()->role == 'Admin')
                                <form action="{{ route('staff.toggle', $staff->id) }}" method="POST">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox"
                                            onchange="this.form.submit()"
                                            style="cursor: pointer;"
                                            {{ $staff->is_active ? 'checked' : '' }}>

                                        <label class="form-check-label text-small ms-1">
                                            @if($staff->is_active)
                                            <span class="badge bg-label-success">ON</span>
                                            @else
                                            <span class="badge bg-label-danger">OFF</span>
                                            @endif
                                        </label>
                                    </div>
                                </form>
                                @else
                                {{-- Jika bukan admin, cuma bisa lihat status --}}
                                @if($staff->is_active)
                                <span class="badge bg-label-success">Active</span>
                                @else
                                <span class="badge bg-label-danger">Inactive</span>
                                @endif
                                @endif
                            </td>
                            <td>
                                {{-- Detail --}}
                                <a href="{{ route('users.profile', $staff->id) }}"
                                    class="btn btn-sm btn-icon btn-outline-secondary"
                                    title="Detail">
                                    <i class="bx bx-show"></i>
                                </a>

                                {{-- Blacklist (Admin Only) --}}
                                @if(Auth::user()->role == 'Admin')
                                <button type="button"
                                    class="btn btn-sm btn-icon btn-outline-danger"
                                    onclick="openBanModal('{{ $staff->id }}', '{{ $staff->fullname }}')"
                                    title="Blacklist Staff">
                                    <i class="bx bx-block"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" alt="No Data" width="150" style="opacity: 0.5">
                                <p class="mt-3 text-muted">Belum ada data staff di station ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $staffs->appends(['station' => request('station')])->links() }}
            </div>
        </div>
    </div>
</div>

{{-- MODAL IMPORT STAFF (TAMBAHAN BARU) --}}
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
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="banModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">
                    <i class="bx bx-error-alt me-2"></i> Blacklist Staff (PHK & Ban)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('blacklist.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        Tindakan ini akan <b>mematikan akun</b> staff dan mencatat namanya ke dalam daftar hitam perusahaan selamanya.
                    </div>

                    <input type="hidden" name="user_id" id="ban_user_id">

                    <div class="mb-3">
                        <label class="form-label">Nama Staff</label>
                        <input type="text" class="form-control" id="ban_user_name" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alasan Pelanggaran (Wajib Diisi)</label>
                        <textarea name="reason" class="form-control" rows="3" required placeholder="Contoh: Terbukti mencuri aset perusahaan pada tanggal..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Konfirmasi Blacklist</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openBanModal(id, name) {
        document.getElementById('ban_user_id').value = id;
        document.getElementById('ban_user_name').value = name;
        var myModal = new bootstrap.Modal(document.getElementById('banModal'));
        myModal.show();
    }
</script>
@endif

@endsection
