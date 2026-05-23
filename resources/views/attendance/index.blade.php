@extends('layout.admin')

@section('title', 'Modul Absensi')

@section('styles')
<style>
    .attendance-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid #f3f4f6;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .attendance-header {
        background: #ffffff;
        padding: 1.5rem;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .attendance-body {
        padding: 1.5rem;
    }
    
    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 9999px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .badge-present { background-color: #d1fae5; color: #065f46; }
    .badge-absent { background-color: #fee2e2; color: #991b1b; }
    .badge-in-progress { background-color: #fef3c7; color: #92400e; }
    
    .btn-attendance {
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    
    .btn-checkin {
        background: linear-gradient(135deg, #2f80ed 0%, #2368c8 100%);
        color: white;
        box-shadow: 0 12px 24px rgba(47, 128, 237, 0.2);
    }
    .btn-checkout { background-color: #ef4444; color: white; }
    
    .btn-checkin:hover {
        background: linear-gradient(135deg, #2368c8 0%, #174ea6 100%);
        transform: translateY(-1px);
        box-shadow: 0 14px 26px rgba(47, 128, 237, 0.26);
        color: #ffffff;
    }
    .btn-checkout:hover { background-color: #dc2626; transform: translateY(-1px); box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.2); }
    
    .attendance-info-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1.5rem;
        background: #f9fafb;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .info-item { text-align: center; }
    .info-label { font-size: 0.75rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; font-weight: 600; }
    .info-value { font-size: 1.125rem; font-weight: 700; color: #111827; }
    
    .current-time-banner {
        background: linear-gradient(135deg, #2f80ed 0%, #2368c8 58%, #174ea6 100%);
        color: white;
        padding: 1.25rem;
        border-radius: 0.75rem;
        text-align: center;
        margin-bottom: 1.5rem;
        font-family: 'Inter', sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        box-shadow: 0 18px 34px rgba(47, 128, 237, 0.2);
    }

    .info-section {
        background: #ffffff;
        border: 1px solid #f3f4f6;
        border-radius: 1rem;
        padding: 1.5rem;
    }

    html.aps-dark .attendance-card,
    html.aps-dark .info-section {
        background: #111c31 !important;
        border-color: #24324a !important;
        box-shadow: 0 18px 48px rgba(0, 0, 0, 0.24) !important;
    }

    html.aps-dark .attendance-header {
        background: #111c31 !important;
        border-color: #24324a !important;
    }

    html.aps-dark .attendance-info-container {
        background: #101a2c !important;
        border: 1px solid #24324a;
    }

    html.aps-dark .info-label {
        color: #8fa1b8 !important;
    }

    html.aps-dark .info-value,
    html.aps-dark .info-section h6,
    html.aps-dark .attendance-header h5 {
        color: #e6edf7 !important;
    }

    html.aps-dark .current-time-banner {
        background: linear-gradient(135deg, #13213a 0%, #172b4d 100%) !important;
        border: 1px solid rgba(47, 128, 237, 0.26);
        box-shadow: 0 18px 44px rgba(0, 0, 0, 0.22);
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1">
                <h4 class="fw-bold pt-3 pb-1 mb-0">
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

    <!-- Current Time Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="current-time-banner">
                <i class="bx bx-time-five"></i>
                <span id="liveClock">00:00:00</span>
            </div>
        </div>
    </div>

    <!-- Attendance Card -->
    <div class="row">
        <div class="col-12">
            <div class="attendance-card">
                <div class="attendance-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-shrink-0 bg-label-primary p-2 rounded">
                            <i class="bx bx-user-check fs-3"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Attendance Status</h5>
                            <p class="text-muted mb-0 small">Real-time status for {{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="attendance-body">
                    <!-- Status Container -->
                    <div class="attendance-info-container">
                        <div class="info-item">
                            <div class="info-label">Station</div>
                            <div class="info-value">{{ $todayAttendance ? ($user->station ?? '-') : '-' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Current Status</div>
                            <div class="info-value">
                                @if(!$todayAttendance)
                                    <span class="status-badge badge-absent">Not Clocked In</span>
                                @elseif($todayAttendance && $todayAttendance->check_in_time && !$todayAttendance->check_out_time)
                                    <span class="status-badge badge-in-progress">On Duty</span>
                                @elseif($todayAttendance && $todayAttendance->check_in_time && $todayAttendance->check_out_time)
                                    <span class="status-badge badge-present">Shift Completed</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Absen In</div>
                            <div class="info-value">
                                @if($todayAttendance && $todayAttendance->check_in_time)
                                    {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }}
                                @else
                                    <span class="text-muted">--:--</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Absen Out</div>
                            <div class="info-value">
                                @if($todayAttendance && $todayAttendance->check_out_time)
                                    {{ \Carbon\Carbon::parse($todayAttendance->check_out_time)->format('H:i') }}
                                @else
                                    <span class="text-muted">--:--</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center py-3">
                        @if(!$todayAttendance)
                            <a href="{{ route('attendance.camera', ['type' => 'in']) }}" 
                               class="btn-attendance btn-checkin">
                                <i class="bx bx-log-in"></i> Absen In Sekarang
                            </a>
                        @elseif($todayAttendance && $todayAttendance->check_in_time && !$todayAttendance->check_out_time)
                            <a href="{{ route('attendance.camera', ['type' => 'out']) }}" 
                               class="btn-attendance btn-checkout">
                                <i class="bx bx-log-out"></i> Absen Out Sekarang
                            </a>
                        @elseif($todayAttendance && $todayAttendance->check_in_time && $todayAttendance->check_out_time)
                            <div class="bg-light p-3 rounded-pill d-inline-flex align-items-center gap-2 px-4 border">
                                <i class="bx bx-check-double text-success fs-4"></i>
                                <span class="fw-bold text-success">Today's work is finished</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Instruction Cards -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="info-section">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bx bx-info-circle text-primary fs-4"></i>
                    <h6 class="mb-0 fw-bold">Attendance Guidelines</h6>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex gap-3">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-check-circle"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Absen In</h6>
                                <p class="mb-0 small text-muted">Lakukan absensi saat mulai shift.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex gap-3">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-time"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Absen Out</h6>
                                <p class="mb-0 small text-muted">Lakukan absensi saat shift selesai.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex gap-3">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-camera"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Face Verification</h6>
                                <p class="mb-0 small text-muted">Selfie required for authentication.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex gap-3">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-history"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Work History</h6>
                                <p class="mb-0 small text-muted">Track your records in history.</p>
                            </div>
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
