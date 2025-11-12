@extends('layout.admin')

@section('title', 'Create New Shift')

@section('styles')
<style>
    .form-card {
        background: #fff;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.375rem rgba(161, 172, 184, 0.12);
        border: 1px solid #d9dee3;
        max-width: 600px;
        margin: 0 auto;
    }

    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #4180c3 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 0.75rem 0.75rem 0 0;
        text-align: center;
    }

    .form-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #566a7f;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d9dee3;
        border-radius: 0.5rem;
        font-size: 0.9375rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .btn-group {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    .btn-submit {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
    }

    .btn-back {
        background: #6c757d;
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-back:hover {
        background: #5a6268;
        transform: translateY(-1px);
        color: white;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .time-input-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-hint {
        font-size: 0.875rem;
        color: #697a8d;
        margin-top: 0.25rem;
    }

    @media (max-width: 768px) {
        .form-body {
            padding: 1.5rem;
        }

        .time-input-group {
            grid-template-columns: 1fr;
        }

        .btn-group {
            flex-direction: column-reverse;
        }

        .btn-submit, .btn-back {
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
                    <span class="text-muted fw-light">Schedule / Shift /</span> Create New
                </h4>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">
                        <i class="bx bx-plus-circle me-1"></i>
                        New Shift
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-12">
            <div class="form-card">
                <div class="form-header">
                    <h4 class="mb-0">
                        <i class="bx bx-time me-2"></i>Create New Shift
                    </h4>
                    <p class="mb-0 opacity-75">Tambahkan shift baru ke dalam sistem</p>
                </div>

                <div class="form-body">
                    <!-- Error Messages -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('shift.store') }}" method="POST" id="shiftForm">
                        @csrf

                        <div class="form-group">
                            <label class="form-label" for="id">Shift ID *</label>
                            <input type="text" class="form-control" name="id" id="id"
                                   placeholder="Contoh: S1, S2, S3"
                                   value="{{ old('id') }}"
                                   required>
                            <div class="form-hint">ID unik untuk shift (huruf dan angka)</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="name">Nama Shift *</label>
                            <select class="form-select" name="name" id="name" required>
                                <option value="">Pilih shift</option>
                                <option value="Pagi">Pagi</option>
                                <option value="Siang">Siang</option>
                                <option value="Malam">Malam</option>
                            </select>
                            <div class="form-hint">Nama deskriptif untuk shift</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="description">Deskripsi</label>
                            <input type="text" class="form-control" name="description" id="description"
                                   placeholder="Contoh: Shift operasional pagi hari"
                                   value="{{ old('description') }}">
                            <div class="form-hint">Penjelasan tambahan tentang shift</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jam Kerja *</label>
                            <div class="time-input-group">
                                <div>
                                    <label class="form-label" for="start_time">Jam Mulai</label>
                                    <input type="time" class="form-control" name="start_time" id="start_time"
                                           value="{{ old('start_time') }}" required>
                                </div>
                                <div>
                                    <label class="form-label" for="end_time">Jam Berakhir</label>
                                    <input type="time" class="form-control" name="end_time" id="end_time"
                                           value="{{ old('end_time') }}" required>
                                </div>
                            </div>
                            <div class="form-hint">Format 24 jam (HH:MM)</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="use_manpower">Tenaga Kerja *</label>
                            <input type="number" class="form-control" name="use_manpower" id="use_manpower"
                                   placeholder="Contoh: 5"
                                   value="{{ old('use_manpower') }}"
                                   min="1" max="50" required>
                            <div class="form-hint">Jumlah staff yang dibutuhkan per shift</div>
                        </div>

                        <div class="btn-group">
                            <a href="{{ route('shift.index') }}" class="btn-back">
                                <i class="bx bx-arrow-back me-2"></i> BACK
                            </a>
                            <button type="submit" class="btn-submit">
                                <i class="bx bx-save me-2"></i> CREATE SHIFT
                            </button>
                        </div>
                    </form>
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
                        <i class="bx bx-info-circle me-2"></i> Panduan Membuat Shift
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    <strong>Shift ID</strong> harus unik dan tidak boleh duplikat
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-time text-primary me-2"></i>
                                    Pastikan <strong>Jam Mulai</strong> sebelum <strong>Jam Berakhir</strong>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bx bx-user text-info me-2"></i>
                                    <strong>Tenaga Kerja</strong> menentukan kuota staff per shift
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-edit text-warning me-2"></i>
                                    Data dapat diubah kembali melalui menu edit
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
        const form = document.getElementById('shiftForm');
        const startTime = document.getElementById('start_time');
        const endTime = document.getElementById('end_time');

        // Time validation
        function validateTime() {
            if (startTime.value && endTime.value) {
                if (startTime.value >= endTime.value) {
                    endTime.setCustomValidity('Jam berakhir harus setelah jam mulai');
                    endTime.style.borderColor = '#e53e3e';
                } else {
                    endTime.setCustomValidity('');
                    endTime.style.borderColor = '#d9dee3';
                }
            }
        }

        startTime.addEventListener('change', validateTime);
        endTime.addEventListener('change', validateTime);

        // Form submission handling
        form.addEventListener('submit', function(e) {
            // Validate time before submission
            validateTime();

            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();

                // Show error message
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please check the form fields and try again.',
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                // Show loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bx bx-loader bx-spin me-2"></i> Creating...';
                submitBtn.disabled = true;

                // Re-enable after 3 seconds if still processing
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 3000);
            }
        });

        // Input formatting for shift ID
        const shiftIdInput = document.getElementById('id');
        shiftIdInput.addEventListener('input', function(e) {
            this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        });

        // Add real-time validation feedback
        const inputs = form.querySelectorAll('input[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.style.borderColor = '#e53e3e';
                } else {
                    this.style.borderColor = '#48bb78';
                }
            });

            input.addEventListener('focus', function() {
                this.style.borderColor = '#667eea';
            });
        });
    });
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
