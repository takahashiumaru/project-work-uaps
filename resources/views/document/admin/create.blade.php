@extends('layout.admin')

@section('title', 'Tambah Dokumen')

@section('styles')
    @include('document.admin.styles')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y document-admin-page">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <span class="text-muted fw-light">Dokumen /</span> Tambah Dokumen
                </h4>
                <p class="text-muted mb-0">Upload dokumen baru dan tentukan role yang boleh mengaksesnya.</p>
            </div>
            <a href="{{ route('admin.documents.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <div class="card">
            <h5 class="card-header">Formulir Tambah Dokumen</h5>
            <div class="card-body">
                <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                    @include('document.admin._form', [
                        'submitLabel' => 'Simpan Dokumen',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('document.admin.form-scripts')
@endsection
