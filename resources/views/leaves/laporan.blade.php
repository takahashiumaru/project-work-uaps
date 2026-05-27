@extends('layout.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Laporan Cuti Karyawan</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Rekapitulasi data cuti seluruh karyawan.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                {{-- Filter --}}
                <form action="{{ route('leaves.laporan') }}" method="GET">
                    <div class="dt-toolbar">
                        <div class="d-flex flex-wrap gap-3 align-items-end flex-grow-1">
                            <div>
                                <label class="form-label">Tahun</label>
                                <input type="number" name="year" class="form-control" value="{{ request('year', date('Y')) }}" style="min-width: 100px;">
                            </div>
                            <div class="dt-search">
                                <i class="bx bx-search search-icon"></i>
                                <input type="text" name="user_name" class="form-control" placeholder="Cari NIP atau Nama..." value="{{ request('user_name') }}">
                            </div>
                            <button type="submit" class="btn btn-primary" style="height: 40px;">
                                <i class="bx bx-filter-alt me-1"></i>Filter
                            </button>
                            <a href="{{ route('leaves.laporan') }}" class="btn btn-outline-secondary" style="height: 40px; display:inline-flex; align-items:center;">Reset</a>
                        </div>
                        <div class="dt-actions">
                            <a href="{{ route('leaves.export', request()->only(['year', 'user_name'])) }}" class="btn btn-success" style="height: 40px; display: inline-flex; align-items: center;">
                                <i class="bx bx-spreadsheet me-1"></i>Export Excel
                            </a>
                        </div>
                    </div>
                </form>

                {{-- Tabel --}}
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Mulai</th>
                                <th>Akhir</th>
                                <th>Hari</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Approver</th>
                                <th>Tgl Approve</th>
                                <th>Rejector</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leaves as $leave)
                                <tr>
                                    <td><strong>{{ $leave->user->id ?? '-' }}</strong></td>
                                    <td>{{ $leave->user->fullname ?? '-' }}</td>
                                    <td>{{ $leave->leave_type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                                    <td>{{ $leave->total_days }}</td>
                                    <td>
                                        @php
                                            $statusConfig = match ($leave->status) {
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
                                    @php
                                        $isSelfApprovedFallback = $leave->status === 'approved' && empty($leave->approved_by);
                                        $approverName = $leave->user_approve
                                            ?? ($isSelfApprovedFallback ? ($leave->user_leave ?? '-') : '-');
                                        $approvedAt = $leave->approved_at
                                            ?: ($isSelfApprovedFallback ? ($leave->updated_at ?: $leave->created_at) : null);
                                    @endphp
                                    <td>{{ $leave->reason ?? '-' }}</td>
                                    <td>{{ $approverName }}</td>
                                    <td>{{ $approvedAt ? \Carbon\Carbon::parse($approvedAt)->format('d M Y H:i') : '-' }}</td>
                                    <td>{{ $leave->user_rejected ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <div class="empty-state">
                                            <i class="bx bx-file d-block"></i>
                                            <p>Tidak ada data cuti ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="dt-pagination-wrapper">
                    {{ $leaves->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
