@extends('layout.admin')

@section('title', 'Edit Data User')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">

        {{-- Header dengan Breadcrumb --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Edit Data User</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.apron') }}">Daftar User</a></li>
                    <li class="breadcrumb-item active">Edit User</li>
                </ol>
            </nav>
        </div>

        {{-- Card Form Edit --}}
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-edit me-2"></i>Edit Data Staff
                        </h5>
                        <p class="mb-0 mt-1 small opacity-75">Perbarui informasi data user {{ $user->fullname }}</p>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6 class="alert-heading">Terjadi kesalahan:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('users.update', $user->id) }}" method="POST" id="editUserForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="page" value="{{ $page }}">
                            
                            <div class="row">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">NIP</label>
                                        <input type="text" class="form-control" name="id" value="{{ $user->id }}" readonly>
                                        <small class="text-muted">NIP tidak dapat diubah</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="fullname" 
                                               value="{{ old('fullname', $user->fullname) }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" 
                                               value="{{ old('email', $user->email) }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Station <span class="text-danger">*</span></label>
                                        <select name="station" class="form-select" required>
                                            <option value="Office-CGK" {{ old('station', $user->station) == 'Office-CGK' ? 'selected' : '' }}>Office CGK</option>
                                            <option value="CGK" {{ old('station', $user->station) == 'CGK' ? 'selected' : '' }}>CGK</option>
                                            <option value="DPS" {{ old('station', $user->station) == 'DPS' ? 'selected' : '' }}>DPS</option>
                                            <option value="KNO" {{ old('station', $user->station) == 'KNO' ? 'selected' : '' }}>KNO</option>
                                            <option value="UPG" {{ old('station', $user->station) == 'UPG' ? 'selected' : '' }}>UPG</option>
                                            <option value="SUB" {{ old('station', $user->station) == 'SUB' ? 'selected' : '' }}>SUB</option>
                                            <option value="KJT" {{ old('station', $user->station) == 'KJT' ? 'selected' : '' }}>KJT</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Job Title <span class="text-danger">*</span></label>
                                        <select name="JobTitle" class="form-select" required>
                                            <option value="PASSENGER HANDLING" {{ old('JobTitle', $user->JobTitle) == 'PASSENGER HANDLING' ? 'selected' : '' }}>PASSENGER HANDLING</option>
                                            <option value="BAGGAGE HANDLING" {{ old('JobTitle', $user->JobTitle) == 'BAGGAGE HANDLING' ? 'selected' : '' }}>BAGGAGE HANDLING</option>
                                            <option value="RAMP HANDLING" {{ old('JobTitle', $user->JobTitle) == 'RAMP HANDLING' ? 'selected' : '' }}>RAMP HANDLING</option>
                                            <option value="CARGO HANDLING" {{ old('JobTitle', $user->JobTitle) == 'CARGO HANDLING' ? 'selected' : '' }}>CARGO HANDLING</option>
                                            <option value="AIRCRAFT SERVICE" {{ old('JobTitle', $user->JobTitle) == 'AIRCRAFT SERVICE' ? 'selected' : '' }}>AIRCRAFT SERVICE</option>
                                            <option value="SUPPORTING UNIT" {{ old('JobTitle', $user->JobTitle) == 'SUPPORTING UNIT' ? 'selected' : '' }}>SUPPORTING UNIT</option>
                                            <option value="OFFICE / ADMINISTRATION" {{ old('JobTitle', $user->JobTitle) == 'OFFICE / ADMINISTRATION' ? 'selected' : '' }}>OFFICE / ADMINISTRATION</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Cluster <span class="text-danger">*</span></label>
                                        <select name="Cluster" class="form-select" required>
                                            <option value="GROUND HANDLING" {{ old('Cluster', $user->Cluster) == 'GROUND HANDLING' ? 'selected' : '' }}>GROUND HANDLING</option>
                                            <option value="OFFICE" {{ old('Cluster', $user->Cluster) == 'OFFICE' ? 'selected' : '' }}>OFFICE</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="gender" class="form-select" required>
                                            <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Kolom Kanan --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Unit <span class="text-danger">*</span></label>
                                        <select name="Unit" class="form-select" required>
                                            <option value="FLIGHT OPERATION" {{ old('Unit', $user->Unit) == 'FLIGHT OPERATION' ? 'selected' : '' }}>FLIGHT OPERATION</option>
                                            <option value="RAMP HANDLING" {{ old('Unit', $user->Unit) == 'RAMP HANDLING' ? 'selected' : '' }}>RAMP HANDLING</option>
                                            <option value="BAGGAGE HANDLING" {{ old('Unit', $user->Unit) == 'BAGGAGE HANDLING' ? 'selected' : '' }}>BAGGAGE HANDLING</option>
                                            <option value="HEAD OFFICE" {{ old('Unit', $user->Unit) == 'HEAD OFFICE' ? 'selected' : '' }}>HEAD OFFICE</option>
                                            <option value="PASSENGER HANDLING" {{ old('Unit', $user->Unit) == 'PASSENGER HANDLING' ? 'selected' : '' }}>PASSENGER HANDLING</option>
                                            <option value="SUPPORTING / MANAGEMENT" {{ old('Unit', $user->Unit) == 'SUPPORTING / MANAGEMENT' ? 'selected' : '' }}>SUPPORTING / MANAGEMENT</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Sub Unit <span class="text-danger">*</span></label>
                                        <select name="SubUnit" class="form-select" required>
                                            <option value="PORTER APRON" {{ old('SubUnit', $user->SubUnit) == 'PORTER APRON' ? 'selected' : '' }}>PORTER APRON</option>
                                            <option value="PORTER CARGO" {{ old('SubUnit', $user->SubUnit) == 'PORTER CARGO' ? 'selected' : '' }}>PORTER CARGO</option>
                                            <option value="PORTER MAKE-UP" {{ old('SubUnit', $user->SubUnit) == 'PORTER MAKE-UP' ? 'selected' : '' }}>PORTER MAKE-UP</option>
                                            <option value="AIRCRAFT INTERIOR CLEANING" {{ old('SubUnit', $user->SubUnit) == 'AIRCRAFT INTERIOR CLEANING' ? 'selected' : '' }}>AIRCRAFT INTERIOR CLEANING</option>
                                            <option value="DISPATCHER" {{ old('SubUnit', $user->SubUnit) == 'DISPATCHER' ? 'selected' : '' }}>DISPATCHER</option>
                                            <option value="CONTROLLER" {{ old('SubUnit', $user->SubUnit) == 'CONTROLLER' ? 'selected' : '' }}>CONTROLLER</option>
                                            <option value="DRIVER" {{ old('SubUnit', $user->SubUnit) == 'DRIVER' ? 'selected' : '' }}>DRIVER</option>
                                            <option value="AVSEC" {{ old('SubUnit', $user->SubUnit) == 'AVSEC' ? 'selected' : '' }}>AVSEC</option>
                                            <option value="RAMP" {{ old('SubUnit', $user->SubUnit) == 'RAMP' ? 'selected' : '' }}>RAMP</option>
                                            <option value="PASASI" {{ old('SubUnit', $user->SubUnit) == 'PASASI' ? 'selected' : '' }}>PASASI</option>
                                            <option value="QUALITY CONTROL" {{ old('SubUnit', $user->SubUnit) == 'QUALITY CONTROL' ? 'selected' : '' }}>QUALITY CONTROL</option>
                                            <option value="HEALTH, SAFETY, AND ENVIRONMENT" {{ old('SubUnit', $user->SubUnit) == 'HEALTH, SAFETY, AND ENVIRONMENT' ? 'selected' : '' }}>HEALTH, SAFETY, AND ENVIRONMENT (HSE)</option>
                                            <option value="HEAD OF AIRPORT SERVICES" {{ old('SubUnit', $user->SubUnit) == 'HEAD OF AIRPORT SERVICES' ? 'selected' : '' }}>HEAD OF AIRPORT SERVICES</option>
                                            <option value="HEAD STATION" {{ old('SubUnit', $user->SubUnit) == 'HEAD STATION' ? 'selected' : '' }}>HEAD STATION</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Role <span class="text-danger">*</span></label>
                                        <select name="role" class="form-select" required>
                                            <option value="ADMIN" {{ old('role', $user->role) == 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
                                            <option value="ASS LEADER" {{ old('role', $user->role) == 'ASS LEADER' ? 'selected' : '' }}>ASS LEADER</option>
                                            <option value="CHIEF" {{ old('role', $user->role) == 'CHIEF' ? 'selected' : '' }}>CHIEF</option>
                                            <option value="DISPATCHER" {{ old('role', $user->role) == 'DISPATCHER' ? 'selected' : '' }}>DISPATCHER</option>
                                            <option value="DRIVER" {{ old('role', $user->role) == 'DRIVER' ? 'selected' : '' }}>DRIVER</option>
                                            <option value="HSE" {{ old('role', $user->role) == 'HSE' ? 'selected' : '' }}>HSE</option>
                                            <option value="LEADER" {{ old('role', $user->role) == 'LEADER' ? 'selected' : '' }}>LEADER</option>
                                            <option value="PORTER" {{ old('role', $user->role) == 'PORTER' ? 'selected' : '' }}>PORTER</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Manager <span class="text-danger">*</span></label>
                                        <select name="Manager" class="form-select" required>
                                            <option value="HAURA SHAFA AFANIN" {{ old('Manager', $user->Manager) == 'HAURA SHAFA AFANIN' ? 'selected' : '' }}>HAURA SHAFA AFANIN (24080101002)</option>
                                            <option value="TRI UTAMI RHAHAYU" {{ old('Manager', $user->Manager) == 'TRI UTAMI RHAHAYU' ? 'selected' : '' }}>TRI UTAMI RHAHAYU (24080101001)</option>
                                            <option value="SISI FADILLAH" {{ old('Manager', $user->Manager) == 'SISI FADILLAH' ? 'selected' : '' }}>SISI FADILLAH (24080101003)</option>
                                            <option value="DIMAS RAFI HADITIYO" {{ old('Manager', $user->Manager) == 'DIMAS RAFI HADITIYO' ? 'selected' : '' }}>DIMAS RAFI HADITIYO (24080101004)</option>
                                            <option value="MULYADI" {{ old('Manager', $user->Manager) == 'MULYADI' ? 'selected' : '' }}>MULYADI (102240008)</option>
                                            <option value="JUNAIDI" {{ old('Manager', $user->Manager) == 'JUNAIDI' ? 'selected' : '' }}>JUNAIDI (102240006)</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Senior Manager</label>
                                        <select name="SeniorManager" class="form-select">
                                            <option value="SUBCHAN" {{ old('SeniorManager', $user->SeniorManager) == 'SUBCHAN' ? 'selected' : '' }}>SUBCHAN (507040102)</option>
                                            <option value="ADE IRWAN EFFENDI" {{ old('SeniorManager', $user->SeniorManager) == 'ADE IRWAN EFFENDI' ? 'selected' : '' }}>ADE IRWAN EFFENDI (102240243)</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Qantas</label>
                                        <select name="is_qantas" class="form-select">
                                            <option value="1" {{ old('is_qantas', $user->is_qantas) == 1 ? 'selected' : '' }}>Ya</option>
                                            <option value="0" {{ old('is_qantas', $user->is_qantas) == 0 ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Join Date</label>
                                        <input type="date" class="form-control" name="join_date" value="{{ old('join_date', $user->join_date) }}">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Gaji</label>
                                        <input type="number" class="form-control" name="salary" value="{{ old('salary', $user->salary) }}">
                                        <small class="text-muted">Masukkan angka tanpa format (contoh: 5000000)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-info">
                                    <i class="bx bx-save me-1"></i>UPDATE DATA
                                </button>
                                <a href="{{ route('users.apron', ['page' => $page]) }}" class="btn btn-secondary">
                                    <i class="bx bx-arrow-back me-1"></i>KEMBALI
                                </a>
                            </div>
                        </form>
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
        // Validasi form sebelum submit
        const form = document.getElementById('editUserForm');
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Harap isi semua field yang wajib diisi',
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                // Konfirmasi sebelum submit
                e.preventDefault();
                Swal.fire({
                    title: 'Update Data User?',
                    text: 'Apakah Anda yakin ingin memperbarui data user ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4180c3',
                    cancelButtonColor: '#8592a3',
                    confirmButtonText: 'Ya, Update!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bootstrapAlert = new bootstrap.Alert(alert);
                bootstrapAlert.close();
            });
        }, 5000);
        
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endsection

@section('styles')
<style>
    .is-invalid {
        border-color: #dc3545;
    }
    
    .form-label {
        font-weight: 500;
    }
    
    .text-danger {
        color: #dc3545;
    }
</style>
@endsection