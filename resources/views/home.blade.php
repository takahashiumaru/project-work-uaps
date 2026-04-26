@extends('layout.admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4F46E5;
            --secondary-color: #818CF8;
            --success-color: #10B981;
            --info-color: #3B82F6;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --bg-light: #F3F4F6;
            --text-main: #1F2937;
            --text-muted: #6B7280;
        }

        body {
            background-color: #F9FAFB;
        }

        /* --- MODERN CARDS --- */
        .modern-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(229, 231, 235, 0.5);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
        }

        .modern-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        /* --- STAT CARDS (GRADIENT) --- */
        .stat-card {
            border-radius: 16px;
            border: none;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stat-card .card-body {
            padding: 20px;
            position: relative;
            z-index: 2;
        }

        .stat-card-primary {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
        }

        .stat-card-success {
            background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
        }

        .stat-card-info {
            background: linear-gradient(135deg, #3B82F6 0%, #60A5FA 100%);
        }

        .stat-card .stat-title {
            font-size: 0.85rem;
            font-weight: 600;
            opacity: 0.9;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0;
            line-height: 1;
        }

        .stat-card .stat-icon {
            position: absolute;
            right: 0px;
            bottom: -15px;
            font-size: 4rem;
            opacity: 0.15;
            transform: rotate(-15deg);
            transition: transform 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: rotate(0deg) scale(1.1);
        }

        /* --- STATION CARDS --- */
        .station-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #E5E7EB;
            padding: 16px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .station-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            border-color: var(--primary-color);
        }

        .border-left-active {
            border-left: 4px solid var(--success-color) !important;
        }

        .border-left-empty {
            border-left: 4px solid var(--danger-color) !important;
        }

        .station-code {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .station-name {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .station-count {
            font-size: 1.4rem;
            font-weight: 800;
            color: #4A7EBB; /* Tetap biru logo untuk angka aktif di card putih */
            line-height: 1;
        }

        /* --- CHARTS & INFO LAYOUT --- */
        .top-charts-container,
        .bottom-charts-container {
            display: grid;
            gap: 24px;
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

        .chart-header {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-main);
            padding: 16px 20px 0;
            border-bottom: none;
            background: transparent;
        }

        .chart-canvas-wrapper {
            position: relative;
            height: 300px;
            padding: 0 10px;
        }

        /* --- INFO LIST --- */
        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px dashed #E5E7EB;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon-wrapper {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 1rem;
        }

        .icon-blue {
            background: #EFF6FF;
            color: #3B82F6;
        }

        .icon-green {
            background: #ECFDF5;
            color: #10B981;
        }

        .icon-yellow {
            background: #FFFBEB;
            color: #F59E0B;
        }

        .icon-red {
            background: #FEF2F2;
            color: #EF4444;
        }

        .icon-purple {
            background: #F5F3FF;
            color: #8B5CF6;
        }

        .info-label {
            flex: 1;
            font-weight: 600;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .info-value {
            font-weight: 800;
            color: var(--text-main);
            font-size: 1rem;
        }

        /* --- TABLE STYLES --- */
        .table-custom {
            margin-bottom: 0;
        }

        .table-custom thead th {
            background-color: #F9FAFB;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #E5E7EB;
            padding: 12px 16px;
        }

        .table-custom tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #F3F4F6;
            color: var(--text-main);
            font-weight: 500;
            font-size: 0.85rem;
        }

        .clickable-row {
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .clickable-row:hover {
            background-color: #F9FAFB;
        }

        .countdown {
            font-weight: 700;
            color: var(--danger-color);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }

        .countdown:not(:empty) {
            background: #FEF2F2;
            border: 1px solid rgba(239, 68, 68, 0.1);
        }

        /* --- BUTTONS & INPUTS --- */
        .btn-primary-custom {
            background: #4A7EBB; /* Selalu biru logo */
            border: none;
            border-radius: 8px;
            padding: 0 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 42px;
            /* Fix height agar sejajar dengan select box */
            white-space: nowrap;
        }

        /* KUSTOMISASI MOBILE RESPONSIVE */
        @media (max-width: 767.98px) {
            .dashboard-title {
                font-size: 1.25rem !important;
                line-height: 1.4;
            }

            .action-buttons {
                flex-direction: column;
                align-items: stretch !important;
                gap: 10px !important;
            }

            .action-buttons form,
            .action-buttons .btn-primary-custom {
                width: 100% !important;
            }

            .action-buttons .input-group {
                width: 100% !important;
            }

            .action-buttons select {
                min-width: 0 !important;
                /* Mencegah select box jebol/overflow di layar kecil */
            }
        }

        .btn-primary-custom:hover {
            background: #3A6DAA; /* Biru logo sedikit gelap */
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 126, 187, 0.3);
        }

        .filter-select {
            border-radius: 8px;
            border: 1px solid #E5E7EB;
            padding: 10px 15px;
            font-weight: 600;
            color: var(--text-main);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- HEADER SECTION --}}
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                @php
                    $hour = date('H');
                    $timeGreeting = $hour < 12 ? 'Pagi' : ($hour < 18 ? 'Siang' : 'Malam');
                @endphp
                <h4 class="fw-bold mb-1 text-dark dashboard-title">
                    Hi {{ Auth::user()->fullname }}, Selamat {{ $timeGreeting }} 👋
                </h4>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">
                    Dashboard Overview &bull;
                    <span class="fw-semibold text-primary">
                        {{ isset($selectedStation) && $selectedStation !== 'All' ? 'Station ' . $selectedStation : 'Global' }}
                    </span>
                </p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-flex flex-wrap justify-content-md-end align-items-center gap-3 action-buttons">
                    @if (Auth::user()->role == 'Admin')
                        <form action="{{ url()->current() }}" method="GET" id="stationFilterForm" class="m-0">
                            <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden; height: 42px;">
                                <span class="input-group-text bg-white border-0 text-primary"><i
                                        class="fas fa-filter"></i></span>
                                <select name="station" class="form-select border-0 fw-semibold"
                                    onchange="document.getElementById('stationFilterForm').submit()"
                                    style="cursor: pointer; min-width: 200px;">
                                    <option value="All"
                                        {{ isset($selectedStation) && $selectedStation == 'All' ? 'selected' : '' }}>Semua
                                        Station (Global)</option>
                                    @if (isset($listStations))
                                        @foreach ($listStations as $st)
                                            <option value="{{ $st->code }}"
                                                {{ isset($selectedStation) && $selectedStation == $st->code ? 'selected' : '' }}>
                                                {{ $st->code }} - {{ $st->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </form>
                    @endif

                    @if (in_array(Auth::user()->role, ['Admin', 'SPV Apron', 'SPV Bge']))
                        <button type="button" class="btn btn-primary-custom text-white shadow-sm" data-bs-toggle="modal"
                            data-bs-target="#addFlightModal">
                            <i class="bx bx-plus-circle me-1"></i> Tambah Flight
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- MONITORING STATION WIDGET (KHUSUS ADMIN) --}}
        @if (Auth::user()->role == 'Admin')
            <div class="mb-5">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary rounded p-2 me-2 text-white d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="fas fa-satellite-dish fa-sm"></i>
                    </div>
                    <h6 class="mb-0 fw-bold text-dark">Monitoring Station (Realtime)</h6>
                </div>

                <div class="row g-3">
                    @foreach ($allStations as $st)
                        @php
                            $count = $stationStats[$st->code] ?? 0;
                            $borderColor = $count > 0 ? 'border-left-active' : 'border-left-empty';
                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="station-card {{ $borderColor }} h-100 d-flex flex-column justify-content-between">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <div class="station-code">{{ $st->code }}</div>
                                        <div class="station-name text-truncate" style="max-width: 120px;"
                                            title="{{ $st->name }}">{{ $st->name }}</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="station-count">{{ $count }}</div>
                                        <small class="text-muted fw-semibold">Staff Aktif</small>
                                    </div>
                                </div>
                                @if ($count > 0)
                                    <a href="{{ route('staff.index', ['station' => $st->code]) }}"
                                        class="btn btn-sm btn-light w-100 fw-semibold text-primary border">
                                        <i class="fas fa-users me-1"></i> Lihat Detail
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-light w-100 fw-semibold text-muted border" disabled>
                                        Kosong
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <a href="{{ route('stations.create') }}"
                            class="station-card h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none"
                            style="background: #F8FAFC; border: 2px dashed #CBD5E1;">
                            <div class="icon-blue rounded-circle d-flex align-items-center justify-content-center mb-2"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="fw-bold text-primary" style="font-size: 0.9rem;">Buka Station Baru</div>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- PANEL STATISTIK UTAMA --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card stat-card stat-card-primary shadow-sm">
                    <div class="card-body">
                        <div class="stat-title">Total Staff
                            {{ isset($selectedStation) && $selectedStation !== 'All' ? Str::upper($selectedStation) : 'GLOBAL' }}
                        </div>
                        <div class="stat-value">{{ $userCount ?? 0 }}</div>
                        <i class="fas fa-users stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card stat-card-success shadow-sm">
                    <div class="card-body">
                        <div class="stat-title">Staff Bertugas</div>
                        <div class="stat-value">{{ $workingManpowers ?? 0 }}</div>
                        <i class="fas fa-user-check stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card stat-card-info shadow-sm">
                    <div class="card-body">
                        <div class="stat-title">Penerbangan Selesai</div>
                        <div class="stat-value">{{ $totalFlightPerDay ?? 0 }}</div>
                        <i class="fas fa-plane-departure stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHARTS ATAS --}}
        <div class="top-charts-container">
            <div class="modern-card">
                <div class="card-header chart-header">
                    Performa Pengerjaan Pesawat <span class="text-muted fw-normal fs-6">(7 Hari Terakhir)</span>
                </div>
                <div class="card-body">
                    <div class="chart-canvas-wrapper">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="modern-card">
                <div class="card-header chart-header">
                    Distribusi Staff by Role
                </div>
                <div class="card-body">
                    <div class="chart-canvas-wrapper">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHARTS BAWAH & INFO --}}
        <div class="bottom-charts-container">
            <div class="modern-card">
                <div class="card-header chart-header">
                    Data Absensi Staff <span class="text-muted fw-normal fs-6">(7 Hari Terakhir)</span>
                </div>
                <div class="card-body">
                    <div class="chart-canvas-wrapper">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="modern-card">
                <div class="card-header chart-header mb-2">
                    Statistik Kehadiran Hari Ini
                </div>
                <div class="card-body pt-0">
                    <ul class="info-list">
                        <li class="info-item">
                            <div class="info-icon-wrapper icon-blue"><i class="fas fa-file-signature"></i></div>
                            <span class="info-label">Total Staff Kontrak</span>
                            <span class="info-value">{{ $totalContractStaff ?? 0 }}</span>
                        </li>
                        <li class="info-item">
                            <div class="info-icon-wrapper icon-purple"><i class="fas fa-id-card"></i></div>
                            <span class="info-label">Total Staff PAS Aktif</span>
                            <span class="info-value">{{ $totalPasStaff ?? 0 }}</span>
                        </li>
                        <li class="info-item">
                            <div class="info-icon-wrapper icon-green"><i class="fas fa-user-check"></i></div>
                            <span class="info-label">Kehadiran Hari Ini</span>
                            <span class="info-value">{{ $presentToday ?? 0 }}</span>
                        </li>
                        <li class="info-item">
                            <div class="info-icon-wrapper icon-red"><i class="fas fa-user-times"></i></div>
                            <span class="info-label">Tidak Hadir</span>
                            <span class="info-value">{{ $totalAbsent ?? 0 }}</span>
                        </li>
                        <li class="info-item">
                            <div class="info-icon-wrapper icon-yellow"><i class="fas fa-percentage"></i></div>
                            <span class="info-label">Persentase Kehadiran</span>
                            <span class="info-value">{{ $attendancePercentage ?? 0 }}%</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- TABEL PENERBANGAN --}}
        <div class="row">
            <div class="col-12">
                <div class="modern-card">
                    <div
                        class="card-header chart-header d-flex justify-content-between align-items-center pb-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded p-2 me-2 text-white d-flex align-items-center justify-content-center"
                                style="width: 32px; height: 32px;">
                                <i class="bx bx-list-ul"></i>
                            </div>
                            <h6 class="mb-0 fw-bold text-dark">Data Penerbangan Hari Ini</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Airline</th>
                                    <th>Flight No.</th>
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
                                    <tr class="clickable-row" data-target="#viewFlightModal{{ $flight->id }}">
                                        <td class="fw-bold text-primary">{{ $flight->airline }}</td>
                                        <td><span class="badge bg-label-dark">{{ $flight->flight_number }}</span></td>
                                        <td>{{ $flight->registasi }}</td>
                                        <td>{{ $flight->type }}</td>
                                        <td><i class="bx bx-time-five text-muted me-1"></i>{{ $flight->arrival }}</td>
                                        <td><span class="countdown shadow-sm no-click"
                                                data-time="{{ $flight->time_count }}"></span></td>
                                        <td class="text-muted">{{ $flight->created_at->format('d M Y, H:i') }}</td>
                                        <td class="no-click">
                                            @if ($flight->status)
                                                <span class="badge bg-label-success px-3 py-2 rounded-pill">
                                                    <i class="bx bx-check me-1"></i>Selesai
                                                </span>
                                            @else
                                                <span class="badge bg-label-warning px-3 py-2 rounded-pill">
                                                    <i class="bx bx-loader-alt bx-spin me-1"></i>Proses
                                                </span>
                                            @endif
                                        </td>
                                        <td class="no-click">
                                            @if ($flight->status)
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill">Done</span>
                                            @else
                                                @if (in_array(Auth::user()->role, ['Ass Leader', 'Leader']))
                                                    <form action="{{ route('flights.update', $flight->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
                                                            <i class="bx bx-check-circle me-1"></i> Mark Done
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-label-info px-3 py-2 rounded-pill">In
                                                        Progress</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @include('modal.view_flight', ['flight' => $flight])
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            <i class="bx bx-folder-open fs-1 mb-2 opacity-50"></i>
                                            <p class="mb-0">Tidak ada data penerbangan untuk hari ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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

            // Global Chart Defaults
            Chart.defaults.font.family = "'Public Sans', sans-serif";
            Chart.defaults.color = '#6B7280';

            const ctxLine = document.getElementById('lineChart');
            if (ctxLine) {
                new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: lineChartLabels,
                        datasets: [{
                            label: 'Jumlah Penerbangan',
                            data: lineChartData,
                            borderColor: '#4F46E5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#4F46E5',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
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
                                border: {
                                    display: false
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.04)',
                                    drawBorder: false
                                }
                            },
                            x: {
                                border: {
                                    display: false
                                },
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(31, 41, 55, 0.9)',
                                padding: 12,
                                titleFont: {
                                    size: 13,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                cornerRadius: 8,
                                displayColors: false
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
                            backgroundColor: ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
                                '#F97316', '#06B6D4'
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 12,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    font: {
                                        size: 10
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(31, 41, 55, 0.9)',
                                padding: 12,
                                cornerRadius: 8
                            }
                        },
                        layout: {
                            padding: 10
                        },
                        cutout: '70%'
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
                            backgroundColor: '#F59E0B',
                            stack: 'Absen',
                            borderRadius: 4,
                            barPercentage: 0.6
                        }, {
                            label: 'Cuti',
                            data: leaveData,
                            backgroundColor: '#EF4444',
                            stack: 'Absen',
                            borderRadius: 4,
                            barPercentage: 0.6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                stacked: true,
                                border: {
                                    display: false
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 5
                                },
                                border: {
                                    display: false
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.04)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                align: 'end',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 8
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(31, 41, 55, 0.9)',
                                padding: 12,
                                cornerRadius: 8
                            }
                        }
                    }
                });
            }

            document.querySelectorAll('.countdown').forEach(function(el) {
                let timeData = el.getAttribute('data-time');
                if (!timeData) return;
                timeData = timeData.trim();

                let targetDate;
                
                try {
                    if (timeData.length <= 8) {
                        // Format: HH:mm:ss
                        const parts = timeData.split(':');
                        targetDate = new Date();
                        targetDate.setHours(parseInt(parts[0]), parseInt(parts[1]), parseInt(parts[2] || 0), 0);
                    } else {
                        // Format: YYYY-MM-DD HH:mm:ss atau YYYY-MM-DDTHH:mm:ss
                        const dateTimeParts = timeData.split(/[ T]/);
                        const dateParts = dateTimeParts[0].split(/[-/]/);
                        const timeParts = dateTimeParts[1].split(':');
                        
                        // monthIndex di JS dimulai dari 0
                        targetDate = new Date(
                            parseInt(dateParts[0]),
                            parseInt(dateParts[1]) - 1,
                            parseInt(dateParts[2]),
                            parseInt(timeParts[0]),
                            parseInt(timeParts[1]),
                            parseInt(timeParts[2] || 0)
                        );
                    }
                } catch (e) {
                    console.error('Failed to parse date:', timeData);
                    return;
                }

                const countDownDate = targetDate.getTime();
                if (isNaN(countDownDate)) return;

                const updateTimer = function() {
                    const now = new Date().getTime();
                    const distance = countDownDate - now;
                    
                    if (distance >= 0) {
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        let timeStr = '';
                        if (days > 0) timeStr += `${days}h `;
                        
                        const h = String(hours).padStart(2, '0');
                        const m = String(minutes).padStart(2, '0');
                        const s = String(seconds).padStart(2, '0');
                        
                        timeStr += `${h}j ${m}m ${s}d`;
                        el.innerHTML = timeStr;
                        return true;
                    } else {
                        el.innerHTML =
                            "<span class='text-danger fw-bold'><i class='bx bx-error-circle me-1'></i>WAKTU HABIS</span>";
                        el.style.background = 'transparent';
                        el.style.padding = '0';
                        return false;
                    }
                };

                if (updateTimer()) {
                    const interval = setInterval(function() {
                        if (!updateTimer()) clearInterval(interval);
                    }, 1000);
                }
            });

            document.querySelectorAll('.clickable-row').forEach(row => {
                row.addEventListener('click', (e) => {
                    if (!e.target.closest('.no-click') && !e.target.closest('button') && !e.target
                        .closest('a') && !e.target.closest('input')) {
                        const modalId = row.getAttribute('data-target');
                        if (modalId) {
                            const modalElement = document.querySelector(modalId);
                            if (modalElement) {
                                const modal = new bootstrap.Modal(modalElement);
                                modal.show();
                            }
                        }
                    }
                });
            });

            // Animasi Counter 0.6 detik
            function animateValue(obj, start, end, duration) {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    obj.innerHTML = Math.floor(progress * (end - start) + start);
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    } else {
                        obj.innerHTML = end; // Ensure exact final value
                    }
                };
                window.requestAnimationFrame(step);
            }

            document.querySelectorAll('.station-count, .stat-value').forEach(el => {
                const targetText = el.innerText.trim();
                const targetValue = parseInt(targetText.replace(/\D/g, ''), 10);
                
                if (!isNaN(targetValue) && targetValue > 0) {
                    el.innerText = '0';
                    animateValue(el, 0, targetValue, 600); // 600ms = 0.6 seconds
                }
            });
        });
    </script>
@endsection
