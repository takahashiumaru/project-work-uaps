@extends('layout.admin')

@section('title', 'Manajemen Kontrak Karyawan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">

        <x-page-header
            title="Manajemen Kontrak Karyawan"
            subtitle="Monitoring masa kontrak pegawai (Merah: < 30 Hari, Kuning: < 60 Hari)"
            :breadcrumbs="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'User Management'],
                ['label' => 'Kontrak'],
            ]"
        />

        {{-- Card Utama --}}
        <div class="card">
            {{-- Tab Station --}}
            <div class="card-header" style="padding-bottom:0 !important;">
                <div class="nav-scroller">
                    <div class="nav nav-tabs">
                        <a class="nav-link {{ request('station') == null ? 'active' : '' }}" href="{{ route('users.kontrak') }}">
                            <i class="fas fa-globe me-1"></i> Global
                        </a>
                        @foreach($stations as $st)
                        <a class="nav-link {{ request('station') == $st->code ? 'active' : '' }}" href="{{ route('users.kontrak', ['station' => $st->code]) }}">
                            {{ $st->code }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-body">
                {{-- Toolbar --}}
                <div class="dt-toolbar">
                    <form action="{{ route('users.kontrak') }}" method="GET" class="dt-search">
                        @if(request('station'))
                            <input type="hidden" name="station" value="{{ request('station') }}">
                        @endif
                        <i class="bx bx-search search-icon"></i>
                        <input type="text" name="search" class="form-control" placeholder="Cari NIP atau Nama..." value="{{ request('search') }}">
                    </form>
                </div>

                {{-- Tabel + Pagination --}}
                <x-data-table :paginator="$users" empty-icon="bx-calendar-x" empty-text="Tidak ada data ditemukan." :col-span="7">
                    <x-slot name="head">
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>Station</th>
                        <th>Kontrak Mulai</th>
                        <th>Kontrak Berakhir</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </x-slot>

                    @foreach ($users as $user)
                        @php
                            $end = \Carbon\Carbon::parse($user->contract_end);
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
                                <div class="small text-muted">{{ $user->role }}</div>
                            </td>
                            <td><span class="badge bg-label-primary">{{ $user->station }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($user->contract_start)->translatedFormat('d M Y') }}</td>
                            <td class="fw-bold">{{ \Carbon\Carbon::parse($user->contract_end)->translatedFormat('d M Y') }}</td>
                            <td>
                                {!! $statusBadge !!}
                                @if ($daysLeft >= 0 && $daysLeft <= 60)
                                    <small class="d-block text-muted mt-1 fw-bold">{{ intval($daysLeft) }} Hari Lagi</small>
                                @elseif($daysLeft < 0)
                                    <small class="d-block text-danger mt-1">Lewat {{ abs(intval($daysLeft)) }} hari</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('users.KontrakEdit', ['id' => $user->id, 'page' => request('page')]) }}" 
                                   class="action-btn" title="Edit Kontrak">
                                    <i class="bx bx-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-data-table>

                {{-- Legend --}}
                <div class="d-flex flex-wrap gap-4 mt-3 pt-3" style="border-top: 1px solid #f3f4f6;">
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:12px;height:12px;background-color:#fef2f2;border:1px solid #fecaca;border-radius:3px;"></span>
                        <small class="text-muted">Sisa &lt; 30 Hari</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:12px;height:12px;background-color:#fffbeb;border:1px solid #fef3c7;border-radius:3px;"></span>
                        <small class="text-muted">Sisa &lt; 60 Hari</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:12px;height:12px;background-color:#ffffff;border:1px solid #e5e7eb;border-radius:3px;"></span>
                        <small class="text-muted">Aman (&gt; 60 Hari)</small>
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