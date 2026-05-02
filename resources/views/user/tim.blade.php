@extends('layout.admin')

@section('title', 'Manajemen TIM Bandara')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Manajemen TIM Bandara</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Monitoring Masa Berlaku TIM (Merah: < 30 Hari, Kuning: < 60 Hari)</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">TIM (Tanda Izin Mengemudi)</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            {{-- Tab Station --}}
            <div class="card-header" style="padding-bottom:0 !important;">
                <div class="nav-scroller">
                    <div class="nav nav-tabs">
                        <a class="nav-link {{ request('station') == null ? 'active' : '' }}" href="{{ route('users.tim') }}">
                            <i class="fas fa-globe me-1"></i> Global
                        </a>
                        @foreach($stations as $st)
                        <a class="nav-link {{ request('station') == $st->code ? 'active' : '' }}" href="{{ route('users.tim', ['station' => $st->code]) }}">
                            {{ $st->code }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                {{-- Toolbar --}}
                <div class="dt-toolbar">
                    <form action="{{ route('users.tim') }}" method="GET" class="dt-search">
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
                                        $statusBadge = '<span class="badge bg-warning">Warning</span>';
                                    } else {
                                        $statusBadge = '<span class="badge bg-success">Active</span>';
                                    }
                                @endphp

                                <tr class="{{ $rowClass }}">
                                    <td>
                                        <strong>{{ $user->fullname }}</strong>
                                        <div class="small text-muted">NIP: {{ $user->id }}</div>
                                    </td>
                                    <td><code>{{ $user->tim_number ?? '-' }}</code></td>
                                    <td><span class="badge bg-label-primary">{{ $user->station }}</span></td>
                                    <td class="fw-bold">{{ $end->translatedFormat('d M Y') }}</td>
                                    <td>{!! $statusBadge !!}</td>
                                    <td class="text-center">
                                        <a href="{{ route('users.tim.edit', $user->id) }}" class="action-btn" title="Update TIM">
                                            <i class="bx bx-edit-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bx bx-id-card d-block"></i>
                                            <p>Tidak ada data TIM Bandara.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="dt-pagination-wrapper">
                    {{ $users->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection