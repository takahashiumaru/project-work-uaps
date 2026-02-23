@extends('layout.admin')

@section('title', 'Manajemen PAS Tahunan')

@section('styles')
    <style>
        /* --- STYLE ASLI + STYLE BARU GABUNGAN --- */
        .pagination-wrapper { display: flex; justify-content: center; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .pagination { display: flex; flex-wrap: wrap; gap: 4px; }
        .pagination .page-item { flex: 0 0 auto; }
        .pagination .page-link { min-width: 38px; text-align: center; }
        .table-responsive { border-radius: 0.75rem; overflow: hidden; overflow-x: auto; }
        .kontrak-table { width: 100%; table-layout: auto; }
        .kontrak-table th { background: #f8f9fa; font-weight: 600; color: #566a7f; padding: 1rem; border-bottom: 2px solid #e9ecef; }
        .kontrak-table td { padding: 1rem; vertical-align: middle; border-bottom: 1px solid #e9ecef; }
        .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 6px; background: #667eea; color: white; text-decoration: none; transition: all 0.2s ease; }
        .action-btn:hover { background: #5a6fd8; transform: translateY(-1px); color: white; }

        /* --- STYLE BARU --- */
        .nav-scroller { position: relative; z-index: 2; height: 2.75rem; overflow-y: hidden; margin-bottom: 1rem; }
        .nav-scroller .nav { display: flex; flex-wrap: nowrap; padding-bottom: 1rem; margin-top: -1px; overflow-x: auto; text-align: center; white-space: nowrap; -webkit-overflow-scrolling: touch; }
        .nav-scroller .nav::-webkit-scrollbar { height: 4px; }
        .nav-scroller .nav::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
        .nav-tabs .nav-link { color: #697a8d; border: none; font-weight: 600; padding: 0.7rem 1.5rem; }
        .nav-tabs .nav-link.active { color: #696cff; border-bottom: 3px solid #696cff; background: transparent; }

        .row-critical { background-color: #ffe0db !important; }
        .row-warning { background-color: #fff2cc !important; }
        
        @media (max-width: 768px) {
            .table-responsive { font-size: 0.875rem; }
            .kontrak-table th, .kontrak-table td { padding: 0.75rem 0.5rem; }
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="py-4">

            {{-- Header --}}
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
                    <p class="mb-0 mt-1 small opacity-75">Monitoring Validitas PAS (Merah: < 30 Hari, Kuning: < 60 Hari)</p>
                </div>
                
                <div class="card-body pt-0">
                    
                    {{-- TAB FILTER STATION (BARU) --}}
                    <div class="border-bottom mb-3">
                        <div class="nav-scroller pt-2">
                            <div class="nav nav-tabs">
                                <a class="nav-link {{ request('station') == null ? 'active' : '' }}" href="{{ route('users.pas') }}">
                                    <i class="fas fa-globe me-2"></i> GLOBAL
                                </a>
                                @foreach($stations as $st)
                                <a class="nav-link {{ request('station') == $st->code ? 'active' : '' }}" href="{{ route('users.pas', ['station' => $st->code]) }}">
                                    <i class="fas fa-plane-departure me-2"></i> {{ $st->code }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Form Pencarian --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('users.pas') }}" method="GET">
                                @if(request('station'))
                                    <input type="hidden" name="station" value="{{ request('station') }}">
                                @endif
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan NIP atau Nama" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-search me-1"></i>Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Tabel PAS --}}
                    <div class="table-responsive">
                        <table class="table kontrak-table">
                            <thead>
                                <tr>
                                    <th width="15%">NIP</th>
                                    <th width="20%">Nama Lengkap</th>
                                    <th width="10%">Station</th>
                                    <th width="15%">PAS Terdaftar</th>
                                    <th width="15%">PAS Habis</th>
                                    <th width="15%">Status</th>
                                    <th width="10%" class="text-center">Aksi</th>
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
                                            $statusBadge = '<span class="badge bg-warning text-dark">Warning</span>';
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
                                        <td colspan="7" class="text-center py-4">Tidak ada data PAS ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-2">
                        <div class="text-muted small text-center text-md-start">
                            Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} data
                        </div>
                        <nav class="pagination-container">
                            {{ $users->appends(['station' => request('station'), 'search' => request('search')])->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>

                    {{-- Legend --}}
                    <div class="card mt-4 bg-light border-0">
                        <div class="card-body p-3">
                            <small class="d-block mb-2 fw-bold text-uppercase text-muted">Legenda Warna:</small>
                            <div class="row small">
                                <div class="col-md-4 mb-2">
                                    <span class="badge bg-danger me-2">Merah</span> PAS < 30 Hari
                                </div>
                                <div class="col-md-4 mb-2">
                                    <span class="badge bg-warning text-dark me-2">Kuning</span> PAS < 60 Hari
                                </div>
                                <div class="col-md-4 mb-2">
                                    <span class="badge bg-success me-2">Hijau</span> PAS Aman
                                </div>
                            </div>
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