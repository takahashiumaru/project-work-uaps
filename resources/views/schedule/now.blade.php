@extends('layout.admin')

@section('title', 'Jadwal Hari Ini')

@section('styles')
<style>
    .schedule-card {
        background: #fff;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.375rem rgba(161, 172, 184, 0.12);
        border: 1px solid #d9dee3;
        margin-bottom: 1.5rem;
    }

    .schedule-header {
        background: linear-gradient(135deg, #667eea 0%, #4180c3 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.75rem 0.75rem 0 0;
    }

    .schedule-body {
        padding: 1.5rem;
    }

    .staff-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .staff-item:last-child {
        border-bottom: none;
    }

    .staff-info {
        flex: 1;
    }

    .staff-name {
        font-weight: 600;
        color: #566a7f;
        margin-bottom: 0.25rem;
    }

    .staff-details {
        font-size: 0.875rem;
        color: #697a8d;
    }

    .badge-qantas {
        background-color: #e53e3e;
        color: white;
    }

    .badge-active {
        background-color: #48bb78;
        color: white;
    }

    .badge-inactive {
        background-color: #a0aec0;
        color: white;
    }

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

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #697a8d;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d9dee3;
    }

    .shift-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .shift-time {
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .manpower-count {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .staff-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
        
        .switch {
            align-self: flex-end;
        }
        
        .shift-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
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
                    <span class="text-muted fw-light">Schedule /</span> Jadwal Hari Ini
                </h4>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">
                        <i class="bx bx-calendar me-1"></i>
                        {{ $today->format('d M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Cards -->
    <div class="row">
        <div class="col-12">
            @forelse ($shiftsGrouped as $group)
            <div class="schedule-card">
                <div class="schedule-header">
                    <div class="shift-info">
                        <div>
                            <h5 class="mb-1">Shift {{ $group['shift']->id }} - {{ $group['shift']->description }}</h5>
                            <div class="shift-time">
                                {{ $group['shift']->start_time }} - {{ $group['shift']->end_time }}
                            </div>
                        </div>
                        <div class="manpower-count">
                            <i class="bx bx-user me-1"></i>
                            {{ $group['shift']->use_manpower }} Orang
                        </div>
                    </div>
                </div>
                <div class="schedule-body">
                    @foreach ($group['schedules'] as $schedule)
                    <div class="staff-item">
                        <div class="staff-info">
                            <div class="staff-name">
                                {{ $schedule->user->fullname ?? 'Tidak ditemukan' }}
                                <small class="text-muted">({{ $schedule->user_id }})</small>
                            </div>
                            <div class="staff-details">
                                @if ($schedule->user && $schedule->user->is_qantas == 1)
                                <span class="badge badge-qantas me-2">Qantas</span>
                                @endif
                                @if ($schedule->user && $schedule->is_active == 1)
                                <span class="badge badge-active">Active</span>
                                @elseif ($schedule->user && $schedule->is_active == 0)
                                <span class="badge badge-inactive">Non Active</span>
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

        // Add hover effects to schedule cards
        $('.schedule-card').hover(
            function() {
                $(this).css('transform', 'translateY(-2px)');
                $(this).css('box-shadow', '0 4px 12px rgba(161, 172, 184, 0.2)');
            },
            function() {
                $(this).css('transform', 'translateY(0)');
                $(this).css('box-shadow', '0 0.125rem 0.375rem rgba(161, 172, 184, 0.12)');
            }
        );
    });
</script>
@endsection