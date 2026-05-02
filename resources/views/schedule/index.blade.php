@extends('layout.admin')

@section('title', 'Data Schedule')

@section('styles')
    <style>
        .calendar-container {
            background: #ffffff;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
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
            color: #4b5563;
            padding: 0.75rem;
            background: #f9fafb;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            border: 1px solid #f3f4f6;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
        }

        .calendar-day {
            min-height: 120px;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.75rem;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .calendar-day:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .calendar-day.inactive {
            background: #f9fafb;
            border-color: #f3f4f6;
            color: #9ca3af;
        }

        .calendar-day.has-schedule {
            background: #f0fdf4; /* soft green/blue */
            border-color: #bbf7d0;
        }

        .date-number {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
        }

        .schedule-info {
            font-size: 0.75rem;
            line-height: 1.4;
        }

        .shift-id {
            font-weight: 600;
            color: #166534;
            background: #dcfce7;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            display: inline-block;
            margin-bottom: 0.25rem;
        }

        .shift-time {
            color: #4b5563;
            font-size: 0.75rem;
        }

        .no-schedule {
            color: #9ca3af;
            font-size: 0.75rem;
        }

        .month-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
        }

        .month-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .nav-btn {
            background: #ffffff;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nav-btn:hover {
            background: #f3f4f6;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
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
            background: #eff6ff !important;
            border-color: #bfdbfe !important;
        }

        .today .date-number {
            color: #1d4ed8 !important;
        }
        
        .badge-today {
            background-color: #dbeafe;
            color: #1e40af;
            font-weight: 600;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            font-size: 0.65rem;
            margin-left: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1">
                    <h4 class="fw-bold pt-3 pb-1 mb-0">
                        <span class="text-muted fw-light">Schedule /</span> Data Schedule
                    </h4>
                    <div class="d-flex align-items-center gap-2">
                        @if (in_array(Auth::user()->role, ['SPV Bge', 'SPV Apron', 'Admin']))
                            <form action="{{ route('schedule.autoCreate') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center">
                                    <i class="bx bx-magic-wand me-1"></i> Auto Create
                                </button>
                            </form>
                            <button type="button" class="btn btn-outline-primary btn-sm d-flex align-items-center" data-bs-toggle="modal"
                                data-bs-target="#importModal">
                                <i class="bx bx-import me-1"></i> Import
                            </button>
                        @endif
                        <div class="badge bg-primary d-flex align-items-center" style="height: 31px; padding: 0 12px;">
                            <i class="bx bx-calendar me-1"></i>
                            {{ Carbon\Carbon::now()->format('F Y') }}
                        </div>
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
                        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
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
                        @for ($i = 0; $i < $firstDay; $i++)
                            <div class="calendar-day inactive"></div>
                        @endfor

                        <!-- Days of the month -->
                        @for ($date = 1; $date <= $daysInMonth; $date++)
                            @php
                                $currentDate = Carbon::now()
                                    ->startOfMonth()
                                    ->addDays($date - 1);
                                $dateString = $currentDate->format('Y-m-d');
                                $schedule = $scheduleMap[$dateString] ?? null;
                                $isToday = $dateString === $today;
                            @endphp
                            <div class="calendar-day {{ $schedule ? 'has-schedule' : '' }} {{ $isToday ? 'today' : '' }}">
                                <div class="date-number">
                                    {{ $currentDate->format('d') }}
                                    @if ($isToday)
                                        <span class="badge-today">Today</span>
                                    @endif
                                </div>
                                <div class="schedule-info">
                                    @if ($schedule)
                                        <div class="shift-id">Shift {{ $schedule->shift->id ?? '-' }}</div>
                                        <div class="shift-time">
                                            {{ $schedule->shift->start_time ?? '' }} -
                                            {{ $schedule->shift->end_time ?? '' }}
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
                                <div
                                    style="width: 15px; height: 15px; background: linear-gradient(135deg, #667eea 0%, #4180c3 100%); border-radius: 3px;">
                                </div>
                                <small>Hari Ini</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div
                                    style="width: 15px; height: 15px; background: #f0f7ff; border: 1px solid #667eea; border-radius: 3px;">
                                </div>
                                <small>Ada Jadwal</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div
                                    style="width: 15px; height: 15px; background: #fff; border: 1px solid #e9ecef; border-radius: 3px;">
                                </div>
                                <small>Tidak Ada Jadwal</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Import Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('schedule.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <p>Silakan pilih file Excel (.xlsx, .xls) untuk mengimpor jadwal.</p>
                            <div class="mb-3">
                                <label for="file" class="form-label">Pilih File</label>
                                <input type="file" class="form-control" id="file" name="file" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-modal="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Import Now</button>
                        </div>
                    </form>
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
