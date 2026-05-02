@extends('layout.admin')

@section('title', 'Manajemen Training & Sertifikat')

@section('content')
<<<<<<< Updated upstream
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Training /</span> Manajemen Training
    </h4>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Seluruh Sertifikat</h5>
            <a href="{{ route('admin.training.certificates.create') }}" class="btn btn-primary">Tambah Sertifikat</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.training.certificates.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari nama, NIP, atau nama sertifikat..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    @if (request('search'))
                        <a href="{{ route('admin.training.certificates.index') }}" class="btn btn-outline-danger">Reset</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive text-nowrap">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            {{-- Header disesuaikan agar sesuai dengan data binding yang ada --}}
                            <th>NIP</th>
                            <th>Nama Staff</th>
                            <th>Nama Sertifikat</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Status</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($certificates as $certificate)
                            {{-- Kelas untuk styling status kadaluarsa/mendekati kadaluarsa --}}
                            <tr
                                class="{{ $certificate->is_expiring_soon ? 'bg-label-warning' : ($certificate->is_expired ? 'bg-label-danger' : '') }}">
                                {{-- Kolom Data --}}
                                <td><strong>{{ $certificate->user_id ?? 'N/A' }}</strong></td>
                                <td>{{ $certificate->fullname ?? 'N/A' }}</td>
                                <td>{{ $certificate->certificate_name }}</td>
                                <td>{{ $certificate->start_date->format('d M Y') }}</td>
                                <td>{{ $certificate->end_date->format('d M Y') }}</td>

                                {{-- Kolom Status --}}
                                <td>
                                    @if ($certificate->is_expired)
                                        <span class="badge bg-danger">Kadaluarsa
                                            ({{ $certificate->end_date->diffForHumans(now(), true) }} lalu)
                                        </span>
                                    @elseif ($certificate->is_expiring_soon)
                                        <span class="badge bg-warning text-dark">Akan Kadaluarsa (Sisa
                                            {{ $certificate->remaining_days }} hari)</span>
                                    @else
                                        <span class="badge bg-success">Aktif</span>
                                    @endif
                                </td>

                                {{-- Kolom File --}}
                                <td>
                                    @if ($certificate->certificate_file)
                                        {{-- Menggunakan icon boxicon dari admin layout --}}
                                        <a href="{{ Storage::url($certificate->certificate_file) }}" target="_blank"
                                            class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Lihat File">
                                            <i class='bx bx-file'></i>
                                        </a>
                                    @else
                                        {{ $certificate->certificate_file }}
                                    @endif
                                </td>

                                {{-- Kolom Aksi --}}
                                <td class="d-flex align-items-center gap-2">
                                    <a href="{{ route('admin.training.certificates.edit', $certificate->id) }}" class="action-btn"
                                        title="Edit Certificate">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.training.certificates.destroy', $certificate->id) }}" method="POST"
                                        class="d-inline" id="delete-form-{{ $certificate->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="action-btn border-0" title="Delete Certificate"
                                            onclick="confirmDeleteCertificate('{{ $certificate->id }}')"
                                            style="background: red;">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
=======
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Manajemen Training & Sertifikat</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Monitoring validitas sertifikat dan riwayat training karyawan.</p>
>>>>>>> Stashed changes
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
                    <form action="{{ route('training.index') }}" method="GET" class="dt-search">
                        <i class="bx bx-search search-icon"></i>
                        <input type="text" name="search" class="form-control" placeholder="Cari NIP, Nama, atau Sertifikat..." value="{{ request('search') }}">
                    </form>
                    <div class="dt-actions">
                        <a href="{{ route('training.create') }}" class="btn btn-primary">
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
                                            <a href="{{ route('training.edit', $certificate->id) }}" class="action-btn" title="Edit">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                            <form action="{{ route('training.destroy', $certificate->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn" style="color: #dc2626; border-color: #fecaca; background: #fef2f2;" title="Hapus">
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
<<<<<<< Updated upstream
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to table rows
            const tableRows = document.querySelectorAll('.shift-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(4px)';
                    this.style.transition = 'all 0.2s ease';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });

            // Add click effect to action buttons
            const actionButtons = document.querySelectorAll('.action-btn');
            actionButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const originalHtml = this.innerHTML;
                    this.innerHTML = '<i class="bx bx-loader bx-spin"></i>';
                    this.style.pointerEvents = 'none';

                    setTimeout(() => {
                        this.innerHTML = originalHtml;
                        this.style.pointerEvents = 'auto';
                    }, 1000);
                });
            });

            // Show success message if there's any in session
            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });

        function confirmDeleteCertificate(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data sertifikat yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: '<i class="bx bx-trash me-1"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
=======
</div>
>>>>>>> Stashed changes
@endsection
