@extends('layout.admin')

@section('styles')
<style>
    /* Style Badge Status dipindahkan ke sini */
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
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Apply Leave /</span> Pengajuan Leave
</h4>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pengajuan Izin & Cuti</h5>
        {{-- Route 'leaves.create' tetap dipertahankan --}}
        <a href="{{ route('leaves.create') }}" class="btn btn-primary btn-sm">
            <i class="bx bx-plus-circle me-1"></i> Ajukan Izin/Cuti
        </a>
    </div>

    <div class="card-body">
        {{-- Bagian Data Personal --}}
        @if (!in_array(Auth::user()->role, ['PIC', 'HEAD_OFFICE', 'ADMIN', 'HRD']))
        <div class="row mb-4">
            {{-- Mengubah struktur form-group lama menjadi grid Bootstrap 5 --}}
            <div class="col-lg-3 col-md-6 mb-3">
                <label class="form-label fw-bold">NIP:</label>
                <input type="text" class="form-control" value="{{ $user->id }}" disabled />
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <label class="form-label fw-bold">Nama:</label>
                <input type="text" class="form-control" value="{{ $user->fullname ?? 'N/A' }}" disabled />
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <label class="form-label fw-bold">Sisa Cuti Tahunan:</label>
                <input type="text" class="form-control" value="{{ $leaveBalance ?? 0 }} hari" disabled />
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <label class="form-label fw-bold">Cuti Terpakai:</label>
                <input type="text" class="form-control" value="{{ $usedLeaveDays ?? 0 }} hari" disabled />
            </div>
        </div>
        @endif

        {{-- Tabel Riwayat --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover kontrak-table">
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
                                        <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }} -
                                            {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}
                                        </td>
                                        <td>{{ $leave->total_days }}</td>
                                        <td>
                                            @php
                                            $statusConfig = match ($leave->status) {
                                            'pending Apron' => [
                                            'class' => 'status-pending',
                                            'text' => 'Menunggu',
                                            ],
                                            'pending Bge' => [
                                            'class' => 'status-pending',
                                            'text' => 'Menunggu',
                                            ],
                                            'pending' => [
                                            'class' => 'status-pending',
                                            'text' => 'Menunggu HO',
                                            ],
                                            'approved' => [
                                            'class' => 'status-approved',
                                            'text' => 'Disetujui',
                                            ],
                                            'rejected by leader' => [
                                            'class' => 'status-rejected',
                                            'text' => 'Ditolak Leader',
                                            ],
                                            'rejected by ho' => [
                                            'class' => 'status-rejected',
                                            'text' => 'Ditolak Head Of Airport Service',
                                            ],
                                            default => [
                                            'class' => 'status-canceled',
                                            'text' => 'Dibatalkan',
                                            ],
                                            };
                                            @endphp
                                            <span
                                                class="status-badge {{ $statusConfig['class'] }}">{{ $statusConfig['text'] }}</span>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-info btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#leaveDetailModal{{ $leave->id }}">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                    @include('leaves.partials.modal_detail', [
                                    'leave' => $leave,
                                    'statusConfig' => $statusConfig,
                                    ])
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pengajuan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3 text-center">{{ $leaves->links('pagination::bootstrap-5') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
