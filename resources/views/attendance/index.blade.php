@extends('layout.admin')

@section('title', 'Modul Absensi')

@section('styles')
<style>
    .attendance-card {
        background: #fff;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.375rem rgba(161, 172, 184, 0.12);
        border: 1px solid #d9dee3;
        margin-bottom: 1.5rem;
    }
    
    .attendance-header {
        background: linear-gradient(135deg, #667eea 0%, #4180c3 100%);
        color: white;
        padding: 1.25rem 1.5rem;
        border-radius: 0.75rem 0.75rem 0 0;
    }
    
    .attendance-body {
        padding: 1.5rem;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .badge-present {
        background: #d1fae5;
        color: #065f46;
    }
    
    .badge-absent {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .badge-in-progress {
        background: #fef3c7;
        color: #92400e;
    }
    
    .time-display {
        font-family: 'Courier New', monospace;
        font-size: 1.25rem;
        font-weight: 600;
        color: #566a7f;
        background: #f8f9fa;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        text-align: center;
        margin: 0.5rem 0;
    }
    
    .btn-attendance {
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-checkin {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
    }
    
    .btn-checkout {
        background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
        color: white;
    }
    
    .btn-checkin:hover, .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        color: white;
    }
    
    .btn-disabled {
        background: #e9ecef;
        color: #6c757d;
        cursor: not-allowed;
    }
    
    .attendance-info {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .info-item {
        text-align: center;
    }
    
    .info-label {
        font-size: 0.875rem;
        color: #697a8d;
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        font-size: 1.25rem;
        font-weight: 600;
        color: #566a7f;
    }
    
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .btn-attendance {
            width: 100%;
            justify-content: center;
        }
        
        .time-display {
            font-size: 1.1rem;
        }
    }
    
    .current-time {
        background: linear-gradient(135deg, #667eea 0%, #4180c3 100%);
        color: white;
        padding: 1rem;
        border-radius: 0.5rem;
        text-align: center;
        margin-bottom: 1rem;
        font-family: 'Courier New', monospace;
        font-size: 1.1rem;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4">
                    <span class="text-muted fw-light">Attendance /</span> Today's Presence
                </h4>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">
                        <i class="bx bx-calendar me-1"></i>
                        {{ \Carbon\Carbon::now()->format('d M Y') }}
                    </span>
                    <a href="{{ route('attendance.history') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-history me-1"></i> History
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Time Display -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="current-time">
                <i class="bx bx-time-five me-2"></i>
                <span id="liveClock">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Attendance Status Card -->
    <div class="row">
        <div class="col-12">
            <div class="attendance-card">
                <div class="attendance-header">
                    <h5 class="mb-0" style="color: white;">
                        <i class="bx bx-user-check me-2" style="color: white;"></i>Today's Attendance Status
                    </h5>
                </div>
                <div class="attendance-body">
                    <!-- Attendance Information -->
                    <div class="attendance-info">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Station</div>
                                <div class="info-value">{{ $todayAttendance ? ($user->station ?? '-') : '-' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Status</div>
                                <div class="info-value">
                                    @if(!$todayAttendance)
                                        <span class="status-badge badge-absent">Belum Check In</span>
                                    @elseif($todayAttendance && $todayAttendance->check_in_time && !$todayAttendance->check_out_time)
                                        <span class="status-badge badge-in-progress">Sedang Bekerja</span>
                                    @elseif($todayAttendance && $todayAttendance->check_in_time && $todayAttendance->check_out_time)
                                        <span class="status-badge badge-present">Selesai Bekerja</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Check In</div>
                                <div class="info-value">
                                    {{ $todayAttendance && $todayAttendance->check_in_time
                                        ? \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i')
                                        : '-' }}
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Check Out</div>
                                <div class="info-value">
                                    {{ $todayAttendance && $todayAttendance->check_out_time
                                        ? \Carbon\Carbon::parse($todayAttendance->check_out_time)->format('H:i')
                                        : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center">
                        @if(!$todayAttendance)
                            {{-- Belum ada absen sama sekali --}}
                            <a href="{{ route('attendance.camera', ['type' => 'in']) }}" 
                               class="btn-attendance btn-checkin">
                                <i class="bx bx-log-in"></i> Check In
                            </a>
                        @elseif($todayAttendance && $todayAttendance->check_in_time && !$todayAttendance->check_out_time)
                            {{-- Sudah Check In, belum Check Out --}}
                            <a href="{{ route('attendance.camera', ['type' => 'out']) }}" 
                               class="btn-attendance btn-checkout">
                                <i class="bx bx-log-out"></i> Check Out
                            </a>
                        @elseif($todayAttendance && $todayAttendance->check_in_time && $todayAttendance->check_out_time)
                            {{-- Sudah Check In dan Check Out (selesai) --}}
                            <button class="btn-attendance btn-disabled" disabled>
                                <i class="bx bx-check-circle"></i> Completed
                            </button>
                        @endif
                    </div>

                    <!-- Additional Information -->
                    <div class="mt-4 text-center">
                        <small class="text-muted">
                            <i class="bx bx-info-circle me-1"></i>
                            @if(!$todayAttendance)
                                Silakan lakukan Check In untuk memulai hari kerja Anda.
                            @elseif($todayAttendance && $todayAttendance->check_in_time && !$todayAttendance->check_out_time)
                                Anda telah Check In pada {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }}. Jangan lupa Check Out setelah selesai bekerja.
                            @elseif($todayAttendance && $todayAttendance->check_in_time && $todayAttendance->check_out_time)
                                Anda telah menyelesaikan hari kerja pada {{ \Carbon\Carbon::parse($todayAttendance->check_out_time)->format('H:i') }}. Terima kasih!
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Card -->
    <!-- <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-stats me-2"></i>Quick Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <div class="info-label">Total Hari Kerja</div>
                                <div class="info-value text-primary">-</div>
                                <small class="text-muted">Bulan Ini</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <div class="info-label">Tepat Waktu</div>
                                <div class="info-value text-success">-</div>
                                <small class="text-muted">Rate</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <div class="info-label">Terlambat</div>
                                <div class="info-value text-warning">-</div>
                                <small class="text-muted">Bulan Ini</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Information Card -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bx bx-info-circle me-2"></i> Informasi Absensi
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    <strong>Check In</strong> dilakukan saat mulai bekerja
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-time text-primary me-2"></i>
                                    <strong>Check Out</strong> dilakukan setelah selesai bekerja
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bx bx-camera text-info me-2"></i>
                                    Absensi menggunakan <strong>foto selfie</strong>
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-history text-warning me-2"></i>
                                    Lihat riwayat di menu <strong>History</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Live Clock
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
            document.getElementById('liveClock').textContent = timeString;
        }

        // Update immediately and every second
        updateClock();
        setInterval(updateClock, 1000);

        // Add animation to action buttons
        const actionButtons = document.querySelectorAll('.btn-attendance');
        actionButtons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                if (!this.disabled) {
                    this.style.transform = 'translateY(-2px) scale(1.02)';
                }
            });
            
            btn.addEventListener('mouseleave', function() {
                if (!this.disabled) {
                    this.style.transform = 'translateY(0) scale(1)';
                }
            });
        });

        // Show notification if there's any message
        @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
        @endif

        @if(session('error'))
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            timer: 3000,
            showConfirmButton: false
        });
        @endif
    });
</script>
@if(session('success') || session('error'))
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endif
@endsection