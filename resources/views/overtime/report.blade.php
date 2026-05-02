@extends('layout.admin')
@section('title', 'Laporan Lembur')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Laporan Lembur (Rekapitulasi)</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Data lembur yang telah disetujui untuk kebutuhan payroll.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-label-primary" style="font-size: 0.875rem; padding: 0.5em 1em;">
                    <i class="bx bx-time-five me-1"></i>Total: {{ $totalHours }} Jam
                </span>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                {{-- Filter --}}
                <form action="{{ route('overtime.report') }}" method="GET">
                    <div class="dt-toolbar">
                        <div class="d-flex flex-wrap gap-3 align-items-end flex-grow-1">
                            <div class="dt-search" style="max-width: 250px;">
                                <i class="bx bx-search search-icon"></i>
                                <input type="text" name="search" class="form-control" placeholder="Cari NIP atau Nama..." value="{{ request('search') }}">
                            </div>
                            <div>
                                <label class="form-label">Station</label>
                                <input type="text" name="station" class="form-control" placeholder="Kode Station (CGK)" value="{{ request('station') }}" style="min-width: 160px;">
                            </div>
                            <div>
                                <label class="form-label">Dari Tanggal</label>
                                <input type="date" name="date_start" class="form-control" value="{{ request('date_start') }}">
                            </div>
                            <div>
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" name="date_end" class="form-control" value="{{ request('date_end') }}">
                            </div>
                            <button type="submit" class="btn btn-primary" style="height: 40px;">
                                <i class="bx bx-filter-alt me-1"></i>Filter
                            </button>
                            <a href="{{ route('overtime.report') }}" class="btn btn-outline-secondary" style="height: 40px; display:inline-flex; align-items:center;">Reset</a>
                            <a href="{{ route('overtime.export', request()->query()) }}" class="btn btn-success" style="height: 40px; display:inline-flex; align-items:center;">
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
                                <th>Nama Staff</th>
                                <th>Station</th>
                                <th>Tanggal</th>
                                <th>Durasi</th>
                                <th>Kegiatan</th>
                                <th>Disetujui Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($overtimes as $ot)
                            <tr>
                                <td>
                                    <strong>{{ $ot->user->fullname }}</strong><br>
                                    <small class="text-muted">NIP: {{ $ot->user_id }}</small>
                                </td>
                                <td><span class="badge bg-label-secondary">{{ $ot->user->station }}</span></td>
                                <td>{{ date('d M Y', strtotime($ot->date)) }}</td>
                                <td><span class="badge bg-label-success">{{ $ot->duration }} Jam</span></td>
                                <td>
                                    <strong>{{ $ot->title }}</strong><br>
                                    <small class="text-muted">{{ $ot->description }}</small>
                                </td>
                                <td><small>{{ $ot->approved_by ?? '-' }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bx bx-file-blank d-block"></i>
                                        <p>Tidak ada data lembur yang disetujui.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $overtimes->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection