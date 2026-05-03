@extends('layout.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Detail Sertifikat Training</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Informasi lengkap mengenai sertifikat karyawan.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.training.certificates.index') }}">Training</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                <h5 class="mb-0">Informasi Sertifikat</h5>
                <a href="{{ route('admin.training.certificates.edit', $certificate->id) }}" class="btn btn-primary btn-sm">
                    <i class="bx bx-edit me-1"></i>Edit Sertifikat
                </a>
            </div>
            <div class="card-body pt-4">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="info-group mb-4">
                            <label class="text-muted small text-uppercase fw-bold">Staff</label>
                            <div class="d-flex align-items-center mt-1">
                                <div class="avatar avatar-md me-3">
                                    <span class="avatar-initial rounded bg-label-primary">{{ substr($certificate->user->fullname ?? 'N', 0, 1) }}</span>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $certificate->user->fullname ?? 'N/A' }}</h6>
                                    <small class="text-muted">NIP: {{ $certificate->user_id ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="info-group mb-4">
                            <label class="text-muted small text-uppercase fw-bold">Nama Sertifikat</label>
                            <h6 class="mt-1">{{ $certificate->certificate_name }}</h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-group mb-4">
                            <label class="text-muted small text-uppercase fw-bold">Masa Berlaku</label>
                            <div class="mt-1">
                                <div><i class="bx bx-calendar me-1"></i> Mulai: {{ $certificate->start_date->format('d M Y') }}</div>
                                <div class="fw-bold"><i class="bx bx-calendar-check me-1"></i> Akhir: {{ $certificate->end_date->format('d M Y') }}</div>
                            </div>
                        </div>

                        <div class="info-group mb-4">
                            <label class="text-muted small text-uppercase fw-bold">Status</label>
                            <div class="mt-1">
                                @if ($certificate->is_expired)
                                    <span class="badge bg-danger">Kadaluarsa</span>
                                    <div class="small text-danger mt-1">
                                        {{ $certificate->end_date->diffForHumans(now(), true) }} lalu
                                    </div>
                                @elseif ($certificate->is_expiring_soon)
                                    <span class="badge bg-warning text-dark">Mendekati Expired</span>
                                    <div class="small text-warning mt-1">
                                        Sisa {{ $certificate->remaining_days }} hari
                                    </div>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-group mb-4">
                    <label class="text-muted small text-uppercase fw-bold d-block mb-2">File Sertifikat</label>
                    @if ($certificate->certificate_file)
                        <div class="d-flex align-items-center p-3 border rounded">
                            <i class="bx bxs-file-pdf fs-1 text-danger me-3"></i>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Dokumen Sertifikat</h6>
                                <small class="text-muted">Format: PDF/Gambar</small>
                            </div>
                            <a href="{{ Storage::url($certificate->certificate_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-show me-1"></i>Lihat Dokumen
                            </a>
                        </div>
                    @else
                        <div class="text-muted italic small">Tidak ada file sertifikat yang diunggah.</div>
                    @endif
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.training.certificates.index') }}" class="btn btn-label-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection