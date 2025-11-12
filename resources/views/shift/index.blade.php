@extends('layout.admin')

@section('title', 'Shift Management')

@section('styles')
    <style>
        .table-responsive {
            border-radius: 0.75rem;
            overflow: hidden;
            overflow-x: auto;
        }

        .shift-table {
            width: 100%;
            table-layout: auto;
        }

        .shift-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #566a7f;
            padding: 1rem;
            border-bottom: 2px solid #e9ecef;
        }

        .shift-table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .shift-table tr:hover {
            background-color: #f8f9fa;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background: #667eea;
            color: white;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background: #5a6fd8;
            transform: translateY(-1px);
            color: white;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #4180c3 100%);
            color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            opacity: 0.9;
            font-size: 0.875rem;
        }

        .create-btn {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .create-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
            color: white;
        }

        .badge-shift {
            background: #667eea;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .time-badge {
            background: #e9ecef;
            color: #566a7f;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }

        .manpower-badge {
            background: #ffeaa7;
            color: #2d3436;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }

            .shift-table th,
            .shift-table td {
                padding: 0.75rem 0.5rem;
            }

            .create-btn {
                width: 100%;
                justify-content: center;
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
                        <span class="text-muted fw-light">Schedule /</span> Shift Management
                    </h4>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary">
                            <i class="bx bx-time me-1"></i>
                            {{ $shifts->count() }} Shifts
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="stats-card">
                    <div class="stats-number">{{ $shifts->count() }}</div>
                    <div class="stats-label">Total Shift dalam Sistem</div>
                    <small>Kelola jadwal shift untuk operasional harian</small>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Daftar Shift</h5>
                        <p class="text-muted mb-0">Kelola semua shift yang tersedia</p>
                    </div>
                    <a href="{{ route('shift.create') }}" class="create-btn">
                        <i class="bx bx-plus-circle"></i> Create New Shift
                    </a>
                </div>
            </div>
        </div>

        <!-- Shift Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover shift-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Berakhir</th>
                                        <th>Tenaga Kerja</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shifts as $shift)
                                        <tr>
                                            <td>
                                                <span class="badge-shift">#{{ $shift->id }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $shift->name }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $shift->description }}</span>
                                            </td>
                                            <td>
                                                <span class="time-badge">{{ $shift->start_time }}</span>
                                            </td>
                                            <td>
                                                <span class="time-badge">{{ $shift->end_time }}</span>
                                            </td>
                                            <td>
                                                <span class="manpower-badge">
                                                    <i class="bx bx-user me-1"></i>
                                                    {{ $shift->use_manpower }} Orang
                                                </span>
                                            </td>
                                            <td>
                                                <small
                                                    class="text-muted">{{ $shift->created_at->format('d M Y, H:i') }}</small>
                                            </td>
                                            <td>
                                                <small
                                                    class="text-muted">{{ $shift->updated_at->format('d M Y, H:i') }}</small>
                                            </td>
                                            <td class="d-flex align-items-center gap-2">
                                                <a href="{{ route('shift.edit', $shift->id) }}" class="action-btn"
                                                    title="Edit Shift">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Empty State -->
                        @if ($shifts->isEmpty())
                            <div class="text-center py-5">
                                <i class="bx bx-time bx-lg text-muted mb-3" style="font-size: 4rem;"></i>
                                <h5 class="text-muted">Belum ada shift</h5>
                                <p class="text-muted">Mulai dengan membuat shift pertama Anda</p>
                                <a href="{{ route('shift.create') }}" class="create-btn mt-3">
                                    <i class="bx bx-plus-circle"></i> Create First Shift
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Information Card -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="bx bx-info-circle me-2"></i> Informasi Shift Management
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="bx bx-check-circle text-success me-2"></i>
                                        Setiap shift memiliki jam kerja dan kebutuhan tenaga kerja
                                    </li>
                                    <li class="mb-2">
                                        <i class="bx bx-time text-primary me-2"></i>
                                        Format waktu menggunakan 24 jam (HH:MM)
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="bx bx-user text-info me-2"></i>
                                        Tenaga kerja menentukan jumlah staff per shift
                                    </li>
                                    <li class="mb-2">
                                        <i class="bx bx-edit text-warning me-2"></i>
                                        Klik icon edit untuk mengubah data shift
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
            // Add hover effects to table rows
            const tableRows = document.querySelectorAll('.shift-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(4px)';
                    this.style.transition = 'all 0.2s ease';
                });

                row.addEventListener('mouseleave', function() {
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

            // Show success message if there's any in session
            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
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
    @if (session('success') || session('error'))
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endif
@endsection
