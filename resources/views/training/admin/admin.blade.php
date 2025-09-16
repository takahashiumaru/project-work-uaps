@extends('app')

@section('title', 'Halaman Training')
@section('content')
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Manajemen Sertifikat Training Staff
        </h2>
    </x-slot>

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            Daftar Seluruh Sertifikat
            <a href="{{ route('certificates.create') }}" class="btn btn-primary btn-sm">Tambah Sertifikat</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.certificates.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, NIP, atau nama sertifikat..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.certificates.index') }}" class="btn btn-outline-danger">Reset</a>
                    @endif
                </div>
            </form>

            @if ($certificates->isEmpty())
                <p>Tidak ada data sertifikat ditemukan.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama Staff</th>
                                <th>NIP</th>
                                <th>Nama Sertifikat</th>
                                <th>Masa Berlaku Awal</th>
                                <th>Masa Berlaku Akhir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($certificates as $certificate)
                                <tr class="{{ $certificate->is_expiring ? 'expiring-soon' : ($certificate->end_date->isPast() ? 'expired' : '') }}">
                                    <td>{{ $certificate->user->name }}</td>
                                    <td>{{ $certificate->user->nip }}</td>
                                    <td>{{ $certificate->certificate_name }}</td>
                                    <td>{{ $certificate->start_date->format('d M Y') }}</td>
                                    <td>{{ $certificate->end_date->format('d M Y') }}</td>
                                    <td>
                                        @if ($certificate->end_date->isPast())
                                            <span class="badge bg-danger">Kadaluarsa ({{ $certificate->end_date->diffForHumans(now(), true) }} lalu)</span>
                                        @elseif ($certificate->is_expiring)
                                            <span class="badge bg-warning text-dark">Akan Kadaluarsa (Sisa {{ $certificate->remaining_days }} hari)</span>
                                        @else
                                            <span class="badge bg-success">Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.certificates.edit', $certificate) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                                        <form action="{{ route('admin.certificates.destroy', $certificate) }}" method="POST" class="d-inline">
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
            @endif
        </div>
    </div>
@endsection
