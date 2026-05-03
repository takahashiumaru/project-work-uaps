@extends('layout.admin')

@section('title', 'Manajemen Training & Sertifikat')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Manajemen Training & Sertifikat</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Monitoring validitas sertifikat dan riwayat training karyawan.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Training</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                {{-- Toolbar --}}
                <div class="dt-toolbar">
                    <form action="{{ route('admin.training.certificates.index') }}" method="GET" class="dt-search">
                        <i class="bx bx-search search-icon"></i>
                        <input type="text" name="search" class="form-control" placeholder="Cari NIP, Nama, atau Sertifikat..." value="{{ request('search') }}">
                    </form>
                    <div class="dt-actions">
                        <a href="{{ route('admin.training.certificates.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i>Tambah Sertifikat
                        </a>
                    </div>
                </div>

                {{-- Tabel --}}
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Staff</th>
                                <th>Sertifikat</th>
                                <th>Masa Berlaku</th>
                                <th>Status</th>
                                <th class="text-center">File</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($certificates as $certificate)
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
                                        <strong>{{ $certificate->fullname ?? 'N/A' }}</strong>
                                        <div class="small text-muted">NIP: {{ $certificate->user_id ?? 'N/A' }}</div>
                                    </td>
                                    <td>{{ $certificate->certificate_name }}</td>
                                    <td>
                                        <div class="small text-muted">Mulai: {{ $certificate->start_date->format('d M Y') }}</div>
                                        <div class="fw-bold">Hingga: {{ $certificate->end_date->format('d M Y') }}</div>
                                    </td>
                                    <td>
                                        @if ($certificate->is_expired)
                                            <span class="badge bg-danger">Kadaluarsa</span>
                                            <div class="small text-danger" style="font-size: 0.7rem;">
                                                {{ $certificate->end_date->diffForHumans(now(), true) }} lalu
                                            </div>
                                        @elseif ($certificate->is_expiring_soon)
                                            <span class="badge bg-warning text-dark">Mendekati Expired</span>
                                            <div class="small text-warning" style="font-size: 0.7rem;">
                                                Sisa {{ $certificate->remaining_days }} hari
                                            </div>
                                        @else
                                            <span class="badge bg-success">Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($certificate->certificate_file)
                                            <a href="{{ Storage::url($certificate->certificate_file) }}" target="_blank"
                                                class="action-btn" title="Lihat File">
                                                <i class='bx bx-file'></i>
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.training.certificates.edit', $certificate->id) }}" class="action-btn" title="Edit">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                            <form action="{{ route('admin.training.certificates.destroy', $certificate->id) }}" method="POST" class="d-inline" id="delete-form-{{ $certificate->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="action-btn" style="color: #dc2626; border-color: #fecaca; background: #fef2f2;" title="Hapus" onclick="confirmDeleteCertificate('{{ $certificate->id }}')">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bx bx-certification d-block"></i>
                                            <p>Tidak ada data sertifikat training.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $certificates->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDeleteCertificate(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data sertifikat yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    @if (session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endsection
