@extends('layout.admin')

@section('title', 'Data Schedule')

@section('styles')
    <style>
        .schedule-index-page {
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

        .schedule-index-page .schedule-page-header {
            margin-bottom: 1.25rem;
        }

        .schedule-index-page .schedule-title {
            line-height: 1.25;
        }

        .schedule-index-page .schedule-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-items: center;
            gap: 0.65rem;
        }

        .schedule-index-page .schedule-action-form {
            margin: 0;
        }

        .schedule-index-page .schedule-action-btn,
        .schedule-index-page .period-pill {
            min-height: 40px;
            border-radius: 0.55rem;
            font-size: 0.82rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .schedule-index-page .schedule-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.55rem 0.95rem;
            box-shadow: none !important;
        }

        .schedule-index-page .schedule-action-btn.btn-primary {
            background: linear-gradient(135deg, var(--sd-blue), var(--sd-blue-deep));
            border-color: rgba(47, 128, 237, 0.24);
            box-shadow: 0 12px 24px rgba(47, 128, 237, 0.18) !important;
        }

        .schedule-index-page .schedule-action-btn.btn-outline-primary {
            background: var(--sd-surface);
            border-color: rgba(47, 128, 237, 0.5);
            color: var(--sd-blue-deep);
        }

        .schedule-index-page .schedule-action-btn:hover {
            transform: translateY(-1px);
        }

        .schedule-index-page .period-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.42rem;
            padding: 0.55rem 0.85rem;
            background: linear-gradient(135deg, rgba(47, 128, 237, 0.92), rgba(35, 104, 200, 0.92));
            color: #ffffff;
            box-shadow: 0 12px 24px rgba(47, 128, 237, 0.16);
        }

        .schedule-index-page .schedule-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1.35rem;
        }

        .schedule-index-page .schedule-stat-card {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            min-width: 0;
            min-height: 106px;
            padding: 1.05rem;
            background: var(--sd-surface);
            border: 1px solid var(--sd-border);
            border-radius: var(--sd-radius);
            box-shadow: var(--sd-shadow);
        }

        .schedule-index-page .schedule-stat-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            width: 42px;
            height: 42px;
            border-radius: var(--sd-radius-sm);
            color: var(--sd-blue);
            background: var(--sd-surface-muted);
            font-size: 1.15rem;
        }

        .schedule-index-page .schedule-stat-icon.is-green {
            color: var(--sd-green);
            background: var(--sd-green-soft);
        }

        .schedule-index-page .schedule-stat-icon.is-amber {
            color: var(--sd-amber);
            background: var(--sd-amber-soft);
        }

        .schedule-index-page .schedule-stat-number {
            color: var(--sd-text);
            font-size: 1.45rem;
            font-weight: 750;
            line-height: 1.1;
        }

        .schedule-index-page .schedule-stat-label {
            margin-top: 0.28rem;
            color: var(--sd-muted);
            font-size: 0.82rem;
            font-weight: 650;
            line-height: 1.25;
        }

        .schedule-index-page .month-navigation,
        .schedule-index-page .calendar-container {
            background: var(--sd-surface);
            border: 1px solid var(--sd-border);
            border-radius: var(--sd-radius);
            box-shadow: var(--sd-shadow);
        }

        .schedule-index-page .month-navigation {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.35rem;
            padding: 1rem 1.15rem;
        }

        .schedule-index-page .month-title-group {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            min-width: 0;
        }

        .schedule-index-page .month-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            width: 44px;
            height: 44px;
            border-radius: var(--sd-radius-sm);
            background: linear-gradient(135deg, var(--sd-blue), var(--sd-blue-deep));
            color: #ffffff;
            font-size: 1.2rem;
            box-shadow: 0 12px 24px rgba(47, 128, 237, 0.18);
        }

        .schedule-index-page .month-kicker {
            display: block;
            margin-bottom: 0.18rem;
            color: var(--sd-blue);
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .schedule-index-page .month-title {
            margin: 0;
            color: var(--sd-text);
            font-size: 1.2rem;
            font-weight: 750;
            line-height: 1.25;
        }

        .schedule-index-page .month-meta {
            display: inline-flex;
            align-items: center;
            gap: 0.38rem;
            padding: 0.48rem 0.72rem;
            border: 1px solid rgba(47, 128, 237, 0.2);
            border-radius: 999px;
            background: rgba(47, 128, 237, 0.08);
            color: var(--sd-blue-deep);
            font-size: 0.78rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .schedule-index-page .calendar-container {
            padding: 1.25rem;
        }

        .schedule-index-page .calendar-topline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .schedule-index-page .calendar-heading {
            margin: 0;
            color: var(--sd-text);
            font-size: 1rem;
            font-weight: 750;
        }

        .schedule-index-page .calendar-count-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.38rem;
            padding: 0.42rem 0.66rem;
            border-radius: 999px;
            background: var(--sd-green-soft);
            color: var(--sd-green);
            font-size: 0.76rem;
            font-weight: 750;
            white-space: nowrap;
        }

        .schedule-index-page .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 0.55rem;
            margin-bottom: 0.65rem;
            text-align: center;
        }

        .schedule-index-page .day-name {
            min-width: 0;
            padding: 0.68rem 0.4rem;
            background: var(--sd-surface-soft);
            border: 1px solid var(--sd-border);
            border-radius: var(--sd-radius-sm);
            color: #4d5c70;
            font-size: 0.82rem;
            font-weight: 750;
        }

        .schedule-index-page .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            grid-auto-rows: minmax(122px, auto);
            gap: 0.55rem;
        }

        .schedule-index-page .calendar-day {
            width: 100%;
            min-width: 0;
            min-height: 122px;
            padding: 0.78rem;
            border: 1px solid var(--sd-border);
            border-radius: var(--sd-radius-sm);
            background: var(--sd-surface);
            color: inherit;
            text-align: left;
            transition: transform 0.18s ease, border-color 0.18s ease, background-color 0.18s ease, box-shadow 0.18s ease;
        }

        .schedule-index-page button.calendar-day {
            appearance: none;
            cursor: pointer;
        }

        .schedule-index-page .calendar-day:hover {
            border-color: rgba(47, 128, 237, 0.28);
            background: var(--sd-surface-soft);
            box-shadow: 0 12px 24px rgba(31, 49, 78, 0.08);
            transform: translateY(-1px);
        }

        .schedule-index-page .calendar-day.inactive {
            background: #f8fafc;
            border-color: #eef2f7;
            box-shadow: none;
            cursor: default;
            pointer-events: none;
        }

        .schedule-index-page .calendar-day.inactive:hover {
            background: #f8fafc;
            border-color: #eef2f7;
            box-shadow: none;
            transform: none;
        }

        .schedule-index-page .calendar-day.has-schedule {
            background: linear-gradient(180deg, #f6fff9 0%, #ffffff 100%);
            border-color: #bfeccc;
        }

        .schedule-index-page .calendar-day.today {
            background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%) !important;
            border-color: rgba(47, 128, 237, 0.42) !important;
            box-shadow: 0 12px 28px rgba(47, 128, 237, 0.12);
        }

        .schedule-index-page .date-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.5rem;
            margin-bottom: 0.65rem;
        }

        .schedule-index-page .date-block {
            min-width: 0;
        }

        .schedule-index-page .date-weekday {
            display: none;
            color: var(--sd-muted);
            font-size: 0.74rem;
            font-weight: 750;
        }

        .schedule-index-page .date-number {
            display: block;
            color: var(--sd-text);
            font-size: 0.95rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .schedule-index-page .today .date-number {
            color: var(--sd-blue-deep) !important;
        }

        .schedule-index-page .badge-today {
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

        .schedule-index-page .schedule-info {
            min-width: 0;
            color: var(--sd-muted);
            font-size: 0.76rem;
            line-height: 1.42;
        }

        .schedule-index-page .shift-id {
            display: inline-flex;
            align-items: center;
            gap: 0.28rem;
            margin-bottom: 0.34rem;
            padding: 0.26rem 0.48rem;
            border-radius: 999px;
            background: var(--sd-green-soft);
            color: #137a4c;
            font-size: 0.72rem;
            font-weight: 800;
            line-height: 1;
        }

        .schedule-index-page .shift-time {
            display: flex;
            align-items: center;
            gap: 0.32rem;
            color: #4d5c70;
            font-size: 0.74rem;
            font-weight: 700;
        }

        .schedule-index-page .shift-description {
            display: block;
            min-width: 0;
            margin-top: 0.28rem;
            color: var(--sd-faint);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .schedule-index-page .no-schedule {
            display: inline-flex;
            align-items: center;
            gap: 0.32rem;
            color: var(--sd-faint);
            font-size: 0.76rem;
            font-weight: 650;
        }

        .schedule-index-page .calendar-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem 1rem;
            align-items: center;
            justify-content: flex-start;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--sd-border);
        }

        .schedule-index-page .legend-item {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            color: var(--sd-muted);
            font-size: 0.78rem;
            font-weight: 700;
        }

        .schedule-index-page .legend-swatch {
            width: 14px;
            height: 14px;
            border-radius: 0.28rem;
            border: 1px solid var(--sd-border);
            background: var(--sd-surface);
        }

        .schedule-index-page .legend-swatch.is-today {
            background: #eff6ff;
            border-color: rgba(47, 128, 237, 0.42);
        }

        .schedule-index-page .legend-swatch.is-scheduled {
            background: #f6fff9;
            border-color: #bfeccc;
        }

        html.aps-dark .schedule-index-page {
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

        html.aps-dark .schedule-index-page .month-navigation,
        html.aps-dark .schedule-index-page .calendar-container,
        html.aps-dark .schedule-index-page .schedule-stat-card {
            background: var(--sd-surface) !important;
            border-color: var(--sd-border) !important;
            color: var(--sd-text) !important;
            box-shadow: var(--sd-shadow) !important;
        }

        html.aps-dark .schedule-index-page .day-name,
        html.aps-dark .schedule-index-page .calendar-day,
        html.aps-dark .schedule-index-page .calendar-day.inactive {
            background: #0f1a2d !important;
            border-color: #253650 !important;
            color: var(--sd-text) !important;
        }

        html.aps-dark .schedule-index-page .calendar-day:hover {
            background: #172942 !important;
            border-color: rgba(47, 128, 237, 0.42) !important;
        }

        html.aps-dark .schedule-index-page .calendar-day.has-schedule {
            background: rgba(34, 197, 94, 0.1) !important;
            border-color: rgba(110, 231, 168, 0.32) !important;
        }

        html.aps-dark .schedule-index-page .calendar-day.today {
            background: rgba(47, 128, 237, 0.16) !important;
            border-color: rgba(47, 128, 237, 0.42) !important;
        }

        html.aps-dark .schedule-index-page .schedule-action-btn.btn-outline-primary {
            background: #101a2c;
            border-color: rgba(47, 128, 237, 0.36);
            color: #8fc2ff;
        }

        html.aps-dark .schedule-index-page .shift-id {
            color: #6ee7a8 !important;
        }

        html.aps-dark .schedule-index-page .shift-time,
        html.aps-dark .schedule-index-page .day-name {
            color: #dbe7f6 !important;
        }

        html.aps-dark .schedule-index-page .badge-today {
            background: rgba(47, 128, 237, 0.2);
            color: #9ccaff;
        }

        @media (max-width: 1199.98px) {
            .schedule-index-page .schedule-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .schedule-index-page .schedule-page-header {
                gap: 0.85rem;
            }

            .schedule-index-page .schedule-actions {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                width: 100%;
                justify-content: stretch;
            }

            .schedule-index-page .schedule-action-form,
            .schedule-index-page .schedule-action-btn {
                width: 100%;
            }

            .schedule-index-page .period-pill {
                grid-column: 1 / -1;
                width: 100%;
            }

            .schedule-index-page .month-navigation {
                align-items: flex-start;
                flex-direction: column;
                padding: 0.9rem;
            }

            .schedule-index-page .month-title {
                font-size: 1.08rem;
            }

            .schedule-index-page .month-meta {
                width: 100%;
                justify-content: center;
            }

            .schedule-index-page .calendar-container {
                padding: 0.8rem;
            }

            .schedule-index-page .calendar-topline {
                align-items: flex-start;
                flex-direction: column;
                gap: 0.65rem;
            }

            .schedule-index-page .calendar-header {
                display: none;
            }

            .schedule-index-page .calendar-grid {
                grid-template-columns: 1fr;
                grid-auto-rows: auto;
                gap: 0.65rem;
            }

            .schedule-index-page .calendar-placeholder {
                display: none;
            }

            .schedule-index-page .calendar-day {
                display: grid;
                gap: 0.65rem;
                min-height: 0;
                padding: 0.88rem;
            }

            .schedule-index-page .date-row {
                align-items: center;
                margin-bottom: 0;
            }

            .schedule-index-page .date-weekday {
                display: block;
                margin-bottom: 0.22rem;
            }

            .schedule-index-page .date-number {
                font-size: 1.08rem;
            }

            .schedule-index-page .schedule-info {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 0.4rem 0.55rem;
            }

            .schedule-index-page .shift-id {
                margin-bottom: 0;
            }

            .schedule-index-page .shift-description {
                width: 100%;
                white-space: normal;
            }
        }

        @media (max-width: 575.98px) {
            .schedule-index-page .schedule-title {
                width: 100%;
            }

            .schedule-index-page .schedule-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0.75rem;
            }

            .schedule-index-page .schedule-stat-card {
                align-items: flex-start;
                flex-direction: column;
                gap: 0.65rem;
                min-height: 118px;
                padding: 0.9rem;
            }

            .schedule-index-page .schedule-stat-icon {
                width: 36px;
                height: 36px;
                font-size: 1rem;
            }

            .schedule-index-page .schedule-stat-number {
                font-size: 1.25rem;
            }

            .schedule-index-page .schedule-stat-label {
                font-size: 0.76rem;
            }
        }

        @media (max-width: 374.98px) {
            .schedule-index-page .schedule-actions,
            .schedule-index-page .schedule-stats {
                grid-template-columns: 1fr;
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
        $scheduledDays = $scheduleMap->count();
        $shiftCount = $scheduleMap->pluck('shift_id')->filter()->unique()->count();
        $activeSchedules = $scheduleMap->filter(fn($schedule) => (bool) $schedule->is_active)->count();
        $remainingDays = (7 - (($firstDay + $daysInMonth) % 7)) % 7;
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y schedule-index-page">
        <!-- Header -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div
                    class="schedule-page-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <h4 class="schedule-title fw-bold pt-3 pb-1 mb-0">
                        <span class="text-muted fw-light">Schedule /</span> Data Schedule
                    </h4>
                    <div class="schedule-actions">
                        <span class="period-pill">
                            <i class="bx bx-calendar"></i>
                            {{ $monthLabel }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="schedule-stats">
            <div class="schedule-stat-card">
                <span class="schedule-stat-icon">
                    <i class="bx bx-calendar-event"></i>
                </span>
                <div>
                    <div class="schedule-stat-number">{{ $scheduleMap->count() }}</div>
                    <div class="schedule-stat-label">Total Jadwal</div>
                </div>
            </div>
            <div class="schedule-stat-card">
                <span class="schedule-stat-icon is-green">
                    <i class="bx bx-check-circle"></i>
                </span>
                <div>
                    <div class="schedule-stat-number">{{ $scheduledDays }}</div>
                    <div class="schedule-stat-label">Hari Terjadwal</div>
                </div>
            </div>
            <div class="schedule-stat-card">
                <span class="schedule-stat-icon is-amber">
                    <i class="bx bx-time-five"></i>
                </span>
                <div>
                    <div class="schedule-stat-number">{{ $shiftCount }}</div>
                    <div class="schedule-stat-label">Shift Aktif</div>
                </div>
            </div>
            <div class="schedule-stat-card">
                <span class="schedule-stat-icon">
                    <i class="bx bx-user-check"></i>
                </span>
                <div>
                    <div class="schedule-stat-number">{{ $activeSchedules }}</div>
                    <div class="schedule-stat-label">Jadwal Aktif</div>
                </div>
            </div>
        </div>

        <!-- Calendar Navigation -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="month-navigation">
                    <div class="month-title-group">
                        <span class="month-icon">
                            <i class="bx bx-calendar-star"></i>
                        </span>
                        <div>
                            <span class="month-kicker">Periode</span>
                            <h3 class="month-title">{{ $monthLabel }}</h3>
                        </div>
                    </div>
                    <span class="month-meta">
                        <i class="bx bx-calendar-check"></i>
                        {{ $scheduledDays }} hari terjadwal
                    </span>
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div class="row">
            <div class="col-12">
                <div class="calendar-container">
                    <div class="calendar-topline">
                        <h5 class="calendar-heading">Kalender Bulanan</h5>
                        <span class="calendar-count-chip">
                            <i class="bx bx-check-shield"></i>
                            {{ $activeSchedules }} aktif
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
                            <div class="calendar-day calendar-placeholder inactive" aria-hidden="true"></div>
                        @endfor

                        <!-- Days of the month -->
                        @for ($date = 1; $date <= $daysInMonth; $date++)
                            @php
                                $currentDate = $currentMonth->copy()
                                    ->addDays($date - 1);
                                $dateString = $currentDate->format('Y-m-d');
                                $schedule = $scheduleMap[$dateString] ?? null;
                                $isToday = $dateString === $today;
                            @endphp
                            <button type="button"
                                class="calendar-day {{ $schedule ? 'has-schedule' : '' }} {{ $isToday ? 'today' : '' }}"
                                data-date="{{ $currentDate->format('d M Y') }}"
                                aria-label="Jadwal tanggal {{ $currentDate->format('d M Y') }}">
                                <div class="date-row">
                                    <div class="date-block">
                                        <span class="date-weekday">{{ $currentDate->format('D') }}</span>
                                        <span class="date-number">{{ $currentDate->format('d') }}</span>
                                    </div>
                                    @if ($isToday)
                                        <span class="badge-today">Today</span>
                                    @endif
                                </div>
                                <div class="schedule-info">
                                    @if ($schedule)
                                        <div class="shift-id">
                                            <i class="bx bx-time-five"></i>
                                            Shift {{ $schedule->shift->id ?? '-' }}
                                        </div>
                                        <div class="shift-time">
                                            <i class="bx bx-time"></i>
                                            {{ $schedule->shift->start_time ?? '' }} -
                                            {{ $schedule->shift->end_time ?? '' }}
                                        </div>
                                        <small class="shift-description">{{ $schedule->shift->description ?? '' }}</small>
                                    @else
                                        <div class="no-schedule">
                                            <i class="bx bx-calendar-x"></i>
                                            Tidak ada jadwal
                                        </div>
                                    @endif
                                </div>
                            </button>
                        @endfor

                        @for ($i = 0; $i < $remainingDays; $i++)
                            <div class="calendar-day calendar-placeholder inactive" aria-hidden="true"></div>
                        @endfor
                    </div>

                    <div class="calendar-legend" aria-label="Keterangan kalender">
                        <span class="legend-item">
                            <span class="legend-swatch is-today"></span>
                            Hari Ini
                        </span>
                        <span class="legend-item">
                            <span class="legend-swatch is-scheduled"></span>
                            Ada Jadwal
                        </span>
                        <span class="legend-item">
                            <span class="legend-swatch"></span>
                            Tidak Ada Jadwal
                        </span>
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
                    const date = this.dataset.date || this.querySelector('.date-number').textContent.trim();
                    const hasSchedule = this.classList.contains('has-schedule');

                    if (hasSchedule) {
                        // Show schedule details modal or navigate to detail page
                        showNotification(`Menampilkan detail jadwal untuk tanggal ${date}`, 'info');
                    } else {
                        showNotification(`Tidak ada jadwal untuk tanggal ${date}`, 'warning');
                    }
                });
            });
        });
    </script>
@endsection
