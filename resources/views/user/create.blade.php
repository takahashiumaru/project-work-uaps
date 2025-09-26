@extends('layout.admin')

@section('title', 'Tambah User Baru')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">

        {{-- Header dengan Breadcrumb --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Tambah User Baru</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.apron') }}">Daftar User</a></li>
                    <li class="breadcrumb-item active">Tambah User</li>
                </ol>
            </nav>
        </div>

        {{-- Card Form Create --}}
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-user-plus me-2"></i>Form Tambah User Baru
                        </h5>
                        <p class="mb-0 mt-1 small opacity-75">Isi form berikut untuk menambahkan user baru ke sistem</p>
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

                        <form action="{{ route('users.store') }}" method="POST" id="createUserForm">
                            @csrf
                            
                            <div class="row">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">NIP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="id" 
                                               placeholder="Masukkan NIP" value="{{ old('id') }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="fullname" 
                                               placeholder="Masukkan nama lengkap" value="{{ old('fullname') }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" 
                                               placeholder="Masukkan email" value="{{ old('email') }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Station <span class="text-danger">*</span></label>
                                        <select name="station" class="form-select" required>
                                            <option value="">-- Pilih Station --</option>
                                            <option value="Office-CGK" {{ old('station') == 'Office-CGK' ? 'selected' : '' }}>Office CGK</option>
                                            <option value="CGK" {{ old('station') == 'CGK' ? 'selected' : '' }}>CGK</option>
                                            <option value="DPS" {{ old('station') == 'DPS' ? 'selected' : '' }}>DPS</option>
                                            <option value="KNO" {{ old('station') == 'KNO' ? 'selected' : '' }}>KNO</option>
                                            <option value="UPG" {{ old('station') == 'UPG' ? 'selected' : '' }}>UPG</option>
                                            <option value="SRG" {{ old('station') == 'SRG' ? 'selected' : '' }}>SRG</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Job Title <span class="text-danger">*</span></label>
                                        <select name="JobTitle" class="form-select" required>
                                            <option value="">-- Pilih Job Title --</option>
                                            <option value="PASSENGER HANDLING" {{ old('JobTitle') == 'PASSENGER HANDLING' ? 'selected' : '' }}>PASSENGER HANDLING</option>
                                            <option value="BAGGAGE HANDLING" {{ old('JobTitle') == 'BAGGAGE HANDLING' ? 'selected' : '' }}>BAGGAGE HANDLING</option>
                                            <option value="RAMP HANDLING" {{ old('JobTitle') == 'RAMP HANDLING' ? 'selected' : '' }}>RAMP HANDLING</option>
                                            <option value="CARGO HANDLING" {{ old('JobTitle') == 'CARGO HANDLING' ? 'selected' : '' }}>CARGO HANDLING</option>
                                            <option value="AIRCRAFT SERVICE" {{ old('JobTitle') == 'AIRCRAFT SERVICE' ? 'selected' : '' }}>AIRCRAFT SERVICE</option>
                                            <option value="SUPPORTING UNIT" {{ old('JobTitle') == 'SUPPORTING UNIT' ? 'selected' : '' }}>SUPPORTING UNIT</option>
                                            <option value="OFFICE / ADMINISTRATION" {{ old('JobTitle') == 'OFFICE / ADMINISTRATION' ? 'selected' : '' }}>OFFICE / ADMINISTRATION</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Cluster <span class="text-danger">*</span></label>
                                        <select name="Cluster" class="form-select" required>
                                            <option value="GROUND HANDLING" {{ old('Cluster') == 'GROUND HANDLING' ? 'selected' : '' }}>GROUND HANDLING</option>
                                            <option value="OFFICE" {{ old('Cluster') == 'OFFICE' ? 'selected' : '' }}>OFFICE</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="gender" class="form-select" required>
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Kolom Kanan --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Unit <span class="text-danger">*</span></label>
                                        <select name="Unit" class="form-select" required>
                                            <option value="">-- Pilih Unit --</option>
                                            <option value="FLIGHT OPERATION" {{ old('Unit') == 'FLIGHT OPERATION' ? 'selected' : '' }}>FLIGHT OPERATION</option>
                                            <option value="RAMP HANDLING" {{ old('Unit') == 'RAMP HANDLING' ? 'selected' : '' }}>RAMP HANDLING</option>
                                            <option value="BAGGAGE HANDLING" {{ old('Unit') == 'BAGGAGE HANDLING' ? 'selected' : '' }}>BAGGAGE HANDLING</option>
                                            <option value="HEAD OFFICE" {{ old('Unit') == 'HEAD OFFICE' ? 'selected' : '' }}>HEAD OFFICE</option>
                                            <option value="PASSENGER HANDLING" {{ old('Unit') == 'PASSENGER HANDLING' ? 'selected' : '' }}>PASSENGER HANDLING</option>
                                            <option value="SUPPORTING / MANAGEMENT" {{ old('Unit') == 'SUPPORTING / MANAGEMENT' ? 'selected' : '' }}>SUPPORTING / MANAGEMENT</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Sub Unit <span class="text-danger">*</span></label>
                                        <select name="SubUnit" class="form-select" required>
                                            <option value="">-- Pilih Sub Unit --</option>
                                            <option value="PORTER APRON" {{ old('SubUnit') == 'PORTER APRON' ? 'selected' : '' }}>PORTER APRON</option>
                                            <option value="PORTER CARGO" {{ old('SubUnit') == 'PORTER CARGO' ? 'selected' : '' }}>PORTER CARGO</option>
                                            <option value="PORTER MAKE-UP" {{ old('SubUnit') == 'PORTER MAKE-UP' ? 'selected' : '' }}>PORTER MAKE-UP</option>
                                            <option value="AIRCRAFT INTERIOR CLEANING" {{ old('SubUnit') == 'AIRCRAFT INTERIOR CLEANING' ? 'selected' : '' }}>AIRCRAFT INTERIOR CLEANING</option>
                                            <option value="DISPATCHER" {{ old('SubUnit') == 'DISPATCHER' ? 'selected' : '' }}>DISPATCHER</option>
                                            <option value="CONTROLLER" {{ old('SubUnit') == 'CONTROLLER' ? 'selected' : '' }}>CONTROLLER</option>
                                            <option value="DRIVER" {{ old('SubUnit') == 'DRIVER' ? 'selected' : '' }}>DRIVER</option>
                                            <option value="AVSEC" {{ old('SubUnit') == 'AVSEC' ? 'selected' : '' }}>AVSEC</option>
                                            <option value="RAMP" {{ old('SubUnit') == 'RAMP' ? 'selected' : '' }}>RAMP</option>
                                            <option value="PASASI" {{ old('SubUnit') == 'PASASI' ? 'selected' : '' }}>PASASI</option>
                                            <option value="QUALITY CONTROL" {{ old('SubUnit') == 'QUALITY CONTROL' ? 'selected' : '' }}>QUALITY CONTROL</option>
                                            <option value="HEALTH, SAFETY, AND ENVIRONMENT" {{ old('SubUnit') == 'HEALTH, SAFETY, AND ENVIRONMENT' ? 'selected' : '' }}>HEALTH, SAFETY, AND ENVIRONMENT (HSE)</option>
                                            <option value="HEAD OF AIRPORT SERVICES" {{ old('SubUnit') == 'HEAD OF AIRPORT SERVICES' ? 'selected' : '' }}>HEAD OF AIRPORT SERVICES</option>
                                            <option value="HEAD STATION" {{ old('SubUnit') == 'HEAD STATION' ? 'selected' : '' }}>HEAD STATION</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Role <span class="text-danger">*</span></label>
                                        <select name="role" class="form-select" required>
                                            <option value="">-- Pilih Role --</option>
                                            <option value="ADMIN" {{ old('role') == 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
                                            <option value="ASS LEADER" {{ old('role') == 'ASS LEADER' ? 'selected' : '' }}>ASS LEADER</option>
                                            <option value="CHIEF" {{ old('role') == 'CHIEF' ? 'selected' : '' }}>CHIEF</option>
                                            <option value="DISPATCHER" {{ old('role') == 'DISPATCHER' ? 'selected' : '' }}>DISPATCHER</option>
                                            <option value="DRIVER" {{ old('role') == 'DRIVER' ? 'selected' : '' }}>DRIVER</option>
                                            <option value="HSE" {{ old('role') == 'HSE' ? 'selected' : '' }}>HSE</option>
                                            <option value="LEADER" {{ old('role') == 'LEADER' ? 'selected' : '' }}>LEADER</option>
                                            <option value="PORTER" {{ old('role') == 'PORTER' ? 'selected' : '' }}>PORTER</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Manager <span class="text-danger">*</span></label>
                                        <select name="Manager" class="form-select" required>
                                            <option value="">-- Pilih Manager --</option>
                                            <option value="HAURA SHAFA AFANIN" {{ old('Manager') == 'HAURA SHAFA AFANIN' ? 'selected' : '' }}>HAURA SHAFA AFANIN (24080101002)</option>
                                            <option value="TRI UTAMI RHAHAYU" {{ old('Manager') == 'TRI UTAMI RHAHAYU' ? 'selected' : '' }}>TRI UTAMI RHAHAYU (24080101001)</option>
                                            <option value="SISI FADILLAH" {{ old('Manager') == 'SISI FADILLAH' ? 'selected' : '' }}>SISI FADILLAH (24080101003)</option>
                                            <option value="DIMAS RAFI HADITIYO" {{ old('Manager') == 'DIMAS RAFI HADITIYO' ? 'selected' : '' }}>DIMAS RAFI HADITIYO (24080101004)</option>
                                            <option value="MULYADI" {{ old('Manager') == 'MULYADI' ? 'selected' : '' }}>MULYADI (102240008)</option>
                                            <option value="JUNAIDI" {{ old('Manager') == 'JUNAIDI' ? 'selected' : '' }}>JUNAIDI (102240006)</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Senior Manager</label>
                                        <select name="SeniorManager" class="form-select">
                                            <option value="">-- Pilih Senior Manager --</option>
                                            <option value="SUBCHAN" {{ old('SeniorManager') == 'SUBCHAN' ? 'selected' : '' }}>SUBCHAN (507040102)</option>
                                            <option value="ADE IRWAN EFFENDI" {{ old('SeniorManager') == 'ADE IRWAN EFFENDI' ? 'selected' : '' }}>ADE IRWAN EFFENDI (102240243)</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Qantas</label>
                                        <select name="is_qantas" class="form-select">
                                            <option value="">-- Pilih --</option>
                                            <option value="1" {{ old('is_qantas') == '1' ? 'selected' : '' }}>Ya</option>
                                            <option value="0" {{ old('is_qantas') == '0' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Join Date</label>
                                        <input type="date" class="form-control" name="join_date" value="{{ old('join_date') }}">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Gaji</label>
                                        <input type="text" class="form-control" name="salary_display" id="salary_display" 
                                               placeholder="Masukkan gaji" value="{{ old('salary_display') }}">
                                        <input type="hidden" name="salary" id="salary">
                                        <small class="text-muted">Format: 5.000.000</small>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-info">
                                    <i class="bx bx-save me-1"></i>CREATE USER
                                </button>
                                <a href="{{ route('users.apron') }}" class="btn btn-warning">
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
        // Format currency untuk gaji
        const salaryDisplay = document.getElementById('salary_display');
        const salaryHidden = document.getElementById('salary');
        
        if (salaryDisplay) {
            salaryDisplay.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                let formattedValue = formatRupiah(value);
                e.target.value = formattedValue;
                salaryHidden.value = value;
            });
            
            // Format initial value jika ada
            if (salaryDisplay.value) {
                let value = salaryDisplay.value.replace(/\D/g, '');
                salaryDisplay.value = formatRupiah(value);
                salaryHidden.value = value;
            }
        }
        
        function formatRupiah(value) {
            if (!value) return '';
            return new Intl.NumberFormat('id-ID').format(value);
        }
        
        // Validasi form sebelum submit
        const form = document.getElementById('createUserForm');
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
                    title: 'Buat User Baru?',
                    text: 'Apakah Anda yakin ingin membuat user baru dengan data yang telah diisi?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4180c3',
                    cancelButtonColor: '#8592a3',
                    confirmButtonText: 'Ya, Buat User!',
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