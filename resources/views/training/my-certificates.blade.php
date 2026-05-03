@extends('layout.admin')

@section('title', 'Sertifikat Training Saya')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Sertifikat Training Saya</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Pantau masa berlaku sertifikat dan riwayat training Anda.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Sertifikat Saya</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                @if ($certificates->isEmpty())
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="bx bx-certification d-block fs-1 mb-3 text-muted"></i>
                            <h5>Belum Ada Sertifikat</h5>
                            <p class="text-muted">Anda belum memiliki data sertifikat training yang tercatat.</p>
                        </div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Sertifikat</th>
                                    <th>Masa Berlaku Awal</th>
                                    <th>Masa Berlaku Akhir</th>
                                    <th>Status</th>
                                    <th class="text-center">File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($certificates as $certificate)
                                    @php
                                        $rowClass = '';
                                        if ($certificate->is_expired) {
                                            $rowClass = 'row-critical';
                                        } elseif ($certificate->is_expiring_soon) {
                                            $rowClass = 'row-warning';
                                        }
                                    @endphp
                                    <tr class="{{ $rowClass }}">
                                        <td>
                                            <div class="fw-bold text-primary">{{ $certificate->certificate_name }}</div>
                                        </td>
                                        <td>{{ $certificate->start_date->format('d M Y') }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $certificate->end_date->format('d M Y') }}</div>
                                        </td>
                                        <td>
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
                                        </td>
                                        <td class="text-center">
                                            @if ($certificate->certificate_file)
                                                <a href="{{ Storage::url($certificate->certificate_file) }}" target="_blank" 
                                                   class="btn btn-sm btn-outline-primary" title="Lihat File">
                                                    <i class='bx bx-file me-1'></i>Lihat
                                                </a>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $certificates->links('vendor.pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection