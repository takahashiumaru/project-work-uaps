@extends('layout.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Manajemen Operasional Station</h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Status Station</h5>
            <a href="{{ route('stations.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Buka Station Baru
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Station</th>
                        <th>Status Saat Ini</th>
                        <th>Aksi Kontrol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stations as $st)
                    <tr>
                        <td><strong>{{ $st->code }}</strong></td>
                        <td>{{ $st->name }}</td>
                        <td>
                            @if($st->is_active)
                                <span class="badge bg-success">OPERASIONAL (ON)</span>
                            @else
                                <span class="badge bg-danger">DIBEKUKAN (OFF)</span>
                            @endif
                        </td>
                        <td>
                            {{-- Form Toggle Switch --}}
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
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection