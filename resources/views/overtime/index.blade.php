@extends('layout.admin')

@section('title', 'Riwayat Lembur')

@section('styles')
    <style>
        .table-responsive {
            border-radius: 0.75rem;
            overflow: hidden;
            overflow-x: auto;
        }

        .overtime-table {
            width: 100%;
            table-layout: auto;
        }

        .overtime-table th {
            background: #f8fbff;
            font-weight: 600;
            color: #718096;
            padding: 1rem;
            border-bottom: 1px solid #e5edf7;
        }

        .overtime-table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #edf2f7;
        }

        .overtime-table tr:hover {
            background-color: #f8fbff;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background: #2f80ed;
            color: white;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background: #2368c8;
            transform: translateY(-1px);
            color: white;
        }

        .stats-card {
            background: linear-gradient(135deg, #2f80ed 0%, #2368c8 52%, #174ea6 100%);
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 18px 38px rgba(47, 128, 237, 0.2);
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
            background: linear-gradient(135deg, #2f80ed 0%, #2368c8 100%);
            border: none;
            border-radius: 0.65rem;
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
            box-shadow: 0 14px 24px rgba(47, 128, 237, 0.24);
            color: white;
        }

        .badge-ot {
            background: linear-gradient(135deg, #2f80ed, #2368c8);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .date-badge {
            background: #eef5ff;
            color: #35506d;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }

        .duration-badge {
            background: #eaf4ff;
            color: #2368c8;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 600;
        }

        html.aps-dark .overtime-table tr:hover td {
            background-color: #172942 !important;
        }

        html.aps-dark .date-badge,
        html.aps-dark .duration-badge {
            background: #162842 !important;
            color: #8fc2ff !important;
            border: 1px solid rgba(47, 128, 237, 0.24);
        }

        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }

            .overtime-table th,
            .overtime-table td {
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
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1">
                    <h4 class="fw-bold pt-3 pb-1 mb-0">
                        <span class="text-muted fw-light">Lembur /</span> Riwayat Lembur
                    </h4>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary">
                            <i class="bx bx-time me-1"></i>
                            {{ $overtimes->count() }} Pengajuan
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="stats-card">
                    <div class="stats-number">{{ $overtimes->count() }}</div>
                    <div class="stats-label">Total Riwayat Lembur</div>
                    <small>Daftar pengajuan lembur Anda</small>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1">
                    <div>
                        <h5 class="mb-0">Daftar Lembur</h5>
                        <p class="text-muted mb-0">Kelola riwayat pengajuan lembur Anda</p>
                    </div>
                    <a href="{{ route('overtime.create') }}" class="create-btn">
                        <i class="bx bx-plus-circle"></i> Ajukan Lembur
                    </a>
                </div>
            </div>
        </div>

        <!-- Overtime Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover overtime-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Judul</th>
                                        <th>Durasi</th>
                                        <th>Status</th>
                                        <th>Direspon Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($overtimes as $ot)
                                        <tr>
                                            <td>
                                                <span class="badge-ot">#{{ $ot->id }}</span>
                                            </td>
                                            <td>
                                                <span class="date-badge">{{ date('d M Y', strtotime($ot->date)) }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $ot->title }}</strong>
                                            </td>
                                            <td>
                                                <span class="duration-badge">
                                                    <i class="bx bx-time-five me-1"></i>
                                                    {{ $ot->duration }} Jam
                                                </span>
                                            </td>
                                            <td>
                                                @if ($ot->status == 'Pending')
                                                    <span class="badge bg-warning"><i class="bx bx-loader bx-spin me-1"></i> Menunggu</span>
                                                @elseif($ot->status == 'Approved')
                                                    <span class="badge bg-success"><i class="bx bx-check-circle me-1"></i> Disetujui</span>
                                                @else
                                                    <span class="badge bg-danger"><i class="bx bx-x-circle me-1"></i> Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $ot->approved_by ?? '-' }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="text-center py-5">
                                                    <i class="bx bx-time bx-lg text-muted mb-3" style="font-size: 4rem;"></i>
                                                    <h5 class="text-muted">Belum ada data lembur</h5>
                                                    <p class="text-muted">Mulai dengan mengajukan lembur pertama Anda</p>
                                                    <a href="{{ route('overtime.create') }}" class="create-btn mt-3">
                                                        <i class="bx bx-plus-circle"></i> Ajukan Lembur
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-4 d-flex justify-content-end">
                            {{ $overtimes->links('vendor.pagination.custom') }}
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
            const tableRows = document.querySelectorAll('.overtime-table tbody tr');
            tableRows.forEach(row => {
                if(!row.querySelector('.text-center.py-5')){
                    row.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateX(4px)';
                        this.style.transition = 'all 0.2s ease';
                    });

                    row.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateX(0)';
                    });
                }
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
