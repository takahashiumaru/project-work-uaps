@extends('layout.admin')

@section('title', 'Detail Profil User')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="py-4">

        {{-- Header dengan Breadcrumb --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Detail Profil User</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.apron', ['page' => $page]) }}">Daftar User</a></li>
                    <li class="breadcrumb-item active">Detail User</li>
                </ol>
            </nav>
        </div>

        {{-- Card Utama --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-user-circle me-2"></i>Informasi Detail User
                        </h5>
                        <p class="mb-0 mt-1 small opacity-75">Data lengkap profil {{ $user->fullname }}</p>
                    </div>
                    <div class="card-body">

                        {{-- Profil Header dengan Foto --}}
                        <div class="row mb-5">
                            <div class="col-md-4 text-center">
                                <form id="photoForm" method="POST" enctype="multipart/form-data" action="{{ route('user.updatePhoto', ['userId' => $user->id]) }}">
                                    @csrf
                                    <input type="file" name="profile_picture" id="fileInput" style="display: none;" onchange="document.getElementById('photoForm').submit();">
                                    <div class="text-center">
                                        <label for="fileInput" style="cursor: pointer; position: relative;">
                                            <img src="{{ $user->profile_picture ? asset('storage/photo/' . $user->profile_picture) : asset('storage/photo/user.jpg') }}"
                                                alt="User Photo"
                                                class="img-thumbnail rounded-circle mb-3"
                                                style="width: 180px; height: 180px; object-fit: cover; border: 4px solid #dee2e6;">
                                            <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2" style="width: 40px; height: 40px;">
                                                <i class="bx bx-camera text-white"></i>
                                            </div>
                                        </label>
                                        <h4 class="fw-bold mt-3">{{ $user->fullname }}</h4>
                                        <span class="badge bg-primary fs-6">{{ $user->role ?? 'No Role' }}</span>
                                        <p class="text-muted mt-2">{{ $user->JobTitle ?? 'No Job Title' }}</p>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8">
                                {{-- Quick Stats --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light border-0">
                                            <div class="card-body text-center">
                                                <i class="bx bx-building fs-1 text-primary mb-2"></i>
                                                <h5 class="card-title">{{ $user->station ?? 'N/A' }}</h5>
                                                <p class="card-text text-muted">Station</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light border-0">
                                            <div class="card-body text-center">
                                                <i class="bx bx-calendar fs-1 text-success mb-2"></i>
                                                <h5 class="card-title">{{ $user->join_date ? \Carbon\Carbon::parse($user->join_date)->translatedFormat('d M Y') : 'N/A' }}</h5>
                                                <p class="card-text text-muted">Join Date</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status Info --}}
                                <div class="row">
                                    <div class="col-12">
                                        @php
                                            $contractStatus = 'success';
                                            $contractText = 'Aktif';
                                            $contractIcon = 'bx-check-circle';
                                            
                                            if ($user->contract_end) {
                                                $now = strtotime(date('Y-m-d'));
                                                $expired = strtotime($user->contract_end);
                                                $diff = $expired - $now;
                                                $months = floor($diff / (30 * 60 * 60 * 24));
                                                
                                                if ($months <= 2 && $months >= 0) {
                                                    $contractStatus = 'warning';
                                                    $contractText = 'Akan Berakhir';
                                                    $contractIcon = 'bx-time-five';
                                                } elseif ($months < 0) {
                                                    $contractStatus = 'danger';
                                                    $contractText = 'Kadaluarsa';
                                                    $contractIcon = 'bx-x-circle';
                                                }
                                            }
                                        @endphp
                                        <div class="alert alert-{{ $contractStatus }}">
                                            <div class="d-flex align-items-center">
                                                <i class="bx {{ $contractIcon }} me-2 fs-4"></i>
                                                <div>
                                                    <strong>Status Kontrak: {{ $contractText }}</strong>
                                                    @if ($user->contract_end)
                                                        <div class="small">Berlaku hingga: {{ \Carbon\Carbon::parse($user->contract_end)->translatedFormat('d M Y') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Data Pribadi --}}
                        <div class="row">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-4">
                                    <i class="bx bx-id-card me-2"></i>Data Pribadi
                                </h5>
                                
                                <div class="row">
                                    {{-- Kolom 1 --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">NIP</label>
                                            <input type="text" class="form-control" value="{{ $user->id }}" readonly>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Email</label>
                                            <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Job Title</label>
                                            <input type="text" class="form-control" value="{{ $user->job_title }}" readonly>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Unit</label>
                                            <input type="text" class="form-control" value="{{ $user->unit }}" readonly>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Manager</label>
                                            <input type="text" class="form-control" value="{{ $user->manager }}" readonly>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                                            <input type="text" class="form-control" value="{{ $user->gender }}" readonly>
                                        </div>
                                    </div>

                                    {{-- Kolom 2 --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Station</label>
                                            <input type="text" class="form-control" value="{{ $user->station }}" readonly>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Cluster</label>
                                            <input type="text" class="form-control" value="{{ $user->cluster }}" readonly>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Sub Unit</label>
                                            <input type="text" class="form-control" value="{{ $user->sub_unit }}" readonly>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Senior Manager</label>
                                            <input type="text" class="form-control" value="{{ $user->senior_manager }}" readonly>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status</label>
                                            <input type="text" class="form-control" value="{{ $user->status }}" readonly>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tanggal Bergabung</label>
                                            <input type="text" class="form-control" value="{{ $user->join_date ? \Carbon\Carbon::parse($user->join_date)->translatedFormat('d M Y') : 'N/A' }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                {{-- Informasi Kontrak --}}
                                @if (in_array(Auth::user()->role, ['ADMIN', 'ASS LEADER', 'CHIEF', 'LEADER']))
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="border-bottom pb-2 mb-3">Informasi Kontrak</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Mulai Kontrak</label>
                                                    <input type="text" class="form-control" value="{{ $user->contract_start ? \Carbon\Carbon::parse($user->contract_start)->translatedFormat('d M Y') : 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Akhir Kontrak</label>
                                                    <input type="text" class="form-control" value="{{ $user->contract_end ? \Carbon\Carbon::parse($user->contract_end)->translatedFormat('d M Y') : 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                {{-- Informasi PAS --}}
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="border-bottom pb-2 mb-3">Informasi PAS</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">PAS Terdaftar</label>
                                                    <input type="text" class="form-control" value="{{ $user->pas_registered ? \Carbon\Carbon::parse($user->pas_registered)->translatedFormat('d M Y') : 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">PAS Berakhir</label>
                                                    <input type="text" class="form-control" value="{{ $user->pas_expired ? \Carbon\Carbon::parse($user->pas_expired)->translatedFormat('d M Y') : 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Informasi Gaji --}}
                                @if (in_array(Auth::user()->role, ['Admin', 'Ass Leader', 'Chief', 'Leader', 'Finance']))
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="border-bottom pb-2 mb-3">Informasi Gaji</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Gaji</label>
                                                    <input type="text" class="form-control" value="Rp {{ $user->salary ? number_format((float)$user->salary, 0, ',', '.') : 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="text-end mt-4">
                            <a href="{{ route('users.edit', ['user' => $user->id, 'page' => $page]) }}" class="btn btn-warning">
                                <i class="bx bx-edit me-1"></i>Edit Data
                            </a>
                            <a href="{{ route('users.apron', ['page' => $page]) }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .form-control:read-only {
        background-color: #f8f9fa;
        border-color: #e9ecef;
    }
    
    .img-thumbnail {
        transition: transform 0.3s ease;
    }
    
    .img-thumbnail:hover {
        transform: scale(1.05);
    }
    
    .border-bottom {
        border-color: #dee2e6 !important;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // SweetAlert untuk notifikasi
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

        // Konfirmasi sebelum upload foto
        const fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const fileSize = this.files[0].size / 1024 / 1024; // MB
                    const fileType = this.files[0].type;
                    
                    if (!fileType.match('image.*')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format File Tidak Valid',
                            text: 'Harap pilih file gambar (JPG, PNG, GIF)',
                            timer: 3000,
                            showConfirmButton: false
                        });
                        this.value = '';
                        return;
                    }
                    
                    if (fileSize > 2) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 2MB',
                            timer: 3000,
                            showConfirmButton: false
                        });
                        this.value = '';
                        return;
                    }
                    
                    Swal.fire({
                        title: 'Unggah Foto Profil?',
                        text: 'Apakah Anda yakin ingin mengubah foto profil?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#4180c3',
                        cancelButtonColor: '#8592a3',
                        confirmButtonText: 'Ya, Unggah!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('photoForm').submit();
                        } else {
                            this.value = '';
                        }
                    });
                }
            });
        }
    });
</script>
@endsection