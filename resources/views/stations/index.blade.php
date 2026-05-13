@extends('layout.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Manajemen Station</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Daftar dan kontrol status operasional station.</p>
            </div>
            <a href="{{ route('stations.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus me-1"></i> Buka Station Baru
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Station</th>
                                <th>Status</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Aksi Kontrol</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stations as $st)
                            <tr>
                                <td><strong>{{ $st->code }}</strong></td>
                                <td>{{ $st->name }}</td>
                                <td>
                                    @if($st->is_active)
                                        <span class="badge bg-label-success">Operasional</span>
                                    @else
                                        <span class="badge bg-label-danger">Dibekukan</span>
                                    @endif
                                </td>
                                <td>{{ $st->latitude }}</td>
                                <td>{{ $st->longitude }}</td>
                                <td>
                                    <form action="{{ route('stations.toggle', $st->id) }}" method="POST">
                                        @csrf
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" 
                                                   role="switch" 
                                                   onchange="this.form.submit()" 
                                                   style="width: 3em; height: 1.5em; cursor: pointer;"
                                                   {{ $st->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2 mt-1">
                                                {{ $st->is_active ? 'Matikan' : 'Hidupkan' }}
                                            </label>
                                </td>
                                <td>
                                    <a href="{{ route('stations.edit', $st->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit me-2"></i> Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="dt-pagination-wrapper">
                    {{ $stations->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection