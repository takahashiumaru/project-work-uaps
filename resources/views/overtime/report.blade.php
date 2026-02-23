@extends('layout.admin')
@section('title', 'Laporan Lembur')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Laporan Lembur (Rekapitulasi)</h4>
        
        {{-- Card Total Jam --}}
        <div class="card bg-primary text-white">
            <div class="card-body py-2 px-3">
                <span class="small opacity-75">Total Jam Lembur (Approved)</span>
                <h4 class="mb-0 text-white">{{ $totalHours }} Jam</h4>
            </div>
        </div>
    </div>

    {{-- Filter Sederhana --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('overtime.report') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Station</label>
                    <input type="text" name="station" class="form-control" placeholder="Kode Station (Contoh: CGK)" value="{{ request('station') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="date_start" class="form-control" value="{{ request('date_start') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="date_end" class="form-control" value="{{ request('date_end') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2 w-100">Filter</button>
                    <a href="{{ route('overtime.report') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Lembur Disetujui</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama Staff</th>
                        <th>Station</th>
                        <th>Tanggal</th>
                        <th>Durasi</th>
                        <th>Kegiatan</th>
                        <th>Di-ACC Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($overtimes as $ot)
                    <tr>
                        <td>
                            <strong>{{ $ot->user->fullname }}</strong><br>
                            <small class="text-muted">{{ $ot->user->role }}</small>
                        </td>
                        <td><span class="badge bg-label-primary">{{ $ot->user->station }}</span></td>
                        <td>{{ date('d M Y', strtotime($ot->date)) }}</td>
                        <td class="fw-bold text-end">{{ $ot->duration }} Jam</td>
                        <td>
                            <span class="fw-bold">{{ $ot->title }}</span><br>
                            <small class="text-muted" style="white-space: normal;">{{ Str::limit($ot->description, 50) }}</small>
                        </td>
                        <td><span class="badge bg-label-success">{{ $ot->approved_by }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bx bx-data fs-1 text-muted mb-2"></i>
                            <p class="text-muted">Belum ada data lembur yang disetujui.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        <div class="card-footer">
            {{ $overtimes->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection