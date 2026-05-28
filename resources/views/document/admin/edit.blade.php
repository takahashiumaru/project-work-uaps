@extends('layout.admin')

@section('title', 'Edit Dokumen')

@section('styles')
    @include('document.admin.styles')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y document-admin-page">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <span class="text-muted fw-light">Dokumen /</span> Edit Dokumen
                </h4>
                <p class="text-muted mb-0">Perbarui metadata dokumen atau ganti file unduhan.</p>
            </div>
            <a href="{{ route('admin.documents.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <div class="card">
            <h5 class="card-header">Formulir Edit Dokumen</h5>
            <div class="card-body">
                <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data">
                    @include('document.admin._form', [
                        'method' => 'PUT',
                        'submitLabel' => 'Perbarui Dokumen',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('document.admin.form-scripts')
@endsection
