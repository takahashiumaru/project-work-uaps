@extends('layout.admin')

@section('title', 'Create / Update Schedule')

@section('styles')
<style>
    .table-fixed {
        table-layout: fixed;
    }

    .table-fixed th:nth-child(1),
    .table-fixed td:nth-child(1) {
        width: 120px;
    }

    .table-fixed th:nth-child(2),
    .table-fixed td:nth-child(2) {
        width: 250px;
    }

    .table-fixed th:nth-child(3),
    .table-fixed td:nth-child(3) {
        width: 150px;
    }

    .table-fixed th:nth-child(4),
    .table-fixed td:nth-child(4) {
        width: 100px;
        text-align: center;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 0.7rem;
        background: #eaf4ff;
        border: 1px solid rgba(47, 128, 237, 0.18);
        color: #2368c8;
        box-shadow: none;
        text-decoration: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease, color 0.18s ease;
    }

    .action-btn:hover {
        background: linear-gradient(135deg, #2f80ed 0%, #2368c8 100%);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(47, 128, 237, 0.22);
    }

    .action-btn i {
        font-size: 1rem;
        line-height: 1;
    }

    .schedule-toolbar {
        align-items: stretch;
        row-gap: 0.85rem;
    }

    .search-box {
        max-width: 320px;
        margin-left: auto;
        border-radius: 0.9rem;
        overflow: hidden;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
    }

    .search-box .form-control {
        height: 44px;
        border-radius: 0.9rem 0 0 0.9rem;
        background: #f9fafb;
        border-color: #e6edf5;
        font-size: 0.86rem;
    }

    .search-box .btn {
        width: 46px;
        border-radius: 0 0.9rem 0.9rem 0;
        box-shadow: none !important;
    }

    .stats-card {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #2f80ed 0%, #2368c8 62%, #174ea6 100%);
        color: white;
        border-radius: 1rem;
        padding: 1.35rem 1.45rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.16);
        box-shadow: 0 16px 34px rgba(47, 128, 237, 0.22);
    }

    .stats-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 92% 10%, rgba(255, 255, 255, 0.28), transparent 24%),
            linear-gradient(135deg, rgba(255, 255, 255, 0.15), transparent 45%);
        pointer-events: none;
    }

    .stats-card > * {
        position: relative;
        z-index: 1;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 750;
        margin-bottom: 0.35rem;
        line-height: 1;
    }

    .stats-label {
        opacity: 0.92;
        font-size: 0.86rem;
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    .stats-card small {
        color: rgba(255, 255, 255, 0.78) !important;
    }

    .auto-create-btn {
        background: linear-gradient(135deg, #2f80ed 0%, #2368c8 100%);
        border: 1px solid rgba(47, 128, 237, 0.18);
        border-radius: 0.85rem;
        min-height: 44px;
        padding: 0.72rem 1.2rem;
        color: white;
        font-weight: 650;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
        box-shadow: 0 12px 24px rgba(47, 128, 237, 0.22);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .auto-create-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 30px rgba(47, 128, 237, 0.28);
        color: white;
    }

    .role-badge {
        font-size: 0.74rem;
        padding: 0.34rem 0.62rem;
        border-radius: 999px;
        font-weight: 600;
    }

    .user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.75rem;
        border: 2px solid rgba(47, 128, 237, 0.14);
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
    }

    .user-info {
        display: flex;
        align-items: center;
        min-width: 0;
    }

    .user-info span {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    html.aps-dark .stats-card {
        background:
            radial-gradient(circle at 92% 10%, rgba(47, 128, 237, 0.22), transparent 28%),
            linear-gradient(135deg, #111c31 0%, #132039 100%);
        border-color: #263653;
        box-shadow: 0 18px 46px rgba(0, 0, 0, 0.22);
    }

    html.aps-dark .action-btn {
        background: rgba(47, 128, 237, 0.16);
        border-color: rgba(47, 128, 237, 0.28);
        color: #8fc2ff;
    }

    html.aps-dark .action-btn:hover {
        background: linear-gradient(135deg, #2f80ed 0%, #2368c8 100%);
        color: #ffffff;
    }

    html.aps-dark .search-box {
        box-shadow: none;
    }

    html.aps-dark .search-box .form-control {
        background: #101a2c !important;
        border-color: #2a3a55 !important;
        color: #e6edf7 !important;
    }

    html.aps-dark .user-avatar {
        border-color: #2a3a55;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.24);
    }

    html.aps-dark .card-title,
    html.aps-dark .user-info span,
    html.aps-dark .table strong {
        color: #edf5ff !important;
    }

    html.aps-dark .table tbody tr.schedule-hover td {
        background: #172942 !important;
    }

    @media (max-width: 768px) {
        .schedule-toolbar {
            gap: 0.85rem;
        }

        .search-box {
            max-width: 100%;
            margin-left: 0;
        }

        .auto-create-btn {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }

        .user-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .user-avatar {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }

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
                    <span class="text-muted fw-light">Schedule /</span> Create / Update Schedule
                </h4>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">
                        <i class="bx bx-user me-1"></i>
                        {{ $user->total() }} Users
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stats-card">
                <div class="stats-number">{{ $user->total() }}</div>
                <div class="stats-label">Total Users dalam Sistem</div>
                <small>Manage jadwal untuk semua user yang terdaftar</small>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-4 schedule-toolbar">
        <div class="col-md-6">
            <form id="autoCreateForm" action="{{ route('schedule.autoCreate') }}" method="POST">
                @csrf
                <button type="submit" class="auto-create-btn">
                    <i class="bx bx-plus-circle me-2"></i> Auto Create Schedule
                </button>
            </form>
        </div>
        <div class="col-md-6">
            <form action="{{ route('schedule.view') }}" method="GET">
                <div class="input-group search-box">
                    <input type="text" name="search" class="form-control" placeholder="Cari NIP atau Nama..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-list-ul me-2"></i> Daftar User
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-fixed">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Fullname</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $users)
                                <tr>
                                    <td>
                                        <strong>{{ $users->id }}</strong>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <img src="{{ $users->profile_picture ? asset('storage/photo/' . $users->profile_picture) : asset('storage/photo/user.jpg') }}"
                                                alt="{{ $users->fullname }}"
                                                class="user-avatar">
                                            <span>{{ $users->fullname }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary role-badge">{{ $users->role }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('schedule.edit', ['schedule' => $users->id, 'page' => request('page')]) }}"
                                            class="action-btn" title="Edit Schedule">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="dt-pagination-wrapper">
                        {{ $user->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bx bx-info-circle me-2"></i> Informasi
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    Klik tombol "Auto Create Schedule" untuk generate jadwal otomatis
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-edit text-primary me-2"></i>
                                    Klik icon edit untuk mengatur jadwal individual user
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bx bx-search text-info me-2"></i>
                                    Gunakan search box untuk mencari user tertentu
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-user text-warning me-2"></i>
                                    Total user yang ditampilkan: {{ $user->total() }}
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto Create Schedule with SweetAlert
        document.getElementById('autoCreateForm').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Auto Create Schedule',
                text: 'Apakah Anda yakin ingin membuat jadwal secara otomatis?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#48bb78',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Proses!',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve) => {
                        // Submit the form
                        e.target.submit();
                        resolve();
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        });

        // Add hover effects to table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.classList.add('schedule-hover');
                this.style.transform = 'translateX(2px)';
            });

            row.addEventListener('mouseleave', function() {
                this.classList.remove('schedule-hover');
                this.style.transform = 'translateX(0)';
            });
        });

        // Add click effect to action buttons
        const actionButtons = document.querySelectorAll('.action-btn');
        actionButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="bx bx-loader bx-spin"></i>';
                this.style.pointerEvents = 'none';

                setTimeout(() => {
                    this.innerHTML = originalHtml;
                    this.style.pointerEvents = 'auto';
                }, 1000);
            });
        });

        // Search box functionality
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    this.form.submit();
                }
            });
        }
    });

    // Show notification if there's a search term
    @if(request('search'))
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Pencarian',
            text: @json('Menampilkan hasil untuk: ' . request('search')),
            icon: 'info',
            timer: 3000,
            showConfirmButton: false
        });
    });
    @endif
</script>
@endsection
