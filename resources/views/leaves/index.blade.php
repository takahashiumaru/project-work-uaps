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
            <h5 class="mb-0">Approval Pengajuan Izin & Cuti</h5>
        </div>

        <div class="card-body">
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
                                                    {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
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
                                                            'rejected_by_pic' => [
                                                                'class' => 'status-rejected',
                                                                'text' => 'Ditolak PIC',
                                                            ],
                                                            'rejected_by_ho' => [
                                                                'class' => 'status-rejected',
                                                                'text' => 'Ditolak HO',
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
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#leaveDetailModal{{ $leave->id }}">Detail</button>
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
