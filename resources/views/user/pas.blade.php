@extends('layout.admin')

@section('title', 'Manajemen PAS Tahunan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="py-4">

            {{-- Header --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Manajemen PAS Tahunan</h4>
                    <p class="text-muted mb-0" style="font-size:0.875rem;">Data PAS (Izin Masuk Area Terbatas) — Monitoring Validitas PAS (Merah: &lt; 30 Hari, Kuning: &lt; 60 Hari)</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                        <li class="breadcrumb-item active">PAS Tahunan</li>
                    </ol>
                </nav>
            </div>

            {{-- Card Utama --}}
            <div class="card">
                {{-- Tab Station --}}
                <div class="card-header" style="padding-bottom:0 !important;">
                    <div class="nav-scroller">
                        <div class="nav nav-tabs">
                            <a class="nav-link {{ request('station') == null ? 'active' : '' }}" href="{{ route('users.pas') }}">
                                <i class="fas fa-globe me-1"></i> Global
                            </a>
                            @foreach($stations as $st)
                            <a class="nav-link {{ request('station') == $st->code ? 'active' : '' }}" href="{{ route('users.pas', ['station' => $st->code]) }}">
                                {{ $st->code }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Toolbar --}}
                    <div class="dt-toolbar">
                        <form action="{{ route('users.pas') }}" method="GET" class="dt-search">
                            @if(request('station'))
                                <input type="hidden" name="station" value="{{ request('station') }}">
                            @endif
                            <i class="bx bx-search search-icon"></i>
                            <input type="text" name="search" class="form-control" placeholder="Cari NIP atau Nama..." value="{{ request('search') }}">
                        </form>
                    </div>

                    {{-- Tabel --}}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama Lengkap</th>
                                    <th>Station</th>
                                    <th>PAS Terdaftar</th>
                                    <th>PAS Habis</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    @php
                                        $end = \Carbon\Carbon::parse($user->pas_expired);
                                        $now = \Carbon\Carbon::now();
                                        $daysLeft = $now->diffInDays($end, false);

                                        $rowClass = '';
                                        $statusBadge = '';

                                        if ($daysLeft < 0) {
                                            $rowClass = 'row-critical';
                                            $statusBadge = '<span class="badge bg-dark">Expired</span>';
                                        } elseif ($daysLeft <= 30) {
                                            $rowClass = 'row-critical';
                                            $statusBadge = '<span class="badge bg-danger">Critical</span>';
                                        } elseif ($daysLeft <= 60) {
                                            $rowClass = 'row-warning';
                                            $statusBadge = '<span class="badge bg-warning">Warning</span>';
                                        } else {
                                            $statusBadge = '<span class="badge bg-success">Active</span>';
                                        }
                                    @endphp
                                    <tr class="{{ $rowClass }}">
                                        <td><strong>{{ $user->id }}</strong></td>
                                        <td>
                                            {{ $user->fullname }}
                                            @if($user->no_pas)
                                                <div class="small text-muted">No: {{ $user->no_pas }}</div>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-label-primary">{{ $user->station }}</span></td>
                                        <td>{{ \Carbon\Carbon::parse($user->pas_registered)->translatedFormat('d M Y') }}</td>
                                        <td class="fw-bold">{{ \Carbon\Carbon::parse($user->pas_expired)->translatedFormat('d M Y') }}</td>
                                        <td>
                                            {!! $statusBadge !!}
                                            @if ($daysLeft >= 0 && $daysLeft <= 60)
                                                <small class="d-block text-muted mt-1 fw-bold">{{ intval($daysLeft) }} Hari</small>
                                            @elseif($daysLeft < 0)
                                                <small class="d-block text-danger mt-1">Lewat</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('users.PASEdit', $user->id) }}" class="action-btn" title="Edit Pas">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <i class="bx bx-id-card d-block"></i>
                                                <p>Tidak ada data PAS ditemukan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="dt-pagination-wrapper">
                        {{ $users->links('vendor.pagination.custom') }}
                    </div>

                    {{-- Legend --}}
                    <div class="d-flex flex-wrap gap-4 mt-3 pt-3" style="border-top: 1px solid #f3f4f6;">
                        <div class="d-flex align-items-center gap-2">
                            <span style="display:inline-block;width:12px;height:12px;background-color:#fef2f2;border:1px solid #fecaca;border-radius:3px;"></span>
                            <small class="text-muted">PAS &lt; 30 Hari</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="display:inline-block;width:12px;height:12px;background-color:#fffbeb;border:1px solid #fef3c7;border-radius:3px;"></span>
                            <small class="text-muted">PAS &lt; 60 Hari</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="display:inline-block;width:12px;height:12px;background-color:#ffffff;border:1px solid #e5e7eb;border-radius:3px;"></span>
                            <small class="text-muted">PAS Aman</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
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