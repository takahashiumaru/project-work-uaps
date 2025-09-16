@extends('app')

@section('title', 'Halaman Training')
@section('content')
<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        Manajemen Sertifikat Training Staff
    </h2>
</x-slot>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        Daftar Seluruh Sertifikat
        <a href="{{ route('admin.training.certificates.create') }}" class="btn btn-primary btn-sm">Tambah Sertifikat</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.training.certificates.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama, NIP, atau nama sertifikat..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                @if(request('search'))
                <a href="{{ route('admin.training.certificates.index') }}" class="btn btn-outline-danger">Reset</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama Staff</th>
                        <th>Safety Management System</th>
                        <th>Human Factors</th>
                        <th>Ramp Safety / Airside Safety</th>
                        <th>Dangerous Goods (DG) Regulations</th>
                        <th>Aviation Security (AVSEC) Awareness</th>
                        <th>Airport Emergency Plan (AEP)</th>
                        <th>Ground Support Equipment (GSE) Operation</th>
                        <th>Basic First Aid (Pertolongan Pertama)</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificates as $certificate)
                    <tr class="{{ $certificate->is_expiring_soon ? 'expiring-soon' : ($certificate->is_expired ? 'expired' : '') }}">
                        <td>{{ $certificate->fullname ?? 'N/A' }}</td>
                        <td>{{ $certificate->nip ?? 'N/A' }}</td>
                        <td>{{ $certificate->certificate_name }}</td>
                        <td>{{ $certificate->start_date->format('d M Y') }}</td>
                        <td>{{ $certificate->end_date->format('d M Y') }}</td>
                        <td>
                            @if ($certificate->is_expired)
                            <span class="badge bg-danger">Kadaluarsa ({{ $certificate->end_date->diffForHumans(now(), true) }} lalu)</span>
                            @elseif ($certificate->is_expiring_soon)
                            <span class="badge bg-warning text-dark">Akan Kadaluarsa (Sisa {{ $certificate->remaining_days }} hari)</span>
                            @else
                            <span class="badge bg-success">Aktif</span>
                            @endif
                        </td>
                        <td>
                            @if ($certificate->file_path)
                            <a href="{{ Storage::url($certificate->file_path) }}" target="_blank" class="btn btn-info btn-sm">Lihat File</a>
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.training.certificates.edit', $certificate) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                            <form action="{{ route('admin.training.certificates.destroy', $certificate) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $certificates->links() }}

    </div>
</div>
@endsection
