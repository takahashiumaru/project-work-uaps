@extends('app')

@section('title', 'Daftar Pengajuan Cuti')

@section('styles')
<style>
    /* ... (CSS Anda sudah bagus, tidak perlu diubah) ... */
    .status-badge {
        padding: .3em .6em;
        border-radius: .25rem;
        font-size: 85%;
        font-weight: bold;
        color: #fff;
        white-space: nowrap;
    }

    .status-approved {
        background-color: #28a745;
    }

    .status-rejected {
        background-color: #dc3545;
    }

    .status-pending {
        background-color: #ffc107;
        color: #212529;
    }

    .status-canceled {
        background-color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container" style="margin-top: 20px;">
    <div class="panel panel-default">
        <div class="panel-heading" style="display:flex; justify-content:space-between; align-items:center;">
            Daftar Pengajuan Izin & Cuti
            <a href="{{ route('leaves.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Ajukan Izin/Cuti</a>
        </div>
        <div class="panel-body">
            {{-- Bagian Data Personal --}}
            @if(!in_array(Auth::user()->role, ['PIC', 'HEAD_OFFICE', 'ADMIN', 'HRD']))
            <div class="personal-data-form">
                <div class="form-group"><label>NIP:</label><input type="text" value="{{ $user->id }}" disabled /></div>
                <div class="form-group"><label>Nama:</label><input type="text" value="{{ $user->fullname ?? 'N/A' }}" disabled /></div>
                <div class="form-group"><label>Sisa Cuti:</label><input type="text" value="{{ $leaveBalance ?? 0 }} hari" disabled /></div>
                <div class="form-group"><label>Cuti Terpakai:</label><input type="text" value="{{ $usedLeaveDays ?? 0 }} hari" disabled /></div>
            </div>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama Pengaju</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Total Hari</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leaves as $leave)
                    <tr>
                        <td>{{ $leave->user->fullname ?? 'N/A' }}</td>
                        <td>{{ $leave->leave_type }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                        <td>{{ $leave->total_days }}</td>
                        <td>
                            @php
                            $statusConfig = match($leave->status) {
                            'pending Apron' => ['class' => 'status-pending', 'text' => 'Menunggu'],
                            'pending Bge' => ['class' => 'status-pending', 'text' => 'Menunggu'],
                            'pending' => ['class' => 'status-pending', 'text' => 'Menunggu HO'],
                            'approved' => ['class' => 'status-approved', 'text' => 'Disetujui'],
                            'rejected_by_pic' => ['class' => 'status-rejected', 'text' => 'Ditolak PIC'],
                            'rejected_by_ho' => ['class' => 'status-rejected', 'text' => 'Ditolak HO'],
                            default => ['class' => 'status-canceled', 'text' => 'Dibatalkan'],
                            };
                            @endphp
                            <span class="status-badge {{ $statusConfig['class'] }}">{{ $statusConfig['text'] }}</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#leaveDetailModal{{ $leave->id }}">Detail</button>
                        </td>
                    </tr>
                    @include('leaves.partials.modal_detail', ['leave' => $leave, 'statusConfig' => $statusConfig])
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data pengajuan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="text-center">{{ $leaves->links() }}</div>
        </div>
    </div>
</div>
@endsection
