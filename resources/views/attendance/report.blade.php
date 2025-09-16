@extends('app')

@section('title', 'Laporan Absensi Karyawan')

@section('content')
<div class="main-content-reports">
    <div class="center-wrapper">
        <div class="panel panel-default" style="width: 90%; max-width: 1200px; margin: auto;">
            <div class="panel-heading text-center">
                <h3 class="panel-title">LAPORAN ABSENSI KARYAWAN</h3>
            </div>
            <div class="panel-body">

                {{-- Form Filter --}}
                <form action="{{ route('attendance.reports') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="month">Periode (Bulan/Tahun):</label>
                                <input type="month" name="month" id="month" class="form-control"
                                    value="{{ request('month') }}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="user_name">Cari NIP / Nama:</label>
                                <input type="text" name="user_name" id="user_name" class="form-control"
                                    placeholder="Cari NIP atau Nama Karyawan"
                                    value="{{ request('user_name') }}">
                            </div>
                        </div>
                        <div class="col-md-2" style="padding-top: 25px;">
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
                        </div>
                    </div>
                </form>

                {{-- Alert pesan --}}
                @if(!empty($message))
                <div class="alert alert-warning">{{ $message }}</div>
                @endif

                {{-- Legend NIP & Nama --}}
                @php
                $firstAttendance = $attendances->first();
                $user = $firstAttendance?->user;
                @endphp

                @if($user)
                <div class="mb-3">
                    <div><strong>NIP :</strong> {{ $user->id }}</div>
                    <div><strong>Nama :</strong> {{ $user->fullname }}</div>
                </div>
                @endif

                {{-- Tabel Absensi --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="text-center">
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
                            $attendance = $row['attendance'] ?? null;
                            $schedule = $row['schedule'] ?? null;
                            $date = \Carbon\Carbon::parse($row['date']);
                            $today = \Carbon\Carbon::today();

                            $checkIn = $attendance?->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time) : null;
                            $checkOut = $attendance?->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time) : null;

                            $checkInClass = '';
                            $checkOutClass = '';

                            // Waktu shift default libur jika tidak ada schedule
                            $shiftLabel = $schedule
                                ? $schedule->shift_description . ' (' . $schedule->start_time . '-' . $schedule->end_time . ')'
                                : 'Libur';

                            // Logika warna untuk check-in/out
                            if ($date->lt($today)) {
                                if (!$checkIn || !$checkOut) {
                                    // Tidak ada absen
                                    $checkInClass = 'bg-danger text-white';
                                    $checkOutClass = 'bg-danger text-white';
                                } elseif ($schedule) {
                                    $schedStart = \Carbon\Carbon::parse($schedule->start_time);
                                    $schedEnd = \Carbon\Carbon::parse($schedule->end_time);

                                    if ($checkIn->gt($schedStart)) {
                                        $checkInClass = 'bg-danger text-white'; // terlambat
                                    } elseif ($checkIn->lt($schedStart)) {
                                        $checkInClass = 'bg-success text-white'; // lebih awal
                                    }

                                    if ($checkOut->lt($schedEnd)) {
                                        $checkOutClass = 'bg-danger text-white'; // pulang cepat
                                    } elseif ($checkOut->gt($schedEnd)) {
                                        $checkOutClass = 'bg-success text-white'; // pulang lebih lama
                                    }
                                }
                            }

                            $workDuration = ($checkIn && $checkOut) ? $checkIn->diff($checkOut)->format('%H:%I:%S') : '-';
                            @endphp

                            <tr>
                                <td>{{ $date->translatedFormat('d M Y') }}</td>
                                <td>{{ $shiftLabel }}</td>
                                <td class="{{ $checkInClass }}">{{ $checkIn ? $checkIn->format('H:i:s') : '-' }}</td>
                                <td>{{ $attendance?->status ?? '-' }}</td>
                                <td>{{ $checkIn ? ($user->station ?? $attendance->check_in_notes ?? '-') : '-' }}</td>
                                <td class="{{ $checkOutClass }}">{{ $checkOut ? $checkOut->format('H:i:s') : '-' }}</td>
                                <td>{{ $workDuration }}</td>
                                <td>{{ $attendance?->notes ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    @if(empty(request()->query()))
                                    Silakan pilih Periode (Bulan/Tahun) dan NIP/Nama lalu klik <b>Filter</b>.
                                    @else
                                    Tidak ada data absensi.
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="text-right mt-4">
                    <a href="{{ route('attendance.export', request()->only(['month','user_name'])) }}" class="btn btn-success">
                        Export ke Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
