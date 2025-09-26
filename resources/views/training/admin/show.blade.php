@extends('layout.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Training /</span> Detail Sertifikat Training
</h4>

<div class="card mb-4">
    <div class="card-header">
        Informasi Sertifikat
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nama Staff:</dt>
            <dd class="col-sm-9">{{ $certificate->user->name ?? 'N/A' }}</dd>

            <dt class="col-sm-3">NIP:</dt>
            <dd class="col-sm-9">{{ $certificate->user->nip ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Nama Sertifikat:</dt>
            <dd class="col-sm-9">{{ $certificate->certificate_name }}</dd>

            <dt class="col-sm-3">Masa Berlaku Awal:</dt>
            <dd class="col-sm-9">{{ $certificate->start_date->format('d M Y') }}</dd>

            <dt class="col-sm-3">Masa Berlaku Akhir:</dt>
            <dd class="col-sm-9">{{ $certificate->end_date->format('d M Y') }}</dd>

            <dt class="col-sm-3">Status:</dt>
            <dd class="col-sm-9">
                @if ($certificate->is_expired)
                    <span class="badge bg-danger">Kadaluarsa ({{ $certificate->end_date->diffForHumans(now(), true) }} lalu)</span>
                @elseif ($certificate->is_expiring_soon)
                    <span class="badge bg-warning text-dark">Akan Kadaluarsa (Sisa {{ $certificate->remaining_days }} hari)</span>
                @else
                    <span class="badge bg-success">Aktif</span>
                @endif
            </dd>

            <dt class="col-sm-3">File Sertifikat:</dt>
            <dd class="col-sm-9">
                @if ($certificate->file_path)
                    <a href="{{ Storage::url($certificate->file_path) }}" target="_blank" class="btn btn-info btn-sm">Lihat File</a>
                @else
                    Tidak ada file
                @endif
            </dd>
        </dl>
        {{-- Mengubah route admin.training.certificates.index menjadi training.index --}}
        <a href="{{ route('admin.training.certificates.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection