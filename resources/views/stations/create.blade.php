@extends('layout.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Station /</span> Buka Station Baru
    </h4>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Formulir Ekspansi Station</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('stations.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Kode Station (IATA Code)</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="fas fa-plane"></i></span>
                                <input type="text" name="code" class="form-control" placeholder="Cth: SOC" maxlength="3" required style="text-transform: uppercase;" />
                            </div>
                            <div class="form-text">Maksimal 3 Huruf (Contoh: CGK, SUB, SOC).</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lokasi / Kota</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="Cth: Solo (Adi Soemarmo)" required />
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Buka Station Sekarang
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-label-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection