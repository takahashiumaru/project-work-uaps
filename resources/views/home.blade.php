@extends('app')

@section('styles')
<style>
    /* Styling Anda sudah baik, tidak ada perubahan yang diperlukan. */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        white-space: nowrap;
        padding: 8px;
        text-align: left;
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
    }

    .info-item i {
        margin-right: 12px;
        font-size: 1.5rem;
        color: #10b981;
    }

    .info-item .label {
        font-weight: 600;
        color: #374151;
        flex-basis: 60%;
    }

    .info-item .value {
        font-weight: 700;
        color: #2563eb;
        text-align: right;
        flex-basis: 40%;
    }
</style>
@endsection

@section('content')
{{-- Panel Atas --}}
<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="fas fa-users"></i> Total Staff {{ Str::upper(Auth::user()->station) }}</div>
            <div class="panel-body">
                <p><strong>{{ $userCount ?? 0 }}</strong></p>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading"><i class="fas fa-user-check"></i> Staff Bertugas</div>
            <div class="panel-body">
                <p><strong>{{ $workingManpowers ?? 0 }}</strong></p>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="fas fa-plane-departure"></i> Penerbangan Selesai Hari Ini</div>
            <div class="panel-body">
                <p><strong>{{ $totalFlightPerDay ?? 0 }}</strong></p>
            </div>
        </div>
    </div>
</div>

{{-- Layout Chart (Atas) --}}
<div class="top-charts-container">
    <section class="chart-card-custom">
        <header class="chart-card-header-custom">Performa Pengerjaan Pesawat (7 Hari Terakhir)</header>
        <div class="chart-canvas-wrapper">
            <canvas id="lineChart"></canvas>
        </div>
    </section>
    <section class="chart-card-custom">
        <header class="chart-card-header-custom">Distribusi Staff by Role</header>
        <div class="chart-canvas-wrapper">
            <canvas id="doughnutChart"></canvas>
        </div>
    </section>
</div>

{{-- Layout Chart (Bawah) --}}
<div class="bottom-charts-container">
    <section class="chart-card-custom">
        <header class="chart-card-header-custom">Data Absensi Staff (7 Hari Terakhir)</header>
        <div class="chart-canvas-wrapper">
            <canvas id="barChart"></canvas>
        </div>
    </section>
    <section class="info-card">
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
    </section>
</div>

{{-- Tombol Add Flight (jika diperlukan) --}}
<div class="text-right" style="margin-bottom: 10px;">
    @if (in_array(Auth::user()->role, ['Admin','Ass Leader','Leader']))
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFlightModal">
        <i class="fa fa-plus-circle"></i> Tambah Penerbangan
    </button>
    @endif
</div>

{{-- Tabel Data Penerbangan Hari Ini --}}
<div class="table-responsive">
    <table class="table table-bordered table-striped">
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
                <th>Done</th>
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
                <td>
                    @if($flight->status)
                    <span class="text-success">Selesai</span>
                    @else
                    <span class="text-warning">Dalam Proses</span>
                    @endif
                </td>
                <td class="no-click">
                    @if($flight->status)
                    Done
                    @else
                    @if (in_array(Auth::user()->role, ['Ass Leader', 'Leader']))
                    <form action="{{ route('flights.update', $flight->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> Mark as Done</button>
                    </form>
                    @else
                    <span class="text-warning">In Progress</span>
                    @endif
                    @endif
                </td>
            </tr>
            {{-- Pastikan Anda memiliki modal view_flight --}}
            @include('modal.view_flight', ['flight' => $flight])
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data penerbangan untuk hari ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pastikan Anda memiliki modal add_flight dan flight --}}
@include('modal.add_flight')
@include('modal.flight')
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // 1. Ambil data dinamis yang dikirim dari Controller
        const lineChartLabels = @json($lineChartLabels ?? []);
        const lineChartData = @json($lineChartData ?? []);

        const doughnutChartLabels = @json($doughnutChartLabels ?? []);
        const doughnutChartData = @json($doughnutChartData ?? []);

        const barChartLabels = @json($barChartLabels ?? []);
        const sickData = @json($sickData ?? []);
        const leaveData = @json($leaveData ?? []);

        // 2. Inisialisasi Chart
        // Line Chart: Performa Pengerjaan Pesawat
        const ctxLine = document.getElementById('lineChart');
        if (ctxLine) {
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: lineChartLabels,
                    datasets: [{
                        label: 'Jumlah Penerbangan',
                        data: lineChartData,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        fill: true,
                        tension: 0.4
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
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        // Doughnut Chart: Distribusi Staff
        const ctxDoughnut = document.getElementById('doughnutChart');
        if (ctxDoughnut) {
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: doughnutChartLabels,
                    datasets: [{
                        data: doughnutChartData,
                        backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#6366f1'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Bar Chart: Kehadiran Staff
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
                            stack: 'Absen'
                        },
                        {
                            label: 'Cuti',
                            data: leaveData,
                            backgroundColor: '#ef4444',
                            stack: 'Absen'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5
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

        // 3. Countdown Timer
        document.querySelectorAll('.countdown').forEach(function(el) {
            const countDownDate = new Date(el.getAttribute('data-time').replace(' ', 'T')).getTime();
            if (isNaN(countDownDate)) return; // Hindari error jika waktu tidak valid

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
                    el.innerHTML = "WAKTU HABIS";
                }
            }, 1000);
        });
    });
</script>
@endsection
