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
            background: #f8fbff;
            font-weight: 600;
            color: #718096;
            padding: 1rem;
            border-bottom: 1px solid #e5edf7;
        }

        .shift-table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #edf2f7;
        }

        .shift-table tr:hover {
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

        .badge-shift {
            background: linear-gradient(135deg, #2f80ed, #2368c8);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .time-badge {
            background: #eef5ff;
            color: #35506d;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }

        .manpower-badge {
            background: #eaf4ff;
            color: #2368c8;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 600;
        }

        html.aps-dark .shift-table tr:hover td {
            background-color: #172942 !important;
        }

        html.aps-dark .time-badge,
        html.aps-dark .manpower-badge {
            background: #162842 !important;
            color: #8fc2ff !important;
            border: 1px solid rgba(47, 128, 237, 0.24);
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
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1">
                    <h4 class="fw-bold pt-3 pb-1 mb-0">
                        <span class="text-muted fw-light">Schedule /</span> Shift Management
                    </h4>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary">
                            <i class="ti ti-clock me-1"></i>
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
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1">
                    <div>
                        <h5 class="mb-0">Daftar Shift</h5>
                        <p class="text-muted mb-0">Kelola semua shift yang tersedia</p>
                    </div>
                    <a href="{{ route('shift.create') }}" class="create-btn">
                        <i class="ti ti-plus"></i> Create New Shift
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
                                                    <i class="ti ti-user me-1"></i>
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
                                                @if (in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'Head Of Airport Service', 'LEADER']))
                                                    <a href="{{ route('shift.edit', $shift->id) }}" class="action-btn"
                                                        title="Edit Shift">
                                                        <i class="ti ti-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('shift.destroy', $shift->id) }}" method="POST"
                                                        class="d-inline" id="delete-form-{{ $shift->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="action-btn bg-danger border-0"
                                                            title="Delete Shift"
                                                            onclick="confirmDeleteShift('{{ $shift->id }}')">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-label-secondary">No Access</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Empty State -->
                        @if ($shifts->isEmpty())
                            <div class="text-center py-5">
                                <i class="ti ti-clock-hour-4 text-muted mb-3" style="font-size: 4rem;"></i>
                                <h5 class="text-muted">Belum ada shift</h5>
                                <p class="text-muted">Mulai dengan membuat shift pertama Anda</p>
                                <a href="{{ route('shift.create') }}" class="create-btn mt-3">
                                    <i class="ti ti-plus"></i> Create First Shift
                                </a>
                            </div>
                        @endif

                        {{-- Pagination --}}
                        <div class="dt-pagination-wrapper">
                            {{ $shifts->links('vendor.pagination.custom') }}
                        </div>
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

        function confirmDeleteShift(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data shift yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: '<i class="bx bx-trash me-1"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gunakan encoding atau escape jika ID mengandung karakter khusus
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    @if (session('success') || session('error'))
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endif
@endsection
