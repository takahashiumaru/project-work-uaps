@extends('layout.admin')

@section('title', 'Jadwal Hari Ini')

@section('styles')
<style>
    /* Switch Toggle */
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #48bb78;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .schedule-now-page {
        --sn-surface: #ffffff;
        --sn-surface-soft: #f8fbff;
        --sn-surface-muted: #eef5ff;
        --sn-border: #e5edf7;
        --sn-border-strong: #d8e4f2;
        --sn-text: #28364a;
        --sn-muted: #718096;
        --sn-faint: #9aa8bb;
        --sn-blue: #2f80ed;
        --sn-blue-deep: #2368c8;
        --sn-green: #16a163;
        --sn-green-soft: #e9f8f0;
        --sn-red: #e34d4d;
        --sn-red-soft: #fdecec;
        --sn-shadow: 0 18px 42px rgba(31, 49, 78, 0.075);
    }

    .schedule-now-page .schedule-page-header {
        margin-bottom: 1.35rem;
    }

    .schedule-now-page .date-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        min-height: 32px;
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--sn-blue), var(--sn-blue-deep));
        color: #ffffff;
        font-size: 0.76rem;
        font-weight: 700;
        box-shadow: 0 10px 22px rgba(47, 128, 237, 0.18);
        white-space: nowrap;
    }

    .schedule-now-page .today-overview {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(360px, 0.8fr);
        gap: 1rem;
        margin-bottom: 1.35rem;
    }

    .schedule-now-page .today-overview-main,
    .schedule-now-page .today-stat,
    .schedule-now-page .schedule-card,
    .schedule-now-page .empty-state {
        border: 1px solid var(--sn-border);
        border-radius: 16px;
        background: var(--sn-surface);
        box-shadow: var(--sn-shadow);
    }

    .schedule-now-page .today-overview-main {
        position: relative;
        overflow: hidden;
        padding: 1.25rem;
        background:
            radial-gradient(circle at 94% 8%, rgba(22, 161, 99, 0.14), transparent 24%),
            linear-gradient(135deg, #2f80ed 0%, #2368c8 52%, #184fa8 100%);
        color: #ffffff;
    }

    .schedule-now-page .today-overview-main::after {
        content: "";
        position: absolute;
        inset: auto -6% -42% auto;
        width: 260px;
        height: 260px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 999px;
        pointer-events: none;
    }

    .schedule-now-page .overview-kicker {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        margin-bottom: 0.8rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.78);
    }

    .schedule-now-page .today-overview-main h5 {
        position: relative;
        margin: 0 0 0.35rem;
        color: #ffffff;
        font-size: 1.2rem;
        font-weight: 700;
        line-height: 1.35;
    }

    .schedule-now-page .today-overview-main p {
        position: relative;
        max-width: 680px;
        margin: 0;
        color: rgba(255, 255, 255, 0.82);
        font-size: 0.88rem;
        line-height: 1.55;
    }

    .schedule-now-page .today-stats {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .schedule-now-page .today-stat {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        min-height: 92px;
        padding: 1rem;
    }

    .schedule-now-page .today-stat-icon,
    .schedule-now-page .shift-icon,
    .schedule-now-page .staff-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
    }

    .schedule-now-page .today-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: var(--sn-surface-muted);
        color: var(--sn-blue);
        font-size: 1.15rem;
    }

    .schedule-now-page .today-stat-value {
        color: var(--sn-text);
        font-size: 1.25rem;
        font-weight: 750;
        line-height: 1.1;
    }

    .schedule-now-page .today-stat-label {
        margin-top: 0.25rem;
        color: var(--sn-muted);
        font-size: 0.78rem;
        font-weight: 650;
    }

    .schedule-now-page .schedule-card {
        overflow: hidden;
        margin-bottom: 1.15rem;
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }

    .schedule-now-page .schedule-card:hover {
        transform: translateY(-2px);
        border-color: var(--sn-border-strong);
        box-shadow: 0 22px 48px rgba(31, 49, 78, 0.1);
    }

    .schedule-now-page .schedule-card.is-current {
        border-color: rgba(47, 128, 237, 0.34);
    }

    .schedule-now-page .schedule-header {
        padding: 1.1rem 1.25rem;
        background:
            linear-gradient(135deg, rgba(47, 128, 237, 0.1), rgba(22, 161, 99, 0.06)),
            var(--sn-surface-soft);
        border-bottom: 1px solid var(--sn-border);
        border-radius: 0;
        color: var(--sn-text);
    }

    .schedule-now-page .schedule-body {
        padding: 1.1rem;
    }

    .schedule-now-page .shift-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0;
    }

    .schedule-now-page .shift-title-group {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        min-width: 0;
    }

    .schedule-now-page .shift-icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--sn-blue), var(--sn-blue-deep));
        color: #ffffff;
        font-size: 1.22rem;
        box-shadow: 0 12px 22px rgba(47, 128, 237, 0.18);
    }

    .schedule-now-page .shift-kicker {
        margin-bottom: 0.15rem;
        color: var(--sn-blue);
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .schedule-now-page .shift-title {
        margin: 0;
        color: var(--sn-text);
        font-size: 1.03rem;
        font-weight: 750;
        line-height: 1.3;
        word-break: break-word;
    }

    .schedule-now-page .shift-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
        margin-top: 0.45rem;
    }

    .schedule-now-page .shift-time,
    .schedule-now-page .manpower-count,
    .schedule-now-page .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        line-height: 1;
        white-space: nowrap;
    }

    .schedule-now-page .shift-time {
        padding: 0.42rem 0.65rem;
        background: var(--sn-surface);
        border: 1px solid var(--sn-border);
        color: var(--sn-muted);
        font-family: 'Courier New', monospace;
        opacity: 1;
    }

    .schedule-now-page .manpower-count {
        padding: 0.5rem 0.75rem;
        background: rgba(47, 128, 237, 0.1);
        color: var(--sn-blue-deep);
    }

    .schedule-now-page .staff-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.75rem;
    }

    .schedule-now-page .staff-item {
        display: grid;
        grid-template-columns: auto minmax(0, 1fr) auto;
        gap: 0.85rem;
        align-items: center;
        min-height: 76px;
        padding: 0.8rem;
        border: 1px solid var(--sn-border);
        border-radius: 14px;
        background: var(--sn-surface);
        transition: border-color 0.18s ease, background 0.18s ease, transform 0.18s ease;
    }

    .schedule-now-page .staff-item:hover {
        transform: translateY(-1px);
        border-color: rgba(47, 128, 237, 0.24);
        background: var(--sn-surface-soft);
    }

    .schedule-now-page .staff-avatar {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: var(--sn-surface-muted);
        color: var(--sn-blue);
        font-size: 1.12rem;
    }

    .schedule-now-page .staff-title-row {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        min-width: 0;
        margin-bottom: 0.4rem;
    }

    .schedule-now-page .staff-id {
        flex: 0 0 auto;
        color: var(--sn-faint);
        font-size: 0.76rem;
        font-weight: 700;
    }

    .schedule-now-page .staff-info {
        min-width: 0;
    }

    .schedule-now-page .staff-name {
        min-width: 0;
        overflow: hidden;
        color: var(--sn-text);
        text-overflow: ellipsis;
        white-space: nowrap;
        font-weight: 650;
        margin-bottom: 0;
    }

    .schedule-now-page .staff-details {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
    }

    .schedule-now-page .status-badge {
        padding: 0.38rem 0.58rem;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }

    .schedule-now-page .badge-qantas {
        background: var(--sn-red-soft);
        color: var(--sn-red);
    }

    .schedule-now-page .badge-active {
        background: var(--sn-green-soft);
        color: var(--sn-green);
    }

    .schedule-now-page .badge-inactive {
        background: #edf2f7;
        color: #718096;
    }

    .schedule-now-page input:checked + .slider {
        background-color: var(--sn-green);
    }

    .schedule-now-page .empty-state {
        text-align: center;
        padding: 3.5rem 1.5rem;
        color: var(--sn-muted);
    }

    .schedule-now-page .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--sn-blue);
        opacity: 0.55;
    }

    .schedule-now-page .empty-state h4 {
        color: var(--sn-text);
    }

    html.aps-dark .schedule-now-page {
        --sn-surface: #111c31;
        --sn-surface-soft: #16243a;
        --sn-surface-muted: #162842;
        --sn-border: #263653;
        --sn-border-strong: #315071;
        --sn-text: #e7f0fb;
        --sn-muted: #a5b7cf;
        --sn-faint: #72849d;
        --sn-green: #6ee7a8;
        --sn-green-soft: rgba(34, 197, 94, 0.14);
        --sn-red: #fb7185;
        --sn-red-soft: rgba(239, 68, 68, 0.14);
        --sn-shadow: 0 18px 42px rgba(0, 0, 0, 0.22);
    }

    html.aps-dark .schedule-now-page .today-overview-main {
        background:
            radial-gradient(circle at 94% 8%, rgba(110, 231, 168, 0.14), transparent 26%),
            linear-gradient(135deg, #172942 0%, #132039 58%, #111c31 100%);
        border-color: #315071;
    }

    html.aps-dark .schedule-now-page .schedule-header {
        background:
            linear-gradient(135deg, rgba(47, 128, 237, 0.14), rgba(110, 231, 168, 0.07)),
            var(--sn-surface-soft);
    }

    html.aps-dark .schedule-now-page .badge-inactive {
        background: rgba(148, 163, 184, 0.14);
        color: #c5d2e3;
    }

    html.aps-dark .schedule-now-page .slider {
        background-color: #344760;
    }

    @media (max-width: 1199.98px) {
        .schedule-now-page .today-overview {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 991.98px) {
        .schedule-now-page .staff-list {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .schedule-now-page .today-stats {
            grid-template-columns: 1fr;
        }

        .schedule-now-page .shift-info {
            align-items: flex-start;
            flex-direction: column;
        }

        .schedule-now-page .manpower-count {
            align-self: flex-start;
        }

        .schedule-now-page .staff-item {
            grid-template-columns: auto minmax(0, 1fr);
        }

        .schedule-now-page .switch {
            grid-column: 2;
            justify-self: flex-start;
        }
    }
</style>
@endsection

@section('content')
@php
    $shiftCount = $shiftsGrouped->count();
    $totalStaff = $shiftsGrouped->sum(fn ($group) => $group['schedules']->count());
    $activeStaff = $shiftsGrouped->sum(fn ($group) => $group['schedules']->where('is_active', 1)->count());
    $qantasStaff = $shiftsGrouped->sum(fn ($group) => $group['schedules']->filter(fn ($schedule) => optional($schedule->user)->is_qantas == 1)->count());
    $nowTime = now('Asia/Jakarta')->format('H:i:s');
@endphp

<div class="container-xxl flex-grow-1 container-p-y schedule-now-page">
    <!-- Header -->
    <div class="schedule-page-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <h4 class="fw-bold pt-3 pb-1 mb-0">
            <span class="text-muted fw-light">Schedule /</span> Jadwal Hari Ini
        </h4>
        <span class="date-pill">
            <i class="bx bx-calendar"></i>
            {{ $today->format('d M Y') }}
        </span>
    </div>

    <div class="today-overview">
        <section class="today-overview-main" aria-label="Ringkasan jadwal hari ini">
            <div class="overview-kicker">
                <i class="bx bx-calendar-check"></i>
                Operasional Hari Ini
            </div>
            <h5>{{ $today->format('l, d F Y') }}</h5>
            <p>
                Ada {{ $shiftCount }} shift dengan {{ $totalStaff }} staff terjadwal. Pantau status aktif dan kebutuhan tenaga kerja dari satu tampilan.
            </p>
        </section>

        <div class="today-stats" aria-label="Statistik jadwal hari ini">
            <div class="today-stat">
                <span class="today-stat-icon"><i class="bx bx-time-five"></i></span>
                <div>
                    <div class="today-stat-value">{{ $shiftCount }}</div>
                    <div class="today-stat-label">Shift</div>
                </div>
            </div>
            <div class="today-stat">
                <span class="today-stat-icon"><i class="bx bx-group"></i></span>
                <div>
                    <div class="today-stat-value">{{ $totalStaff }}</div>
                    <div class="today-stat-label">Staff</div>
                </div>
            </div>
            <div class="today-stat">
                <span class="today-stat-icon"><i class="bx bx-check-circle"></i></span>
                <div>
                    <div class="today-stat-value">{{ $activeStaff }}</div>
                    <div class="today-stat-label">Aktif</div>
                </div>
            </div>
            <div class="today-stat">
                <span class="today-stat-icon"><i class="bx bx-star"></i></span>
                <div>
                    <div class="today-stat-value">{{ $qantasStaff }}</div>
                    <div class="today-stat-label">Qantas</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Cards -->
    <div class="row">
        <div class="col-12">
            @forelse ($shiftsGrouped as $group)
            @php
                $shift = $group['shift'];
                $startTime = $shift->start_time;
                $endTime = $shift->end_time;
                $isCurrentShift = $startTime <= $endTime
                    ? ($nowTime >= $startTime && $nowTime <= $endTime)
                    : ($nowTime >= $startTime || $nowTime <= $endTime);
            @endphp
            <div class="schedule-card {{ $isCurrentShift ? 'is-current' : '' }}">
                <div class="schedule-header">
                    <div class="shift-info">
                        <div class="shift-title-group">
                            <span class="shift-icon">
                                <i class="bx bx-calendar-event"></i>
                            </span>
                            <div>
                                <div class="shift-kicker">{{ $isCurrentShift ? 'Sedang Berjalan' : 'Shift Terjadwal' }}</div>
                                <h5 class="shift-title">Shift {{ $shift->id }} - {{ $shift->description }}</h5>
                                <div class="shift-meta">
                                    <span class="shift-time">
                                        <i class="bx bx-time-five"></i>
                                        {{ $startTime }} - {{ $endTime }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="manpower-count">
                            <i class="bx bx-user"></i>
                            {{ $shift->use_manpower }} Orang
                        </div>
                    </div>
                </div>
                <div class="schedule-body">
                    <div class="staff-list">
                    @foreach ($group['schedules'] as $schedule)
                    <div class="staff-item">
                        <span class="staff-avatar">
                            <i class="bx bx-user"></i>
                        </span>
                        <div class="staff-info">
                            <div class="staff-title-row">
                                <div class="staff-name">{{ $schedule->user->fullname ?? 'Tidak ditemukan' }}</div>
                                <span class="staff-id">#{{ $schedule->user_id }}</span>
                            </div>
                            <div class="staff-details">
                                @if ($schedule->user && $schedule->user->is_qantas == 1)
                                <span class="status-badge badge-qantas">Qantas</span>
                                @endif
                                @if ($schedule->user && $schedule->is_active == 1)
                                <span class="status-badge badge-active">Aktif</span>
                                @elseif ($schedule->user && $schedule->is_active == 0)
                                <span class="status-badge badge-inactive">Nonaktif</span>
                                @endif
                            </div>
                        </div>
                        
                        @if(auth()->user()->role == 'Leader Apron' || in_array(auth()->user()->role, ['SPV Bge','SPV Apron']))
                        <label class="switch">
                            <input type="checkbox"
                                class="attendance-toggle"
                                data-id="{{ $schedule->id }}"
                                {{ $schedule->is_active ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                        @endif
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="bx bx-calendar-x"></i>
                <h4>Tidak ada jadwal untuk hari ini</h4>
                <p class="text-muted">Tidak ditemukan jadwal shift untuk tanggal {{ $today->format('d M Y') }}</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle attendance toggle
        $(document).on('change', '.attendance-toggle', function() {
            let scheduleId = $(this).data('id');
            let isActive = $(this).is(':checked') ? 1 : 0;
            let switchElement = $(this);

            // Show loading state
            switchElement.prop('disabled', true);

            $.ajax({
                url: '/schedules/update-active',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: scheduleId,
                    is_active: isActive
                },
                success: function(res) {
                    console.log(res.message);
                    // Show success feedback
                    showNotification('Status berhasil diupdate', 'success');

                    // Reload data directly
                    location.reload();
                },
                error: function(err) {
                    console.error('Gagal update status:', err);
                    // Revert the toggle on error
                    switchElement.prop('checked', !isActive);
                    showNotification('Gagal update status!', 'error');
                },
                complete: function() {
                    switchElement.prop('disabled', false);
                }
            });
        });

        function showNotification(message, type) {
            // You can integrate with template's notification system
            // For now, using a simple alert
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            // Prepend to content area
            $('.container-p-y').prepend(alertHtml);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                $('.alert').alert('close');
            }, 3000);
        }
    });
</script>
@endsection
