@extends('layout.admin')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">

        {{-- Header dengan Breadcrumb --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Presence Report ({{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }})</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Attendance</a></li>
                    <li class="breadcrumb-item active">History</li>
                </ol>
            </nav>
        </div>

        {{-- Tombol Back --}}
        <div class="mb-3">
            <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill shadow-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        {{-- Card Tabel --}}
        <div class="card shadow-sm rounded-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Attendance History</h5>
            </div>
            <div class="card-body p-0">

                {{-- Scrollable Table --}}
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-bordered align-middle text-center mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th style="width: 10%">Date</th>
                                <th style="width: 30%">Office</th>
                                <th style="width: 30%">Shift</th>
                                <th style="width: 20%">In</th>
                                <th style="width: 20%">Out</th>
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

                            // tanggal yg sedang di-loop
                            $currentDate = \Carbon\Carbon::parse($month)->day($day);
                            $today = now()->startOfDay();
                            $isFuture = $currentDate->gt($today); // cek apakah hari depan
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
                                        @if(!$checkIn) bg-danger text-white
                                        @elseif($checkIn->gt($startTime)) bg-danger text-white
                                        @elseif($checkIn->lte($startTime)) bg-success text-white
                                        @endif
                                    @endif
                                ">
                                    {{ $checkIn ? $checkIn->format('H:i') : '-' }}
                                </td>

                                {{-- Kolom Out --}}
                                <td class="
                                    @if(!$isFuture && !$isShiftKosong)
                                        @if(!$checkOut) bg-danger text-white
                                        @elseif($checkOut->lt($endTime)) bg-danger text-white
                                        @elseif($checkOut->gte($endTime)) bg-success text-white
                                        @endif
                                    @endif
                                ">
                                    {{ $checkOut ? $checkOut->format('H:i') : '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Keterangan --}}
        <div class="card mt-4">
            <div class="card-body">
                <small class="d-block mb-1 fw-semibold">Keterangan:</small>
                <ul class="mb-0 small list-unstyled">
                    <li>
                        <span style="display:inline-block;width:15px;height:15px;background-color:#d4edda;border:1px solid #c3e6cb;margin-right:6px;"></span>
                        Hijau = On Time (Check-in ≤ jam mulai, atau Check-out ≥ jam selesai)
                    </li>
                    <li>
                        <span style="display:inline-block;width:15px;height:15px;background-color:#f8d7da;border:1px solid #f5c6cb;margin-right:6px;"></span>
                        Merah = Terlambat Masuk / Pulang Cepat / Tidak Absen
                    </li>
                    <li>
                        <span style="display:inline-block;width:15px;height:15px;background-color:#e9ecef;border:1px solid #dee2e6;margin-right:6px;"></span>
                        Abu-abu = Shift Kosong (00:00 - 00:00)
                    </li>
                    <li>
                        <span style="display:inline-block;width:15px;height:15px;background-color:#ffffff;border:1px solid #dee2e6;margin-right:6px;"></span>
                        Putih = Hari yang akan datang (belum divalidasi)
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<style>
    .table td, .table th {
        vertical-align: middle;
    }
    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 10;
    }
</style>
@endsection