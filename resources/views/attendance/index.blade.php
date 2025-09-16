@extends('app')

@section('title', 'Modul Absensi')

@section('content')
<div class="container-fluid bg-light py-4" style="min-height: 100vh;">

    {{-- Card Presence Today --}}
    <div class="card shadow-sm border-0 rounded-3 w-100">
        <div class="card-header bg-white fw-semibold py-3 d-flex justify-content-between align-items-center">
            <span>Presence Today</span>

            {{-- Tombol ke History --}}
            <a href="{{ route('attendance.history') }}"
                class="btn btn-outline-secondary btn-sm rounded-pill shadow-sm">
                <i class="bi bi-clock-history"></i> History
            </a>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-borderless align-middle mb-0">
                <thead class="border-bottom">
                    <tr>
                        <th class="d-none d-sm-table-cell">Office</th>
                        <th>In</th>
                        <th class="d-none d-md-table-cell">Out</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="d-none d-sm-table-cell">
                            {{ $todayAttendance ? $user->station ?? '-' : '-' }}
                        </td>
                        <td>
                            {{ $todayAttendance && $todayAttendance->check_in_time
                                ? \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i')
                                : '-' }}
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $todayAttendance && $todayAttendance->check_out_time
                                ? \Carbon\Carbon::parse($todayAttendance->check_out_time)->format('H:i')
                                : '-' }}
                        </td>
                        <td class="text-end">
                            @if(!$todayAttendance)
                            {{-- Belum ada absen sama sekali --}}
                            <a href="{{ route('attendance.camera', ['type' => 'in']) }}"
                                class="btn btn-primary rounded-pill px-4 shadow-sm">
                                Check In
                            </a>
                            @elseif($todayAttendance && $todayAttendance->check_in_time && !$todayAttendance->check_out_time)
                            {{-- Sudah Check In, belum Check Out --}}
                            <a href="{{ route('attendance.camera', ['type' => 'out']) }}"
                                class="btn btn-danger rounded-pill px-4 shadow-sm">
                                Check Out
                            </a>
                            @elseif($todayAttendance && $todayAttendance->check_in_time && $todayAttendance->check_out_time)
                            {{-- Sudah Check In dan Check Out (selesai) --}}
                            <button class="btn btn-secondary rounded-pill px-4 shadow-sm" disabled>
                                Check Out
                            </button>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
