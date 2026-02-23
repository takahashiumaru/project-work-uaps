@extends('layout.admin')
@section('title', 'Riwayat Lembur')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold">Riwayat Lembur Saya</h4>
        <a href="{{ route('overtime.create') }}" class="btn btn-primary"><i class="bx bx-plus"></i> Ajukan Lembur</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th>Direspon Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($overtimes as $ot)
                    <tr>
                        <td>{{ date('d M Y', strtotime($ot->date)) }}</td>
                        <td>{{ $ot->title }}</td>
                        <td>{{ $ot->duration }} Jam</td>
                        <td>
                            @if($ot->status == 'Pending') <span class="badge bg-warning">Menunggu</span>
                            @elseif($ot->status == 'Approved') <span class="badge bg-success">Disetujui</span>
                            @else <span class="badge bg-danger">Ditolak</span> @endif
                        </td>
                        <td>{{ $ot->approved_by ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Belum ada data lembur.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection