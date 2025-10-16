@extends('layout.admin')


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
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Training /</span> Manajemen Training
    </h4>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Seluruh Sertifikat</h5>
            <a href="{{ route('training.create') }}" class="btn btn-primary">Tambah Sertifikat</a>
        </div>
        <div class="card-body">
            <form action="{{ route('training.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari nama, NIP, atau nama sertifikat..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    @if (request('search'))
                        <a href="{{ route('training.index') }}" class="btn btn-outline-danger">Reset</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive text-nowrap">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            {{-- Header disesuaikan agar sesuai dengan data binding yang ada --}}
                            <th>NIP</th>
                            <th>Nama Staff</th>
                            <th>Nama Sertifikat</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Status</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($certificates as $certificate)
                            {{-- Kelas untuk styling status kadaluarsa/mendekati kadaluarsa --}}
                            <tr
                                class="{{ $certificate->is_expiring_soon ? 'bg-label-warning' : ($certificate->is_expired ? 'bg-label-danger' : '') }}">
                                {{-- Kolom Data --}}
                                <td><strong>{{ $certificate->user_id ?? 'N/A' }}</strong></td>
                                <td>{{ $certificate->fullname ?? 'N/A' }}</td>
                                <td>{{ $certificate->certificate_name }}</td>
                                <td>{{ $certificate->start_date->format('d M Y') }}</td>
                                <td>{{ $certificate->end_date->format('d M Y') }}</td>

                                {{-- Kolom Status --}}
                                <td>
                                    @if ($certificate->is_expired)
                                        <span class="badge bg-danger">Kadaluarsa
                                            ({{ $certificate->end_date->diffForHumans(now(), true) }} lalu)
                                        </span>
                                    @elseif ($certificate->is_expiring_soon)
                                        <span class="badge bg-warning text-dark">Akan Kadaluarsa (Sisa
                                            {{ $certificate->remaining_days }} hari)</span>
                                    @else
                                        <span class="badge bg-success">Aktif</span>
                                    @endif
                                </td>

                                {{-- Kolom File --}}
                                <td>
                                    @if ($certificate->certificate_file)
                                        {{-- Menggunakan icon boxicon dari admin layout --}}
                                        <a href="{{ Storage::url($certificate->certificate_file) }}" target="_blank"
                                            class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Lihat File">
                                            <i class='bx bx-file'></i>
                                        </a>
                                    @else
                                        {{ $certificate->certificate_file }}
                                    @endif
                                </td>

                                {{-- Kolom Aksi --}}
                                <td class="d-flex align-items-center gap-2">
                                    <a href="{{ route('training.edit', $certificate->id) }}" class="action-btn"
                                        title="Edit Certificate">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('training.destroy', $certificate->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn border-0" title="Delete Shift"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')"
                                            style="background: red;">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Paginasi --}}
            <div class="mt-3">
                {{ $certificates->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
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
