@extends('layout.admin')

@section('title', 'Laporan Absensi Karyawan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">

        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Laporan Absensi Karyawan</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Rekap data kehadiran karyawan berdasarkan periode dan station.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Attendance</a></li>
                    <li class="breadcrumb-item active">Laporan</li>
                </ol>
            </nav>
        </div>

        {{-- Card Utama --}}
        <div class="card">
            <div class="card-body">

                {{-- Toolbar: Filter + Export --}}
                <div class="dt-toolbar" style="align-items: flex-end;">
                    <form action="{{ route('attendance.reports') }}" method="GET" class="d-flex flex-wrap gap-3 align-items-end flex-grow-1" style="margin:0;">
                        <div>
                            <label class="form-label">Periode</label>
                            <input type="month" name="month" class="form-control" value="{{ request('month') ?: date('Y-m') }}" style="min-width: 160px;">
                        </div>
                        <div>
                            <label class="form-label">Station</label>
                            <select name="station_id" class="form-select" style="min-width: 180px;">
                                <option value="">Semua Station</option>
                                @foreach ($stations as $station)
                                <option value="{{ $station->code }}" {{ request('station_id') == $station->code ? 'selected' : '' }}>
                                    {{ $station->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="dt-search">
                            <i class="bx bx-search search-icon"></i>
                            <input type="text" name="user_name" class="form-control" placeholder="Cari NIP atau Nama..." value="{{ request('user_name') }}">
                        </div>
                        <button type="submit" class="btn btn-primary" style="height: 40px;">
                            <i class="bx bx-filter-alt me-1"></i>Filter
                        </button>
                    </form>
                    <a href="{{ route('attendance.export', request()->only(['month', 'station_id', 'user_name'])) }}" class="btn btn-success" style="height: 40px; display: inline-flex; align-items: center; white-space: nowrap;">
                        <i class="bx bx-download me-1"></i>Export Excel
                    </a>
                </div>

                {{-- Alert pesan --}}
                @if (!empty($message))
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert" style="border-radius: 0.5rem; border: 1px solid #fef3c7; background: #fffbeb; color: #92400e;">
                    <i class="bx bx-info-circle me-1"></i>{{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                {{-- NIP & Nama Info --}}
                @php
                $firstAttendance = $attendances->first();
                $user = $firstAttendance?->user;
                @endphp

                @if ($user)
                <div class="d-flex gap-4 py-3 px-1 mb-2" style="border-bottom: 1px solid #f3f4f6;">
                    <div><span class="text-muted" style="font-size:0.8125rem;">NIP:</span> <strong>{{ $user->id }}</strong></div>
                    <div><span class="text-muted" style="font-size:0.8125rem;">Nama:</span> <strong>{{ $user->fullname }}</strong></div>
                </div>
                @endif

                {{-- Tabel --}}
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th>Lokasi</th>
                                <th>Durasi Kerja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendances as $row)
                            @php
                            $attendance = $row->attendance ?? null;
                            $schedule = $row->schedule ?? null;
                            $date = \Carbon\Carbon::parse($row->date);
                            $today = \Carbon\Carbon::today();

                            $checkIn = $attendance?->check_in_time
                            ? \Carbon\Carbon::parse($attendance->check_in_time)
                            : null;
                            $checkOut = $attendance?->check_out_time
                            ? \Carbon\Carbon::parse($attendance->check_out_time)
                            : null;

                            $checkInClass = '';
                            $checkOutClass = '';
                            if ($date->lt($today)) {
                            if (!$checkIn || !$checkOut) {
                            $checkInClass = 'bg-danger text-white';
                            $checkOutClass = 'bg-danger text-white';
                            } elseif ($schedule) {
                            $schedStart = \Carbon\Carbon::parse($schedule->start_time);
                            $schedEnd = \Carbon\Carbon::parse($schedule->end_time);

                            if ($checkIn->gt($schedStart)) {
                            $checkInClass = 'bg-danger text-white';
                            } elseif ($checkIn->lt($schedStart)) {
                            $checkInClass = 'bg-success text-white';
                            }

                            if ($checkOut->lt($schedEnd)) {
                            $checkOutClass = 'bg-danger text-white';
                            } elseif ($checkOut->gt($schedEnd)) {
                            $checkOutClass = 'bg-success text-white';
                            }
                            }
                            }

                            $workDuration =
                            $checkIn && $checkOut ? $checkIn->diff($checkOut)->format('%H:%I:%S') : '-';
                            @endphp

                            <tr>
                                <td>{{ $date->translatedFormat('d M Y') }}</td>
                                <td class="{{ $checkInClass }}" style="border-radius: 0.25rem;">{{ $checkIn ? $checkIn->format('H:i:s') : '-' }}</td>
                                <td class="{{ $checkOutClass }}" style="border-radius: 0.25rem;">{{ $checkOut ? $checkOut->format('H:i:s') : '-' }}</td>
                                <td>{{ $checkIn ? $row->user?->station ?? ($attendance->check_in_notes ?? '-') : '-' }}</td>
                                <td>{{ $workDuration }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bx bx-calendar-x d-block"></i>
                                        <p>Tidak ada data absensi.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Keterangan Warna --}}
                <div class="d-flex flex-wrap gap-4 mt-4 pt-3" style="border-top: 1px solid #f3f4f6;">
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:12px;height:12px;background-color:#f0fdf4;border:1px solid #bbf7d0;border-radius:3px;"></span>
                        <small class="text-muted">Check-in lebih awal / Check-out lebih lama</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:12px;height:12px;background-color:#fef2f2;border:1px solid #fecaca;border-radius:3px;"></span>
                        <small class="text-muted">Terlambat / Pulang cepat / Tidak absen</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection