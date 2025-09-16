@extends('app')

@section('title', 'Laporan Cuti Karyawan')

@section('content')
<div class="main-content-reports">
    <div class="center-wrapper">
        <div class="panel panel-default" style="width: 90%; max-width: 1200px; margin: auto;">
            <div class="panel-heading text-center">
                <h3 class="panel-title">LAPORAN CUTI KARYAWAN</h3>
            </div>
            <div class="panel-body">

                {{-- Form Filter --}}
                <form action="{{ route('leaves.laporan') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="year">Tahun:</label>
                                <input type="number" name="year" id="year" class="form-control"
                                    value="{{ request('year', date('Y')) }}">
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

                {{-- Info User --}}
                @if($user)
                <div class="mb-3">
                    <div><strong>NIP:</strong> {{ $user->id }}</div>
                    <div><strong>Nama:</strong> {{ $user->fullname }}</div>
                    <div><strong>Station:</strong> {{ $user->station }}</div>
                    <div>
                        <strong>Sisa Cuti:</strong> {{ $leaveBalance }} hari |
                        <strong>Sudah Digunakan:</strong> {{ $usedLeaveDays }} hari
                    </div>
                </div>
                @endif

                {{-- Tabel Cuti --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>Jenis Cuti</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Total Hari</th>
                                <th>Status</th>
                                <th>Alasan / Keterangan</th>
                                <th>Disetujui Oleh</th>
                                <th>Tanggal Disetujui</th>
                                <th>Ditolak Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leaves as $leave)
                            @php
                            $rowClass = '';
                            if($leave->status == 'approved') $rowClass = 'table-success';
                            elseif(str_contains($leave->status, 'rejected')) $rowClass = 'table-danger';
                            elseif($leave->status == 'pending') $rowClass = 'table-warning';
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td>{{ $leave->leave_type }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                                <td>{{ $leave->total_days }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $leave->status)) }}</td>
                                <td>{{ $leave->reason ?? '-' }}</td>
                                <td>{{ $leave->user_approve ?? '-' }}</td>
                                <td>{{ $leave->approved_at ? \Carbon\Carbon::parse($leave->approved_at)->format('d M Y H:i') : '-' }}</td>
                                <td>{{ $leave->user_rejected ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    @if(empty(request()->query()))
                                    Silakan pilih filter lalu klik <b>Filter</b>.
                                    @else
                                    Tidak ada data cuti.
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-right mt-4">
                    <a href="{{ route('leaves.export', request()->only(['month','user_name'])) }}" class="btn btn-success">
                        Export ke Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
