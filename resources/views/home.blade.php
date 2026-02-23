@extends('layout.admin')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    /* --- STYLE LAMA ANDA (TIDAK DIUBAH) --- */
    .panel {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
        border: 1px solid #e0e0e0;
    }

    .panel-heading {
        background: linear-gradient(135deg, #667eea 0%, #4180c3 100%);
        color: white;
        padding: 16px 20px;
        border-radius: 8px 8px 0 0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .panel-body {
        padding: 20px;
        text-align: center;
    }

    .panel-body p {
        margin: 0;
        font-size: 2.5rem;
        font-weight: 700;
        color: #667eea;
    }

    .panel-primary .panel-heading {
        background: linear-gradient(135deg, #667eea 0%, #4180c3 100%);
    }

    .panel-success .panel-heading {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    }

    .top-charts-container,
    .bottom-charts-container {
        display: grid;
        gap: 24px;
        margin-top: 40px;
        margin-bottom: 24px;
    }

    @media(min-width: 768px) {
        .top-charts-container {
            grid-template-columns: 1fr 1fr;
        }

        .bottom-charts-container {
            grid-template-columns: 2fr 1fr;
        }
    }

    @media(max-width: 767px) {

        .top-charts-container,
        .bottom-charts-container {
            grid-template-columns: 1fr;
        }
    }

    .chart-card-custom,
    .info-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgb(0 0 0 / 0.05);
        padding: 24px;
        display: flex;
        flex-direction: column;
        border: 1px solid #e0e0e0;
    }

    .chart-card-header-custom {
        font-weight: 700;
        font-size: 1.125rem;
        color: #2563eb;
        margin-bottom: 16px;
    }

    .chart-canvas-wrapper {
        position: relative;
        height: 320px;
    }

    .info-card h3 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 1.5rem;
        font-weight: 700;
        color: #2563eb;
        text-align: center;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        font-size: 1rem;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item i {
        margin-right: 12px;
        font-size: 1.5rem;
        color: #10b981;
        width: 24px;
        text-align: center;
    }

    .info-item .label {
        font-weight: 600;
        color: #374151;
        flex: 1;
    }

    .info-item .value {
        font-weight: 700;
        color: #2563eb;
        text-align: right;
        min-width: 80px;
    }

    .table-responsive {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        background: #f8f9fa;
        border-bottom: 2px solid #e0e0e0;
        font-weight: 600;
        color: #374151;
    }

    .clickable-row {
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .clickable-row:hover {
        background-color: #f8f9fa;
    }

    .no-click {
        cursor: default !important;
    }

    .text-right {
        text-align: right;
        margin-bottom: 20px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #4180c3 100%);
        border: none;
        border-radius: 6px;
        padding: 10px 20px;
        font-weight: 600;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .countdown {
        font-weight: 600;
        color: #e53e3e;
    }

    .text-success {
        color: #38a169 !important;
    }

    .text-warning {
        color: #d69e2e !important;
    }

    .btn-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        border: none;
        border-radius: 4px;
        padding: 6px 12px;
        font-size: 0.875rem;
    }

    .row {
        margin: 0 -12px;
    }

    .row>[class*="col-"] {
        padding: 0 12px;
    }

    /* --- STYLE MONITORING STATION --- */
    .station-card {
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
        background: #fff;
    }

    .station-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-color: #667eea;
    }

    .border-left-active {
        border-left: 5px solid #48bb78 !important;
    }

    .border-left-empty {
        border-left: 5px solid #e53e3e !important;
    }

    .station-code {
        font-size: 1.5rem;
        font-weight: 800;
        color: #2d3748;
    }

    .station-name {
        font-size: 0.85rem;
        color: #718096;
    }

    .station-count {
        font-size: 1.8rem;
        font-weight: bold;
        color: #667eea;
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4">
            @php
            $hour = date('H');
            $timeGreeting = ($hour < 12) ? 'Pagi' : (($hour < 18) ? 'Siang' : 'Malam' );
                @endphp

                <h2 class="fw-bold mb-4">
                Hi {{ Auth::user()->fullname }}, Selamat {{ $timeGreeting }}
                </h2>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="fw-bold py-3 mb-0">
                        <span class="text-muted fw-light">Dashboard /</span>
                        {{-- Judul Dinamis sesuai Filter --}}
                        {{ isset($selectedStation) && $selectedStation !== 'All' ? 'Station ' . $selectedStation : 'Global Overview' }}
                    </h4>

                    <div class="d-flex align-items-center gap-2">

                        {{-- =============================================== --}}
                        {{-- 1. DROPDOWN FILTER (HANYA MUNCUL UNTUK ADMIN) --}}
                        {{-- =============================================== --}}
                        @if(Auth::user()->role == 'Admin')
                        {{-- PERBAIKAN DISINI: action diganti url()->current() agar aman --}}
                        <form action="{{ url()->current() }}" method="GET" id="stationFilterForm">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-filter text-primary"></i></span>
                                <select name="station" class="form-select border-start-0 ps-0" onchange="document.getElementById('stationFilterForm').submit()" style="min-width: 180px; font-weight: 600; cursor: pointer;">
                                    <option value="All" {{ isset($selectedStation) && $selectedStation == 'All' ? 'selected' : '' }}>Semua Station (Global)</option>
                                    @if(isset($listStations))
                                    @foreach($listStations as $st)
                                    <option value="{{ $st->code }}" {{ isset($selectedStation) && $selectedStation == $st->code ? 'selected' : '' }}>
                                        {{ $st->code }} - {{ $st->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </form>
                        @endif

                        {{-- Tombol Tambah Penerbangan --}}
                        @if (in_array(Auth::user()->role, ['Admin', 'SPV Apron', 'SPV Bge']))
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFlightModal">
                            <i class="bx bx-plus-circle me-2"></i> Flight
                        </button>
                        @endif
                    </div>
                </div>
        </div>
    </div>

    {{-- =================================================================== --}}
    {{-- MONITORING STATION WIDGET (KHUSUS ADMIN) --}}
    {{-- =================================================================== --}}
    @if(Auth::user()->role == 'Admin')
    <div class="mb-4">
        <h5 class="text-muted mb-3"><i class="fas fa-satellite-dish me-2"></i>Monitoring Station (Realtime)</h5>
        <div class="row">
            @foreach($allStations as $st)
            @php
            $count = $stationStats[$st->code] ?? 0;
            $borderColor = ($count > 0) ? 'border-left-active' : 'border-left-empty';
            @endphp
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="station-card p-3 {{ $borderColor }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="station-code">{{ $st->code }}</div>
                            <div class="station-name">{{ $st->name }}</div>
                        </div>
                        <div class="text-end">
                            <div class="station-count">{{ $count }}</div>
                            <small class="text-muted">Staff</small>
                        </div>
                    </div>
                    <hr class="my-2" style="opacity: 0.1">`
                    <div class="d-grid gap-2">
                        @if($count > 0)
                        <a href="{{ route('staff.index', ['station' => $st->code]) }}"
                            class="btn btn-sm btn-outline-primary"
                            style="font-size: 0.75rem;">
                            <i class="fas fa-users me-1"></i> Lihat Data
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Tombol Buka Station Baru --}}
            <div class="col-md-3 col-sm-6 mb-3">
                <a href="{{ route('stations.create') }}" class="station-card d-flex align-items-center justify-content-center text-decoration-none" style="background: #f8fafc; border: 2px dashed #cbd5e0; cursor: pointer;">
                    <div class="text-center text-muted">
                        <i class="fas fa-plus-circle fa-2x mb-2"></i>
                        <div style="font-weight: 600">Buka Station Baru</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- =================================================================== --}}
    {{-- PANEL STATISTIK UTAMA --}}
    {{-- =================================================================== --}}
    <div class="row mb-4">
        <div class="col-md-4 col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    {{-- Ubah Label agar Dinamis (Ikuti Filter) --}}
                    <i class="fas fa-users me-2"></i> Total Staff
                    {{ isset($selectedStation) && $selectedStation !== 'All' ? Str::upper($selectedStation) : 'GLOBAL' }}
                </div>
                <div class="panel-body">
                    <p><strong>{{ $userCount ?? 0 }}</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <i class="fas fa-user-check me-2"></i> Staff Bertugas
                </div>
                <div class="panel-body">
                    <p><strong>{{ $workingManpowers ?? 0 }}</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fas fa-plane-departure me-2"></i> Penerbangan Selesai Hari Ini
                </div>
                <div class="panel-body">
                    <p><strong>{{ $totalFlightPerDay ?? 0 }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Layout Chart (Atas) --}}
    <div class="top-charts-container">
        <div class="card chart-card-custom">
            <div class="card-header chart-card-header-custom">
                Performa Pengerjaan Pesawat (7 Hari Terakhir)
            </div>
            <div class="card-body">
                <div class="chart-canvas-wrapper">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
        <div class="card chart-card-custom">
            <div class="card-header chart-card-header-custom">
                Distribusi Staff by Role
            </div>
            <div class="card-body">
                <div class="chart-canvas-wrapper">
                    <canvas id="doughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Layout Chart (Bawah) --}}
    <div class="bottom-charts-container">
        <div class="card chart-card-custom">
            <div class="card-header chart-card-header-custom">
                Data Absensi Staff (7 Hari Terakhir)
            </div>
            <div class="card-body">
                <div class="chart-canvas-wrapper">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
        <div class="card info-card">
            <div class="card-body">
                <h3>Statistik Staff</h3>
                <div class="info-item">
                    <i class="fas fa-file-signature"></i>
                    <span class="label">Total Staff Kontrak:</span>
                    <span class="value">{{ $totalContractStaff ?? 0 }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-id-card"></i>
                    <span class="label">Total Staff PAS Aktif:</span>
                    <span class="value">{{ $totalPasStaff ?? 0 }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-user"></i>
                    <span class="label">Total Kehadiran Hari Ini:</span>
                    <span class="value">{{ $presentToday ?? 0 }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-user-times"></i>
                    <span class="label">Tidak Hadir Hari Ini:</span>
                    <span class="value">{{ $totalAbsent ?? 0 }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-percentage"></i>
                    <span class="label">Persentase Kehadiran Hari Ini:</span>
                    <span class="value">{{ $attendancePercentage ?? 0 }}%</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data Penerbangan Hari Ini --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-list-ul me-2"></i> Data Penerbangan Hari Ini
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover kontrak-table">
                            <thead>
                                <tr>
                                    <th>Airline</th>
                                    <th>Flight Number</th>
                                    <th>Registrasi</th>
                                    <th>Tipe</th>
                                    <th>Kedatangan</th>
                                    <th>Hitung Mundur</th>
                                    <th>Dibuat Pada</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($flights as $flight)
                                <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#viewFlightModal{{ $flight->id }}">
                                    <td>{{ $flight->airline }}</td>
                                    <td>{{ $flight->flight_number }}</td>
                                    <td>{{ $flight->registasi }}</td>
                                    <td>{{ $flight->type }}</td>
                                    <td>{{ $flight->arrival }}</td>
                                    <td><span class="countdown" data-time="{{ $flight->time_count }}"></span></td>
                                    <td>{{ $flight->created_at->format('d M Y, H:i') }}</td>
                                    <td class="no-click">
                                        @if ($flight->status)
                                        <span class="badge bg-label-success">Selesai</span>
                                        @else
                                        <span class="badge bg-label-warning">Dalam Proses</span>
                                        @endif
                                    </td>
                                    <td class="no-click">
                                        @if ($flight->status)
                                        <span class="badge bg-label-secondary">Done</span>
                                        @else
                                        @if (in_array(Auth::user()->role, ['Ass Leader', 'Leader']))
                                        <form action="{{ route('flights.update', $flight->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bx bx-check-circle me-1"></i> Mark as Done
                                            </button>
                                        </form>
                                        @else
                                        <span class="badge bg-label-warning">In Progress</span>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @include('modal.view_flight', ['flight' => $flight])
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data penerbangan untuk hari ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modal.add_flight')
@include('modal.flight')
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // DATA YANG DIKIRIM DARI CONTROLLER AKAN OTOMATIS BERUBAH SESUAI FILTER
        const lineChartLabels = @json($lineChartLabels ?? []);
        const lineChartData = @json($lineChartData ?? []);
        const doughnutChartLabels = @json($doughnutChartLabels ?? []);
        const doughnutChartData = @json($doughnutChartData ?? []);
        const barChartLabels = @json($barChartLabels ?? []);
        const sickData = @json($sickData ?? []);
        const leaveData = @json($leaveData ?? []);

        const ctxLine = document.getElementById('lineChart');
        if (ctxLine) {
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: lineChartLabels,
                    datasets: [{
                        label: 'Jumlah Penerbangan',
                        data: lineChartData,
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 10
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            }
                        }
                    }
                }
            });
        }

        const ctxDoughnut = document.getElementById('doughnutChart');
        if (ctxDoughnut) {
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: doughnutChartLabels,
                    datasets: [{
                        data: doughnutChartData,
                        backgroundColor: ['#667eea', '#48bb78', '#f59e0b', '#e53e3e', '#9f7aea', '#ed8936', '#38b2ac'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }

        const ctxBar = document.getElementById('barChart');
        if (ctxBar) {
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: barChartLabels,
                    datasets: [{
                        label: 'Sakit',
                        data: sickData,
                        backgroundColor: '#f59e0b',
                        stack: 'Absen',
                        borderRadius: 4
                    }, {
                        label: 'Cuti',
                        data: leaveData,
                        backgroundColor: '#e53e3e',
                        stack: 'Absen',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });
        }

        document.querySelectorAll('.countdown').forEach(function(el) {
            const countDownDate = new Date(el.getAttribute('data-time').replace(' ', 'T')).getTime();
            if (isNaN(countDownDate)) return;
            const interval = setInterval(function() {
                const distance = countDownDate - new Date().getTime();
                if (distance >= 0) {
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    el.innerHTML = `${days}h ${hours}j ${minutes}m ${seconds}d`;
                } else {
                    clearInterval(interval);
                    el.innerHTML = "<span class='text-danger'>WAKTU HABIS</span>";
                }
            }, 1000);
        });

        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', (e) => {
                if (!e.target.closest('.no-click') && !e.target.closest('button') && !e.target.closest('a') && !e.target.closest('input')) {
                    const modalId = row.getAttribute('data-bs-target');
                    if (modalId) {
                        const modal = new bootstrap.Modal(document.querySelector(modalId));
                        modal.show();
                    }
                }
            });
        });
    });
</script>
@endsection
