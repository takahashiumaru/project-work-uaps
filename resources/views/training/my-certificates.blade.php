@extends('app')

@section('title', 'Halaman Training')
@section('content')
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Sertifikat Training Saya
        </h2>
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header">
            Daftar Sertifikat
        </div>
        <div class="card-body">
            @if ($certificates->isEmpty())
                <p>Anda belum memiliki sertifikat training.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama Sertifikat</th>
                                <th>Masa Berlaku Awal</th>
                                <th>Masa Berlaku Akhir</th>
                                <th>Status</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($certificates as $certificate)
                                <tr class="{{ $certificate->is_expiring_soon ? 'expiring-soon' : ($certificate->is_expired ? 'expired' : '') }}">
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $certificates->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>
@endsection