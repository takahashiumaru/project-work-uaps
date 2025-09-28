@extends('layout.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Laporan /</span> Laporan Cuti Karyawan
</h4>

<div class="card mb-4" style="max-width: 100%;">
    <div class="card-header text-center">
        <h5 class="mb-0">LAPORAN CUTI KARYAWAN</h5>
    </div>
    <div class="card-body">

        <form action="{{ route('leaves.laporan') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="year" class="form-label">Tahun:</label>
                        <input type="number" name="year" id="year" class="form-control"
                            value="{{ request('year', date('Y')) }}">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Cari NIP / Nama:</label>
                        <input type="text" name="user_name" id="user_name" class="form-control"
                            placeholder="Cari NIP atau Nama Karyawan"
                            value="{{ request('user_name') }}">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-filter me-1"></i> Filter
                    </button>

                    <a href="{{ route('leaves.laporan') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-reset me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama Karyawan</th>
                        <th>Jenis Cuti</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Total Hari</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>User Approve</th>
                        <th>Tanggal Approve</th>
                        <th>User Reject</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leaves as $leave)
                    <tr>
                        <td>{{ $leave->user->nip ?? '-' }}</td>
                        <td>{{ $leave->user->fullname ?? '-' }}</td>
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
                        <td colspan="11" class="text-center">
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
        
        <div class="text-end mt-4">
            <a href="{{ route('leaves.export', request()->only(['month','user_name'])) }}" class="btn btn-success">
                <i class="bx bx-export me-1"></i> Export ke Excel
            </a>
        </div>
    </div>
</div>
@endsection