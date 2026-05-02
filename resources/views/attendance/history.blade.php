@extends('layout.admin')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">

        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Presence Report ({{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }})</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Detail riwayat absensi harian karyawan.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Attendance</a></li>
                    <li class="breadcrumb-item active">History</li>
                </ol>
            </nav>
        </div>

        {{-- Back --}}
        <div class="mb-3">
            <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Back
            </a>
        </div>

        {{-- Card --}}
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0" style="color: #374151; font-weight: 600;">Attendance History</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table text-center">
                        <thead style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th>Date</th>
                                <th>Office</th>
                                <th>Shift</th>
                                <th>In</th>
                                <th>Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daysInMonth as $day => $data)
                            @php
                            $attendance = $data['attendance'];
                            $schedule = $data['schedule'];

                            $startTime = $schedule ? \Carbon\Carbon::parse($schedule->start_time) : null;
                            $endTime = $schedule ? \Carbon\Carbon::parse($schedule->end_time) : null;

                            $checkIn = $attendance && $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time) : null;
                            $checkOut = $attendance && $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time) : null;

                            $isShiftKosong = $startTime && $startTime->format('H:i') === '00:00' && $endTime && $endTime->format('H:i') === '00:00';

                            $currentDate = \Carbon\Carbon::parse($month)->day($day);
                            $today = now()->startOfDay();
                            $isFuture = $currentDate->gt($today);
                            @endphp
                            <tr>
                                <td>{{ $day }}</td>
                                <td>{{ $attendance && $attendance->check_in_time ? $user->station ?? '-' : '-' }}</td>
                                <td>
                                    @if($schedule)
                                    {{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}
                                    @else
                                    -
                                    @endif
                                </td>

                                {{-- Kolom In --}}
                                <td class="
                                    @if(!$isFuture && !$isShiftKosong)
                                        @if(!$checkIn || !($checkIn instanceof \DateTimeInterface))
                                            bg-danger text-white
                                        @elseif($checkIn instanceof \DateTimeInterface && $startTime instanceof \DateTimeInterface && $checkIn->gt(new \DateTime($startTime->format('Y-m-d H:i:s'))))
                                            bg-danger text-white
                                        @elseif($checkIn instanceof \DateTimeInterface && $startTime instanceof \DateTimeInterface && $checkIn->lte(new \DateTime($startTime->format('Y-m-d H:i:s'))))
                                            bg-success text-white
                                        @endif
                                    @endif
                                " style="border-radius: 0.25rem;">
                                    {{ $checkIn instanceof \DateTimeInterface ? $checkIn->format('H:i') : ($checkIn ? (string) $checkIn : '-') }}
                                </td>

                                {{-- Kolom Out --}}
                                <td class="
                                    @if(!$isFuture && !$isShiftKosong)
                                        @if(!$checkOut || !($checkOut instanceof \DateTimeInterface))
                                            bg-danger text-white
                                        @elseif($checkOut instanceof \DateTimeInterface && $startTime instanceof \DateTimeInterface && $checkOut->gt(new \DateTime($startTime->format('Y-m-d H:i:s'))))
                                            bg-danger text-white
                                        @elseif($checkOut instanceof \DateTimeInterface && $startTime instanceof \DateTimeInterface && $checkOut->lte(new \DateTime($startTime->format('Y-m-d H:i:s'))))
                                            bg-success text-white
                                        @endif
                                    @endif
                                " style="border-radius: 0.25rem;">
                                    {{ $checkIn instanceof \DateTimeInterface ? $checkOut->format('H:i') : ($checkOut ? (string) $checkOut : '-') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Keterangan --}}
        <div class="d-flex flex-wrap gap-4 mt-4">
            <div class="d-flex align-items-center gap-2">
                <span style="display:inline-block;width:12px;height:12px;background-color:#f0fdf4;border:1px solid #bbf7d0;border-radius:3px;"></span>
                <small class="text-muted">On Time</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span style="display:inline-block;width:12px;height:12px;background-color:#fef2f2;border:1px solid #fecaca;border-radius:3px;"></span>
                <small class="text-muted">Terlambat / Pulang Cepat / Tidak Absen</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span style="display:inline-block;width:12px;height:12px;background-color:#ffffff;border:1px solid #e5e7eb;border-radius:3px;"></span>
                <small class="text-muted">Hari yang akan datang</small>
            </div>
        </div>
    </div>
</div>
@endsection