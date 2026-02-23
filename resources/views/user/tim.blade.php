@extends('layout.admin')

@section('title', 'Manajemen TIM Bandara')

@section('styles')
    <style>
        /* Menggunakan style yang sama agar konsisten */
        .nav-scroller { position: relative; z-index: 2; height: 2.75rem; overflow-y: hidden; margin-bottom: 1rem; }
        .nav-scroller .nav { display: flex; flex-wrap: nowrap; padding-bottom: 1rem; margin-top: -1px; overflow-x: auto; text-align: center; white-space: nowrap; -webkit-overflow-scrolling: touch; }
        .nav-tabs .nav-link { color: #697a8d; border: none; font-weight: 600; padding: 0.7rem 1.5rem; }
        .nav-tabs .nav-link.active { color: #696cff; border-bottom: 3px solid #696cff; background: transparent; }
        
        .row-critical { background-color: #ffe0db !important; } /* Merah Muda */
        .row-warning { background-color: #fff2cc !important; } /* Kuning Muda */
        
        .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 6px; background: #667eea; color: white; transition: all 0.2s ease; }
        .action-btn:hover { background: #5a6fd8; transform: translateY(-1px); color: white; }
    </style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Manajemen TIM Bandara</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">TIM (Tanda Izin Mengemudi)</li>
                </ol>
            </nav>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0 text-white"><i class="bx bx-car me-2"></i>Data TIM Karyawan</h5>
                <p class="mb-0 mt-1 small opacity-75">Monitoring Masa Berlaku TIM (Merah: < 30 Hari, Kuning: < 60 Hari)</p>
            </div>
            
            <div class="card-body pt-0">
                {{-- TAB FILTER STATION --}}
                <div class="border-bottom mb-3">
                    <div class="nav-scroller pt-2">
                        <div class="nav nav-tabs">
                            <a class="nav-link {{ request('station') == null ? 'active' : '' }}" href="{{ route('users.tim') }}">GLOBAL</a>
                            @foreach($stations as $st)
                            <a class="nav-link {{ request('station') == $st->code ? 'active' : '' }}" href="{{ route('users.tim', ['station' => $st->code]) }}">
                                {{ $st->code }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- TABEL DATA --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Staff</th>
                                <th>Nomor TIM</th>
                                <th>Station</th>
                                <th>Tanggal Expired</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                @php
                                    $end = \Carbon\Carbon::parse($user->tim_expired);
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
                                    <td>
                                        <strong>{{ $user->fullname }}</strong><br>
                                        <small class="text-muted">{{ $user->role }}</small>
                                    </td>
                                    <td>{{ $user->tim_number ?? '-' }}</td>
                                    <td><span class="badge bg-label-primary">{{ $user->station }}</span></td>
                                    <td class="fw-bold">{{ \Carbon\Carbon::parse($user->tim_expired)->format('d M Y') }}</td>
                                    <td>
                                        {!! $statusBadge !!}
                                        @if ($daysLeft >= 0 && $daysLeft <= 60)
                                            <div class="small fw-bold mt-1">{{ intval($daysLeft) }} Hari Lagi</div>
                                        @elseif($daysLeft < 0)
                                            <div class="small text-danger mt-1">Lewat</div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('users.TIMEdit', $user->id) }}" class="action-btn" title="Update TIM">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-4">Belum ada data TIM yang diinput.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-center">
                    {{ $users->appends(['station' => request('station')])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection