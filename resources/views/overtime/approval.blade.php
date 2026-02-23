@extends('layout.admin')
@section('title', 'Approval Lembur')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Persetujuan Lembur (Pending)</h4>
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Staff</th>
                        <th>Tanggal</th>
                        <th>Judul & Ket</th>
                        <th>Durasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingOvertimes as $ot)
                    <tr>
                        <td>
                            <strong>{{ $ot->user->fullname }}</strong><br>
                            <small class="text-muted">{{ $ot->user->station }} - {{ $ot->user->role }}</small>
                        </td>
                        <td>{{ date('d M Y', strtotime($ot->date)) }}</td>
                        <td>
                            <b>{{ $ot->title }}</b><br>
                            <small>{{ $ot->description }}</small>
                        </td>
                        <td><span class="badge bg-label-primary">{{ $ot->duration }} Jam</span></td>
                        <td>
                            <form action="{{ route('overtime.approve', $ot->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">✔ ACC</button>
                            </form>
                            <form action="{{ route('overtime.reject', $ot->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-danger">✖ Tolak</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Tidak ada pengajuan pending saat ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection