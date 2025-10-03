@extends('layout.admin')

@section('title', 'Laporan Absensi Karyawan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="py-4">

            {{-- Header dengan Breadcrumb --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Laporan Absensi Karyawan</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Attendance</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
                    </ol>
                </nav>
            </div>

            {{-- Card Utama --}}
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="card-title mb-0" style="color: white">Laporan Absensi Karyawan</h5>
                </div>
                <div class="card-body">

                    {{-- Form Filter --}}
                    <form action="{{ route('attendance.reports') }}" method="GET" class="mb-4">
                        <div class="row g-3 p-3 align-items-end">
                            <div class="col-md-3">
                                <label for="month" class="form-label">Periode (Bulan/Tahun):</label>
                                <input type="month" name="month" id="month" class="form-control"
                                    value="{{ request('month') }}">
                            </div>
                            <div class="col-md-5">
                                <label for="user_name" class="form-label">Cari NIP / Nama:</label>
                                <input type="text" name="user_name" id="user_name" class="form-control"
                                    placeholder="Cari NIP atau Nama Karyawan" value="{{ request('user_name') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-filter me-2"></i>Filter
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('attendance.export', request()->only(['month', 'user_name'])) }}"
                                    class="btn btn-success w-100">
                                    <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                                </a>
                            </div>
                        </div>
                    </form>

                    {{-- Alert pesan --}}
                    @if (!empty($message))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Legend NIP & Nama --}}
                    @php
                        $firstAttendance = $attendances->first();
                        $user = $firstAttendance?->user;
                    @endphp

                    @if ($user)
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>NIP :</strong> {{ $user->id }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Nama :</strong> {{ $user->fullname }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Tabel Absensi --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover kontrak-table">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                    <th>Shift</th>
                                    <th>Check-in</th>
                                    <th>Status</th>
                                    <th>Lokasi</th>
                                    <th>Check-out</th>
                                    <th>Durasi Kerja</th>
                                    <th>Catatan</th>
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

                                        $shiftLabel = $schedule
                                            ? $schedule->shift_description .
                                                ' (' .
                                                $schedule->start_time .
                                                '-' .
                                                $schedule->end_time .
                                                ')'
                                            : 'Libur';

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
                                        <td>{{ $shiftLabel }}</td>
                                        <td class="{{ $checkInClass }}">{{ $checkIn ? $checkIn->format('H:i:s') : '-' }}
                                        </td>
                                        <td>{{ $attendance?->status ?? '-' }}</td>
                                        <td>{{ $checkIn ? $row->user?->station ?? ($attendance->check_in_notes ?? '-') : '-' }}
                                        </td>
                                        <td class="{{ $checkOutClass }}">
                                            {{ $checkOut ? $checkOut->format('H:i:s') : '-' }}</td>
                                        <td>{{ $workDuration }}</td>
                                        <td>{{ $attendance?->notes ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">Tidak ada data absensi.</td>
                                    </tr>
                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Keterangan Warna --}}
                    <div class="card mt-4">
                        <div class="card-body">
                            <small class="d-block mb-2 fw-semibold">Keterangan Warna:</small>
                            <div class="row small">
                                <div class="col-md-6">
                                    <span class="badge bg-success me-2">●</span> Hijau = Check-in lebih awal / Check-out
                                    lebih lama
                                </div>
                                <div class="col-md-6">
                                    <span class="badge bg-danger me-2">●</span> Merah = Terlambat / Pulang cepat / Tidak
                                    absen
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .table td,
        .table th {
            vertical-align: middle;
            font-size: 0.875rem;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 0.375rem;
        }

        .card-header.bg-primary {
            border-radius: 0.375rem 0.375rem 0 0 !important;
        }
        .table-responsive {
            border-radius: 0.75rem;
            overflow: hidden;
            overflow-x: auto;
        }

        .kontrak-table {
            width: 100%;
            table-layout: auto;
        }

        .kontrak-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #566a7f;
            padding: 1rem;
            border-bottom: 2px solid #e9ecef;
        }

        .kontrak-table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .kontrak-table tr:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection
