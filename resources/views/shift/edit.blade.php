@extends('layout.admin')

@section('title', 'Edit Shift')

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
        background: linear-gradient(135deg, #f59e0b 0%, #d69e2e 100%);
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
    
    .form-control:read-only {
        background-color: #f8f9fa;
        color: #6c757d;
        cursor: not-allowed;
    }
    
    .btn-group {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }
    
    .btn-update {
        background: linear-gradient(135deg, #f59e0b 0%, #d69e2e 100%);
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .btn-update:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
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
    
    .shift-info {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    
    .info-label {
        font-weight: 600;
        color: #566a7f;
    }
    
    .info-value {
        color: #697a8d;
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
        
        .btn-update, .btn-back {
            width: 100%;
            justify-content: center;
        }
        
        .info-item {
            flex-direction: column;
            gap: 0.25rem;
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
                    <span class="text-muted fw-light">Schedule / Shift /</span> Edit Shift
                </h4>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning">
                        <i class="bx bx-edit me-1"></i>
                        Editing Shift #{{ $shift->id }}
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
                        <i class="bx bx-edit me-2"></i>Edit Shift #{{ $shift->id }}
                    </h4>
                    <p class="mb-0 opacity-75">Update informasi shift yang sudah ada</p>
                </div>
                
                <div class="form-body">
                    <!-- Shift Information -->
                    <div class="shift-info">
                        <div class="info-item">
                            <span class="info-label">Created At:</span>
                            <span class="info-value">{{ $shift->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Last Updated:</span>
                            <span class="info-value">{{ $shift->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Current Status:</span>
                            <span class="info-value">
                                <span class="badge bg-label-success">Active</span>
                            </span>
                        </div>
                    </div>

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

                    <form action="{{ route('shift.update', $shift->id) }}" method="POST" id="shiftForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label class="form-label" for="id">Shift ID</label>
                            <input type="text" class="form-control" name="id" id="id" 
                                   value="{{ $shift->id }}" readonly>
                            <div class="form-hint">ID shift tidak dapat diubah</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="name">Nama Shift *</label>
                            <input type="text" class="form-control" name="name" id="name" 
                                   placeholder="Contoh: Shift Pagi, Shift Siang, Shift Malam" 
                                   value="{{ old('name', $shift->name) }}"
                                   required>
                            <div class="form-hint">Nama deskriptif untuk shift</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="description">Deskripsi</label>
                            <input type="text" class="form-control" name="description" id="description" 
                                   placeholder="Contoh: Shift operasional pagi hari" 
                                   value="{{ old('description', $shift->description) }}">
                            <div class="form-hint">Penjelasan tambahan tentang shift</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jam Kerja *</label>
                            <div class="time-input-group">
                                <div>
                                    <label class="form-label" for="start_time">Jam Mulai</label>
                                    <input type="time" class="form-control" name="start_time" id="start_time" 
                                           value="{{ old('start_time', $shift->start_time) }}" required>
                                </div>
                                <div>
                                    <label class="form-label" for="end_time">Jam Berakhir</label>
                                    <input type="time" class="form-control" name="end_time" id="end_time" 
                                           value="{{ old('end_time', $shift->end_time) }}" required>
                                </div>
                            </div>
                            <div class="form-hint">Format 24 jam (HH:MM)</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="use_manpower">Tenaga Kerja *</label>
                            <input type="number" class="form-control" name="use_manpower" id="use_manpower" 
                                   placeholder="Contoh: 5" 
                                   value="{{ old('use_manpower', $shift->use_manpower) }}"
                                   min="1" max="50" required>
                            <div class="form-hint">Jumlah staff yang dibutuhkan per shift</div>
                        </div>

                        <div class="btn-group">
                            <a href="{{ route('shift.index') }}" class="btn-back">
                                <i class="bx bx-arrow-back me-2"></i> BACK TO LIST
                            </a>
                            <button type="submit" class="btn-update">
                                <i class="bx bx-save me-2"></i> UPDATE SHIFT
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
                        <i class="bx bx-info-circle me-2"></i> Informasi Edit Shift
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    <strong>Shift ID</strong> tidak dapat diubah untuk menjaga konsistensi data
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-time text-primary me-2"></i>
                                    Perubahan <strong>Jam Kerja</strong> akan mempengaruhi jadwal yang sudah ada
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bx bx-user text-info me-2"></i>
                                    <strong>Tenaga Kerja</strong> yang diubah akan berlaku untuk jadwal mendatang
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-history text-warning me-2"></i>
                                    Data sebelumnya: {{ $shift->created_at->format('d M Y') }}
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
                    return false;
                } else {
                    endTime.setCustomValidity('');
                    endTime.style.borderColor = '#48bb78';
                    return true;
                }
            }
            return true;
        }

        startTime.addEventListener('change', validateTime);
        endTime.addEventListener('change', validateTime);

        // Check if there are changes in the form
        function hasFormChanges() {
            const originalData = {
                name: '{{ $shift->name }}',
                description: '{{ $shift->description }}',
                start_time: '{{ $shift->start_time }}',
                end_time: '{{ $shift->end_time }}',
                use_manpower: '{{ $shift->use_manpower }}'
            };

            const currentData = {
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                start_time: document.getElementById('start_time').value,
                end_time: document.getElementById('end_time').value,
                use_manpower: document.getElementById('use_manpower').value
            };

            return JSON.stringify(originalData) !== JSON.stringify(currentData);
        }

        // Form submission handling
        form.addEventListener('submit', function(e) {
            // Validate time before submission
            if (!validateTime()) {
                e.preventDefault();
                e.stopPropagation();
                
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Jam berakhir harus setelah jam mulai.',
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false
                });
                return;
            }

            if (!hasFormChanges()) {
                e.preventDefault();
                Swal.fire({
                    title: 'No Changes',
                    text: 'Tidak ada perubahan yang dilakukan.',
                    icon: 'info',
                    timer: 3000,
                    showConfirmButton: false
                });
                return;
            }

            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bx bx-loader bx-spin me-2"></i> Updating...';
            submitBtn.disabled = true;
            
            // Re-enable after 3 seconds if still processing
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });

        // Warn user if trying to leave with unsaved changes
        window.addEventListener('beforeunload', function(e) {
            if (hasFormChanges()) {
                e.preventDefault();
                e.returnValue = '';
            }
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

        // Initialize time validation on load
        validateTime();
    });
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection