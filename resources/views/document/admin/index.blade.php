@extends('layout.admin')

@section('title', 'Manajemen Dokumen')

@section('styles')
    @include('document.admin.styles')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y document-admin-page">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <span class="text-muted fw-light">Dokumen /</span> Manajemen Dokumen
                </h4>
                <p class="text-muted mb-0">Kelola dokumen, file unduhan, dan role akses dokumen.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dokumen</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="dt-toolbar">
                    <form action="{{ route('admin.documents.index') }}" method="GET" class="dt-search">
                        <i class="ti ti-search search-icon"></i>
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari nama dokumen, deskripsi, file, atau role..."
                            value="{{ request('search') }}">
                    </form>
                    <div class="dt-actions">
                        <a href="{{ route('document') }}" class="btn btn-label-secondary">
                            <i class="ti ti-eye"></i>Lihat Halaman
                        </a>
                        <a href="{{ route('admin.documents.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i>Tambah Dokumen
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Dokumen</th>
                                <th>Role Akses</th>
                                <th>Nama File</th>
                                <th>Dibuat</th>
                                <th>Diupdate</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($documents as $document)
                                @php
                                    $fileExists = $document->file_path
                                        && \Illuminate\Support\Facades\Storage::disk('public')->exists($document->file_path);
                                @endphp
                                <tr>
                                    <td style="min-width: 260px;">
                                        <strong>{{ $document->nama_dokumen }}</strong>
                                        <div class="small text-muted">{{ $document->deskripsi_dokumen }}</div>
                                    </td>
                                    <td>
                                        <span class="access-badge {{ $document->access_class }}">
                                            {{ $document->access_full_label }}
                                        </span>
                                    </td>
                                    <td style="min-width: 180px;">
                                        <div class="fw-semibold text-truncate" style="max-width: 220px;">
                                            {{ $document->nama_file }}
                                        </div>
                                        <div class="small text-muted">
                                            {{ $document->ukuran_file ?? '-' }}
                                            @unless ($fileExists)
                                                <span class="text-danger ms-1">File belum ada</span>
                                            @endunless
                                        </div>
                                    </td>
                                    <td style="min-width: 160px;">
                                        <div class="fw-semibold">{{ optional($document->created_at)->format('d M Y H:i') }}</div>
                                        <div class="small text-muted">{{ $document->creator->fullname ?? $document->created_by ?? '-' }}</div>
                                    </td>
                                    <td style="min-width: 160px;">
                                        <div class="fw-semibold">{{ optional($document->updated_at)->format('d M Y H:i') }}</div>
                                        <div class="small text-muted">{{ $document->updater->fullname ?? $document->updated_by ?? '-' }}</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            @if ($fileExists)
                                                <a href="{{ route('document.download', $document) }}" class="action-btn"
                                                    title="Unduh">
                                                    <i class="ti ti-download"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.documents.edit', $document) }}" class="action-btn"
                                                title="Edit">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.documents.destroy', $document) }}" method="POST"
                                                id="delete-document-{{ $document->id }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="action-btn action-delete border-0"
                                                    title="Hapus"
                                                    onclick="confirmDeleteDocument('{{ $document->id }}')">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="ti ti-file-text d-block"></i>
                                            <p>Tidak ada data dokumen.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $documents->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmDeleteDocument(id) {
            Swal.fire({
                title: 'Hapus dokumen?',
                text: 'Data dan file dokumen akan dihapus dari sistem.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-document-' + id).submit();
                }
            });
        }
    </script>
@endsection
