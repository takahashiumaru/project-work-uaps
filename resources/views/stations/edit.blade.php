@extends('layout.admin')

@section('styles')
<style>
    .station-form-shell {
        max-width: 760px;
        margin: 0 auto;
    }

    .station-form-card .card-header {
        padding: 1.35rem 1.65rem !important;
    }

    .station-form-card .card-body {
        padding: 1.65rem !important;
    }

    .station-form-card .input-group-text {
        width: 46px;
        justify-content: center;
        background: #ffffff;
        border-color: #e6edf5;
        color: #64748b;
    }

    .station-location-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 0.85rem;
        margin-bottom: 0.65rem !important;
    }

    .station-form-card .form-label {
        margin-bottom: 0.38rem;
    }

    .station-map-field {
        margin-bottom: 1rem !important;
    }

    .station-map-preview {
        position: relative;
        height: 148px;
        border: 1px solid #e6edf5;
        border-radius: 14px;
        overflow: hidden;
        background: linear-gradient(135deg, #f8fbff 0%, #eef6ff 100%);
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.85);
    }

    .station-map-preview iframe {
        position: absolute;
        inset: 0;
        width: 100%;
        height: calc(100% + 34px);
        border: 0;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .station-map-preview::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 1;
        cursor: default;
    }

    .station-map-preview.has-location iframe {
        opacity: 1;
    }

    .station-map-empty {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        text-align: center;
        padding: 1rem;
        color: #64748b;
        pointer-events: none;
    }

    .station-map-preview.has-location .station-map-empty {
        display: none;
    }

    .station-map-empty i {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #eaf4ff;
        color: #2f80ed;
        font-size: 1.35rem;
    }

    .station-map-chip {
        position: absolute;
        left: 12px;
        bottom: 10px;
        z-index: 2;
        display: none;
        align-items: center;
        gap: 0.35rem;
        max-width: calc(100% - 24px);
        padding: 0.45rem 0.65rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.92);
        color: #334155;
        font-size: 0.76rem;
        font-weight: 500;
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.1);
        backdrop-filter: blur(6px);
        pointer-events: none;
    }

    .station-map-preview.has-location .station-map-chip {
        display: inline-flex;
    }

    @media (max-width: 767.98px) {
        .station-location-grid {
            grid-template-columns: 1fr;
        }

        .station-map-preview {
            height: 140px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Station /</span> Update Station
    </h4>

    <div class="station-form-shell">
            <div class="card mb-4 station-form-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Update Formulir Ekspansi Station</h5>
                        <small class="text-muted">Ubah koordinat untuk memastikan titik station sudah tepat.</small>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('stations.update', $station->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Kode Station (IATA Code)</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ti ti-plane"></i></span>
                                <input type="text" name="code" class="form-control" value="{{ $station->code }}" maxlength="3" required style="text-transform: uppercase;" readonly />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lokasi / Kota</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ti ti-map-2"></i></span>
                                <input type="text" name="name" class="form-control" value="{{ $station->name }}" readonly/>
                            </div>
                        </div>

                        <div class="station-location-grid mb-3">
                            <div>
                                <label class="form-label">Latitude</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">
                                        <i class="ti ti-map-pin"></i>
                                    </span>
                                    <input
                                        type="number"
                                        name="latitude"
                                        class="form-control js-station-latitude"
                                        value="{{ old('latitude', $station->latitude) }}"
                                        step="any"
                                        required />
                                </div>
                            </div>

                            <div>
                                <label class="form-label">Longitude</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">
                                        <i class="ti ti-map-pin"></i>
                                    </span>
                                    <input
                                        type="number"
                                        name="longitude"
                                        class="form-control js-station-longitude"
                                        value="{{ old('longitude', $station->longitude) }}"
                                        step="any"
                                        required />
                                </div>
                            </div>
                        </div>

                        <div class="station-map-field">
                            <label class="form-label">Preview Titik Lokasi</label>
                            <div class="station-map-preview js-station-map-preview" aria-label="Preview titik lokasi station">
                                <iframe class="js-station-map-frame" title="Preview Map Station" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                <div class="station-map-empty">
                                    <i class="ti ti-map-search"></i>
                                    <strong>Belum ada titik</strong>
                                    <small>Masukkan latitude dan longitude untuk melihat preview.</small>
                                </div>
                                <div class="station-map-chip">
                                    <i class="ti ti-map-pin-filled"></i>
                                    <span class="js-station-map-coordinate">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i> Simpan Perubahan Station
                            </button>
                            <a href="{{ route('stations.index') }}" class="btn btn-label-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const latitudeInput = document.querySelector('.js-station-latitude');
        const longitudeInput = document.querySelector('.js-station-longitude');
        const preview = document.querySelector('.js-station-map-preview');
        const frame = document.querySelector('.js-station-map-frame');
        const coordinate = document.querySelector('.js-station-map-coordinate');

        if (!latitudeInput || !longitudeInput || !preview || !frame || !coordinate) return;

        const isCoordinateValid = (lat, lng) => Number.isFinite(lat) && Number.isFinite(lng) &&
            lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180;

        const updateMapPreview = () => {
            const latitudeValue = latitudeInput.value.trim();
            const longitudeValue = longitudeInput.value.trim();
            const lat = Number(latitudeValue);
            const lng = Number(longitudeValue);

            if (!latitudeValue || !longitudeValue || !isCoordinateValid(lat, lng)) {
                preview.classList.remove('has-location');
                frame.removeAttribute('src');
                coordinate.textContent = '-';
                return;
            }

            const delta = 0.002;
            const bbox = [
                (lng - delta).toFixed(6),
                (lat - delta).toFixed(6),
                (lng + delta).toFixed(6),
                (lat + delta).toFixed(6),
            ].join('%2C');

            frame.src = `https://www.openstreetmap.org/export/embed.html?bbox=${bbox}&layer=mapnik&marker=${lat.toFixed(6)}%2C${lng.toFixed(6)}`;
            coordinate.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            preview.classList.add('has-location');
        };

        latitudeInput.addEventListener('input', updateMapPreview);
        longitudeInput.addEventListener('input', updateMapPreview);
        updateMapPreview();
    });
</script>
@endsection
