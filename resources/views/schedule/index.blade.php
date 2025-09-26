@extends('layout.admin')

@section('title', 'Data Schedule')

@section('styles')
<style>
    .calendar-container {
        background: #fff;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.375rem rgba(161, 172, 184, 0.12);
        border: 1px solid #d9dee3;
        padding: 1.5rem;
    }

    .calendar-header {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.5rem;
        margin-bottom: 1rem;
        text-align: center;
    }

    .day-name {
        font-weight: 600;
        color: #566a7f;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 0.5rem;
        font-size: 0.875rem;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.5rem;
    }

    .calendar-day {
        min-height: 120px;
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        padding: 0.75rem;
        background: #fff;
        transition: all 0.2s ease;
    }

    .calendar-day:hover {
        box-shadow: 0 2px 8px rgba(161, 172, 184, 0.15);
        transform: translateY(-1px);
    }

    .calendar-day.inactive {
        background: #f8f9fa;
        border-color: #e9ecef;
        color: #a0aec0;
    }

    .calendar-day.has-schedule {
        background: linear-gradient(135deg, #f0f7ff 0%, #e6f2ff 100%);
        border-color: #667eea;
    }

    .date-number {
        font-weight: 600;
        color: #566a7f;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .schedule-info {
        font-size: 0.75rem;
        line-height: 1.3;
    }

    .shift-id {
        font-weight: 600;
        color: #667eea;
    }

    .shift-time {
        color: #697a8d;
        font-size: 0.7rem;
    }

    .no-schedule {
        color: #a0aec0;
        font-style: italic;
        font-size: 0.75rem;
    }

    .month-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.5rem;
    }

    .month-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #566a7f;
        margin: 0;
    }

    .nav-btn {
        background: #667eea;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .nav-btn:hover {
        background: #5a6fd8;
        transform: translateY(-1px);
    }

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: #fff;
        border-radius: 0.75rem;
        padding: 1.5rem;
        border: 1px solid #d9dee3;
        text-align: center;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 600;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #697a8d;
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .calendar-grid {
            grid-template-columns: repeat(1, 1fr);
        }
        
        .calendar-day {
            min-height: 80px;
        }
        
        .stats-cards {
            grid-template-columns: 1fr;
        }
        
        .month-navigation {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .calendar-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .today {
        background: linear-gradient(135deg, #667eea 0%, #4180c3 100%) !important;
        color: white !important;
    }

    .today .date-number {
        color: white !important;
    }

    .today .shift-id {
        color: white !important;
    }

    .today .shift-time {
        color: rgba(255, 255, 255, 0.9) !important;
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
                    <span class="text-muted fw-light">Schedule /</span> Data Schedule
                </h4>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">
                        <i class="bx bx-calendar me-1"></i>
                        {{ Carbon\Carbon::now()->format('F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number">{{ $schedules->count() }}</div>
                <div class="stat-label">Total Jadwal</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $schedules->unique('date')->count() }}</div>
                <div class="stat-label">Hari Terjadwal</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $schedules->groupBy('shift_id')->count() }}</div>
                <div class="stat-label">Shift Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $schedules->where('is_active', true)->count() }}</div>
                <div class="stat-label">Jadwal Aktif</div>
            </div>
        </div>
    </div>

    <!-- Calendar Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="month-navigation">
                <!-- <button class="nav-btn" onclick="changeMonth(-1)">
                    <i class="bx bx-chevron-left me-1"></i> Previous
                </button> -->
                <h3 class="month-title">{{ Carbon\Carbon::now()->format('F Y') }}</h3>
                <!-- <button class="nav-btn" onclick="changeMonth(1)">
                    Next <i class="bx bx-chevron-right ms-1"></i>
                </button> -->
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="row">
        <div class="col-12">
            <div class="calendar-container">
                <!-- Day Names -->
                <div class="calendar-header">
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                    <div class="day-name">{{ $dayName }}</div>
                    @endforeach
                </div>

                <!-- Calendar Grid -->
                <div class="calendar-grid">
                    @php
                    use Carbon\Carbon;
                    $firstDay = Carbon::now()->startOfMonth()->dayOfWeek;
                    $daysInMonth = Carbon::now()->daysInMonth;
                    $today = Carbon::now()->format('Y-m-d');
                    $scheduleMap = $schedules->keyBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));
                    @endphp

                    <!-- Empty days before first day of month -->
                    @for($i = 0; $i < $firstDay; $i++)
                        <div class="calendar-day inactive"></div>
                    @endfor

                    <!-- Days of the month -->
                    @for($date = 1; $date <= $daysInMonth; $date++)
                        @php
                        $currentDate = Carbon::now()->startOfMonth()->addDays($date - 1);
                        $dateString = $currentDate->format('Y-m-d');
                        $schedule = $scheduleMap[$dateString] ?? null;
                        $isToday = $dateString === $today;
                        @endphp
                        <div class="calendar-day {{ $schedule ? 'has-schedule' : '' }} {{ $isToday ? 'today' : '' }}">
                            <div class="date-number">
                                {{ $currentDate->format('d') }}
                                @if($isToday)
                                <span class="badge bg-white text-primary ms-1" style="font-size: 0.6rem;">Today</span>
                                @endif
                            </div>
                            <div class="schedule-info">
                                @if($schedule)
                                <div class="shift-id">Shift {{ $schedule->shift->id ?? '-' }}</div>
                                <div class="shift-time">
                                    {{ $schedule->shift->start_time ?? '' }} - {{ $schedule->shift->end_time ?? '' }}
                                </div>
                                <small class="text-muted">{{ $schedule->shift->description ?? '' }}</small>
                                @else
                                <div class="no-schedule">Tidak ada jadwal</div>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Legend -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Legend</h6>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 15px; height: 15px; background: linear-gradient(135deg, #667eea 0%, #4180c3 100%); border-radius: 3px;"></div>
                            <small>Hari Ini</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 15px; height: 15px; background: #f0f7ff; border: 1px solid #667eea; border-radius: 3px;"></div>
                            <small>Ada Jadwal</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 15px; height: 15px; background: #fff; border: 1px solid #e9ecef; border-radius: 3px;"></div>
                            <small>Tidak Ada Jadwal</small>
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
    function changeMonth(direction) {
        // Implement month navigation logic here
        console.log('Change month by:', direction);
        // You would typically make an AJAX call to load the new month's data
        // or redirect to a new URL with the updated month parameter
        
        // For now, show a notification
        showNotification('Fitur navigasi bulan akan segera tersedia', 'info');
    }

    function showNotification(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 
                          type === 'warning' ? 'alert-warning' : 'alert-info';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="bx bx-info-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        $('.container-p-y').prepend(alertHtml);
        
        setTimeout(() => {
            $('.alert').alert('close');
        }, 3000);
    }

    // Add click functionality to calendar days
    document.addEventListener('DOMContentLoaded', function() {
        const calendarDays = document.querySelectorAll('.calendar-day:not(.inactive)');
        
        calendarDays.forEach(day => {
            day.addEventListener('click', function() {
                const date = this.querySelector('.date-number').textContent.trim();
                const hasSchedule = this.classList.contains('has-schedule');
                
                if (hasSchedule) {
                    // Show schedule details modal or navigate to detail page
                    showNotification(`Menampilkan detail jadwal untuk tanggal ${date}`, 'info');
                } else {
                    showNotification(`Tidak ada jadwal untuk tanggal ${date}`, 'warning');
                }
            });
        });

        // Add hover effects
        calendarDays.forEach(day => {
            day.addEventListener('mouseenter', function() {
                if (!this.classList.contains('inactive')) {
                    this.style.transform = 'scale(1.02)';
                }
            });
            
            day.addEventListener('mouseleave', function() {
                if (!this.classList.contains('inactive')) {
                    this.style.transform = 'scale(1)';
                }
            });
        });
    });
</script>
@endsection