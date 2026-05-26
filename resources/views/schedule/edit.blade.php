@extends('layout.admin')

@section('title', 'Edit Schedule - ' . $user->fullname)

@section('styles')
    <style>
        .schedule-edit-page {
            --sd-surface: #ffffff;
            --sd-surface-soft: #f8fbff;
            --sd-surface-muted: #eef5ff;
            --sd-border: #e5edf7;
            --sd-border-strong: #d7e5f4;
            --sd-text: #243247;
            --sd-muted: #718096;
            --sd-faint: #9aa8bb;
            --sd-blue: #2f80ed;
            --sd-blue-deep: #2368c8;
            --sd-green: #16a163;
            --sd-green-soft: #e9f8f0;
            --sd-amber: #f59e0b;
            --sd-amber-soft: #fff7e6;
            --sd-shadow: 0 16px 38px rgba(31, 49, 78, 0.07);
            --sd-radius: 1rem;
            --sd-radius-sm: 0.85rem;
        }

        .schedule-edit-page .schedule-page-header {
            margin-bottom: 1.25rem;
        }

        .schedule-edit-page .schedule-title {
            line-height: 1.25;
        }

        .schedule-edit-page .profile-card {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            background: var(--sd-surface);
            border: 1px solid var(--sd-border);
            border-radius: var(--sd-radius);
            box-shadow: var(--sd-shadow);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .schedule-edit-page .profile-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(47, 128, 237, 0.18);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
        }

        .schedule-edit-page .profile-info {
            flex-grow: 1;
            min-width: 0;
        }

        .schedule-edit-page .profile-name {
            margin: 0 0 0.25rem;
            color: var(--sd-text);
            font-size: 1.15rem;
            font-weight: 800;
        }

        .schedule-edit-page .profile-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem 1rem;
            align-items: center;
        }

        .schedule-edit-page .profile-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.78rem;
            color: var(--sd-muted);
            font-weight: 650;
        }

        .schedule-edit-page .profile-meta-item i {
            font-size: 0.9rem;
            color: var(--sd-blue);
        }

        .schedule-edit-page .calendar-container {
            background: var(--sd-surface);
            border: 1px solid var(--sd-border);
            border-radius: var(--sd-radius);
            box-shadow: var(--sd-shadow);
            padding: 1.25rem;
        }

        .schedule-edit-page .calendar-topline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .schedule-edit-page .calendar-heading {
            margin: 0;
            color: var(--sd-text);
            font-size: 1.05rem;
            font-weight: 800;
        }

        .schedule-edit-page .period-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.42rem;
            padding: 0.45rem 0.85rem;
            border-radius: 0.55rem;
            background: linear-gradient(135deg, rgba(47, 128, 237, 0.92), rgba(35, 104, 200, 0.92));
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(47, 128, 237, 0.16);
        }

        .schedule-edit-page .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 0.55rem;
            margin-bottom: 0.65rem;
            text-align: center;
        }

        .schedule-edit-page .day-name {
            min-width: 0;
            padding: 0.68rem 0.4rem;
            background: var(--sd-surface-soft);
            border: 1px solid var(--sd-border);
            border-radius: var(--sd-radius-sm);
            color: #4d5c70;
            font-size: 0.82rem;
            font-weight: 750;
        }

        .schedule-edit-page .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            grid-auto-rows: minmax(130px, auto);
            gap: 0.55rem;
        }

        .schedule-edit-page .calendar-day {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
            min-height: 130px;
            padding: 0.78rem;
            border: 1px solid var(--sd-border);
            border-radius: var(--sd-radius-sm);
            background: var(--sd-surface);
            transition: transform 0.18s ease, border-color 0.18s ease, background-color 0.18s ease, box-shadow 0.18s ease;
        }

        .schedule-edit-page .calendar-day:hover {
            border-color: rgba(47, 128, 237, 0.28);
            background: var(--sd-surface-soft);
            box-shadow: 0 12px 24px rgba(31, 49, 78, 0.06);
            transform: translateY(-1px);
        }

        .schedule-edit-page .calendar-day.inactive {
            background: #f8fafc;
            border-color: #eef2f7;
            box-shadow: none;
            cursor: default;
            pointer-events: none;
        }

        .schedule-edit-page .calendar-day.has-schedule {
            background: linear-gradient(180deg, #f6fff9 0%, #ffffff 100%);
            border-color: #bfeccc;
        }

        .schedule-edit-page .calendar-day.today {
            background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%) !important;
            border-color: rgba(47, 128, 237, 0.42) !important;
            box-shadow: 0 12px 28px rgba(47, 128, 237, 0.1);
        }

        .schedule-edit-page .date-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.5rem;
            margin-bottom: 0.65rem;
        }

        .schedule-edit-page .date-block {
            min-width: 0;
        }

        .schedule-edit-page .date-number {
            display: block;
            color: var(--sd-text);
            font-size: 0.95rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .schedule-edit-page .today .date-number {
            color: var(--sd-blue-deep) !important;
        }

        .schedule-edit-page .badge-today {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            padding: 0.22rem 0.45rem;
            border-radius: 999px;
            background-color: #dbeafe;
            color: #1e40af;
            font-size: 0.66rem;
            font-weight: 800;
            line-height: 1;
        }

        .schedule-edit-page .form-select-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.76rem;
            border-radius: 0.375rem;
            border-color: var(--sd-border-strong);
            color: var(--sd-text);
            background-color: var(--sd-surface);
            box-shadow: none !important;
            cursor: pointer;
        }

        .schedule-edit-page .form-select-sm:focus {
            border-color: var(--sd-blue);
        }

        .schedule-edit-page .calendar-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem 1rem;
            align-items: center;
            justify-content: flex-start;
            margin-top: 1.25rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--sd-border);
        }

        .schedule-edit-page .legend-item {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            color: var(--sd-muted);
            font-size: 0.78rem;
            font-weight: 700;
        }

        .schedule-edit-page .legend-swatch {
            width: 14px;
            height: 14px;
            border-radius: 0.28rem;
            border: 1px solid var(--sd-border);
            background: var(--sd-surface);
        }

        .schedule-edit-page .legend-swatch.is-today {
            background: #eff6ff;
            border-color: rgba(47, 128, 237, 0.42);
        }

        .schedule-edit-page .legend-swatch.is-scheduled {
            background: #f6fff9;
            border-color: #bfeccc;
        }

        .schedule-edit-page .calendar-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }

        .schedule-edit-page .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-height: 42px;
            padding: 0.6rem 1.5rem;
            border-radius: 0.55rem;
            font-weight: 700;
            font-size: 0.84rem;
            background: #6b7280;
            color: #ffffff;
            border: 0;
            box-shadow: 0 8px 18px rgba(107, 114, 128, 0.16);
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .schedule-edit-page .btn-back:hover {
            background: #4b5563;
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* Dark Mode Support */
        html.aps-dark .schedule-edit-page {
            --sd-surface: #111c31;
            --sd-surface-soft: #16243a;
            --sd-surface-muted: #162842;
            --sd-border: #263653;
            --sd-border-strong: #315071;
            --sd-text: #e7f0fb;
            --sd-muted: #a5b7cf;
            --sd-faint: #72849d;
            --sd-green: #6ee7a8;
            --sd-green-soft: rgba(34, 197, 94, 0.14);
            --sd-amber: #fbbf24;
            --sd-amber-soft: rgba(245, 158, 11, 0.14);
            --sd-shadow: 0 18px 42px rgba(0, 0, 0, 0.22);
        }

        html.aps-dark .schedule-edit-page .profile-card,
        html.aps-dark .schedule-edit-page .calendar-container {
            background: var(--sd-surface) !important;
            border-color: var(--sd-border) !important;
            color: var(--sd-text) !important;
            box-shadow: var(--sd-shadow) !important;
        }

        html.aps-dark .schedule-edit-page .day-name,
        html.aps-dark .schedule-edit-page .calendar-day,
        html.aps-dark .schedule-edit-page .calendar-day.inactive {
            background: #0f1a2d !important;
            border-color: #253650 !important;
            color: var(--sd-text) !important;
        }

        html.aps-dark .schedule-edit-page .calendar-day:hover {
            background: #172942 !important;
            border-color: rgba(47, 128, 237, 0.42) !important;
        }

        html.aps-dark .schedule-edit-page .calendar-day.has-schedule {
            background: rgba(34, 197, 94, 0.1) !important;
            border-color: rgba(110, 231, 168, 0.32) !important;
        }

        html.aps-dark .schedule-edit-page .calendar-day.today {
            background: rgba(47, 128, 237, 0.16) !important;
            border-color: rgba(47, 128, 237, 0.42) !important;
        }

        html.aps-dark .schedule-edit-page .badge-today {
            background: rgba(47, 128, 237, 0.2);
            color: #9ccaff;
        }

        html.aps-dark .schedule-edit-page .form-select-sm {
            background-color: #0f1a2d !important;
            border-color: #2a3a55 !important;
            color: #e6edf7 !important;
        }

        @media (max-width: 767.98px) {
            .schedule-edit-page .profile-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.85rem;
                padding: 1rem;
            }

            .schedule-edit-page .profile-avatar {
                width: 48px;
                height: 48px;
            }

            .schedule-edit-page .profile-name {
                font-size: 1.05rem;
            }

            .schedule-edit-page .profile-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.35rem;
            }

            .schedule-edit-page .calendar-header {
                display: none;
            }

            .schedule-edit-page .calendar-grid {
                grid-template-columns: 1fr;
                grid-auto-rows: auto;
                gap: 0.65rem;
            }

            .schedule-edit-page .calendar-day {
                min-height: 0;
                padding: 0.88rem;
                gap: 0.65rem;
            }

            .schedule-edit-page .date-row {
                align-items: center;
                margin-bottom: 0;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $currentMonth = \Carbon\Carbon::create($year ?? now()->year, $month ?? now()->month, 1);
        $monthLabel = $currentMonth->format('F Y');
        $firstDay = $startDay ?? $currentMonth->copy()->startOfMonth()->dayOfWeek;
        $daysInMonth = $daysInMonth ?? $currentMonth->daysInMonth;
        $today = \Carbon\Carbon::now()->format('Y-m-d');
        
        $scheduleMap = ($schedules instanceof \Illuminate\Support\Collection ? $schedules : collect($schedules))
            ->keyBy(fn($item) => \Carbon\Carbon::parse($item->date)->format('Y-m-d'));
            
        $shifts = \App\Models\Shift::all();
        $remainingDays = (7 - (($firstDay + $daysInMonth) % 7)) % 7;
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y schedule-edit-page">
        <!-- Header -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="schedule-page-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <h4 class="schedule-title fw-bold pt-3 pb-1 mb-0">
                        <span class="text-muted fw-light">Schedule /</span> Edit Schedule
                    </h4>
                </div>
            </div>
        </div>

        <!-- User Profile Card -->
        <div class="profile-card">
            <img src="{{ $user->profile_picture ? asset('storage/photo/' . $user->profile_picture) : asset('storage/photo/user.jpg') }}"
                 alt="{{ $user->fullname }}" 
                 class="profile-avatar">
            <div class="profile-info">
                <h5 class="profile-name">{{ $user->fullname }}</h5>
                <div class="profile-meta">
                    <span class="profile-meta-item">
                        <i class="bx bx-id-card"></i>
                        NIP: {{ $user->id }}
                    </span>
                    <span class="profile-meta-item">
                        <i class="bx bx-briefcase-alt-2"></i>
                        Role: {{ $user->role }}
                    </span>
                    <span class="profile-meta-item">
                        <i class="bx bx-calendar"></i>
                        Periode: {{ $monthLabel }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Calendar Card -->
        <div class="calendar-container">
            <div class="calendar-topline">
                <h5 class="calendar-heading">Atur Jadwal Kerja</h5>
                <span class="period-pill">
                    <i class="bx bx-calendar"></i>
                    {{ $monthLabel }}
                </span>
            </div>

            <!-- Day Names -->
            <div class="calendar-header">
                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                    <div class="day-name">{{ $dayName }}</div>
                @endforeach
            </div>

            <!-- Calendar Grid -->
            <div class="calendar-grid">
                <!-- Empty days before first day of month -->
                @for ($i = 0; $i < $firstDay; $i++)
                    <div class="calendar-day inactive" aria-hidden="true"></div>
                @endfor

                <!-- Days of the month -->
                @for ($date = 1; $date <= $daysInMonth; $date++)
                    @php
                        $currentDate = $currentMonth->copy()->addDays($date - 1);
                        $dateString = $currentDate->format('Y-m-d');
                        $schedule = $scheduleMap[$dateString] ?? null;
                        $isToday = $dateString === $today;
                    @endphp
                    <div class="calendar-day {{ $schedule ? 'has-schedule' : '' }} {{ $isToday ? 'today' : '' }}">
                        <div class="date-row">
                            <div class="date-block">
                                <span class="date-number">{{ $currentDate->format('d') }}</span>
                            </div>
                            @if ($isToday)
                                <span class="badge-today">Today</span>
                            @endif
                        </div>

                        <div class="select-wrapper">
                            <form method="POST" action="{{ route('schedule.update_details', ['userId' => $userId, 'date' => $dateString]) }}">
                                @csrf
                                <select name="shift_id" data-aps-native class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">-- OFF --</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}"
                                            {{ optional($schedule)->shift_id == $shift->id ? 'selected' : '' }}>
                                            Shift {{ $shift->id }} ({{ substr((string)$shift->start_time, 0, 5) }}-{{ substr((string)$shift->end_time, 0, 5) }})
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                @endfor

                <!-- Empty days after last day of month -->
                @for ($i = 0; $i < $remainingDays; $i++)
                    <div class="calendar-day inactive" aria-hidden="true"></div>
                @endfor
            </div>

            <!-- Legend -->
            <div class="calendar-legend">
                <span class="legend-item">
                    <span class="legend-swatch is-today"></span>
                    Hari Ini
                </span>
                <span class="legend-item">
                    <span class="legend-swatch is-scheduled"></span>
                    Terjadwal
                </span>
                <span class="legend-item">
                    <span class="legend-swatch"></span>
                    Tidak Terjadwal (OFF)
                </span>
            </div>

            <!-- Actions -->
            <div class="calendar-actions">
                <a href="{{ route('schedule.view', ['page' => $page]) }}" class="btn-back">
                    <i class="bx bx-arrow-back"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 9999; justify-content: center; align-items: center; flex-direction: column; color: white;">
        <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
        <span class="fw-semibold">Menyimpan Perubahan...</span>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.schedule-edit-page form');
            const overlay = document.getElementById('loadingOverlay');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    if (overlay) {
                        overlay.style.display = 'flex';
                    }
                });
            });
        });
    </script>
@endsection
