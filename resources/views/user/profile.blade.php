@extends('layout.admin')

@section('title', 'Profil Pengguna')

@section('styles')
<style>
    .profile-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #667eea;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .profile-photo:hover {
        border-color: #4180c3;
        transform: scale(1.05);
    }

    .personal-data-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        width: 100%;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #566a7f;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d9dee3;
        border-radius: 0.5rem;
        background-color: #f8f9fa;
        color: #697a8d;
        font-size: 0.9375rem;
        transition: all 0.2s ease;
    }

    .form-control:disabled {
        background-color: #e9ecef;
        color: #6c757d;
        cursor: not-allowed;
    }

    .section-title {
        color: #566a7f;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .profile-card {
        background: #fff;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.375rem rgba(161, 172, 184, 0.12);
        border: 1px solid #d9dee3;
    }

    .profile-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .profile-info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #566a7f;
    }

    .info-value {
        color: #697a8d;
        text-align: right;
    }

    @media (max-width: 768px) {
        .personal-data-form {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .profile-photo {
            width: 120px;
            height: 120px;
        }
        
        .profile-info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        
        .info-value {
            text-align: left;
        }
    }

    @media (max-width: 576px) {
        .container-p-y {
            padding: 1rem !important;
        }
        
        .profile-card {
            margin: 0 -1rem;
            border-radius: 0;
            border-left: none;
            border-right: none;
        }
    }

    .text-primary {
        color: #667eea !important;
    }

    .border-primary {
        border-color: #667eea !important;
    }

    .badge-primary {
        background-color: #667eea;
        color: white;
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
                    <span class="text-muted fw-light">Profile /</span> {{ $user->fullname }}
                </h4>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">{{ $user->role }}</span>
                    <span class="badge bg-label-secondary">{{ $user->station }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="row">
        <div class="col-lg-4 col-md-5">
            <div class="card profile-card mb-4">
                <div class="card-body text-center">
                    <!-- Photo Form -->
                    <form id="photoForm" method="POST" enctype="multipart/form-data" action="{{ route('user.updatePhoto', ['userId' => $user->id]) }}">
                        @csrf
                        <input type="file" name="profile_picture" id="fileInput" style="display: none;" onchange="document.getElementById('photoForm').submit();">
                        
                        <div class="profile-header">
                            <label for="fileInput" style="cursor: pointer;">
                                <img src="{{ $user->profile_picture ? asset('storage/photo/' . $user->profile_picture) : asset('storage/photo/user.jpg') }}"
                                    alt="User Photo"
                                    class="profile-photo">
                            </label>
                            <h4 class="mt-3 mb-1">{{ $user->fullname }}</h4>
                            <p class="text-muted mb-3">{{ $user->job_title ?? 'Staff' }}</p>
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <span class="badge bg-label-primary">{{ $user->cluster }}</span>
                                <span class="badge bg-label-info">{{ $user->unit }}</span>
                            </div>
                        </div>
                    </form>

                    <!-- Quick Info -->
                    <div class="mt-4">
                        <div class="profile-info-item">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                <span class="badge {{ $user->status === 'Active' ? 'bg-label-success' : 'bg-label-warning' }}">
                                    {{ $user->status }}
                                </span>
                            </span>
                        </div>
                        <div class="profile-info-item">
                            <span class="info-label">Join Date</span>
                            <span class="info-value">{{ $user->join_date ? \Carbon\Carbon::parse($user->join_date)->format('d F Y') : 'N/A' }}</span>
                        </div>
                        <div class="profile-info-item">
                            <span class="info-label">Gender</span>
                            <span class="info-value">{{ $user->gender ?? 'N/A' }}</span>
                        </div>
                        @if($user->pas_registered)
                        <div class="profile-info-item">
                            <span class="info-label">PAS Registered</span>
                            <span class="info-value">{{ user->pas_registered ? \Carbon\Carbon::parse($user->pas_registered)->format('d F Y') : 'N/A' }}</span>
                        </div>
                        @endif
                        @if($user->pas_expired)
                        <div class="profile-info-item">
                            <span class="info-label">PAS Expired</span>
                            <span class="info-value {{ \Carbon\Carbon::parse($user->pas_expired)->isPast() ? 'text-danger' : 'text-success' }}">
                                {{ \Carbon\Carbon::parse($user->pas_expired)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        @endif
                         @if($user->no_hp)
                        <div class="profile-info-item">
                            <span class="info-label">Kontak</span>
                            <span class="info-value" >{{ $user->no_hp ?? 'N/A' }}</span>
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-7">
    <div class="card profile-card">
        <div class="card-header bg-transparent border-bottom-0">
            <ul class="nav nav-tabs card-header-tabs" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="employment-tab" data-bs-toggle="tab" data-bs-target="#employment" type="button" role="tab" aria-controls="employment" aria-selected="true">
                        <i class="bx bx-briefcase me-2"></i> Employment Data
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="biodata-tab" data-bs-toggle="tab" data-bs-target="#biodata" type="button" role="tab" aria-controls="biodata" aria-selected="false">
                        <i class="bx bx-user me-2"></i> Biodata Staff
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="profileTabContent">

                <div class="tab-pane fade show active" id="employment" role="tabpanel" aria-labelledby="employment-tab">
                    <form class="personal-data-form">
                        <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="staffId">NIP</label>
                            <input type="text" class="form-control" id="staffId" value="{{ $user->id }}" disabled>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="station">Station</label>
                            <input type="text" class="form-control" id="station" value="{{ $user->station }}" disabled>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="jobTitle">Job Title</label>
                            <input type="text" class="form-control" id="jobTitle" value="{{ $user->job_title ?? 'N/A' }}" disabled>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="cluster">Cluster</label>
                            <input type="text" class="form-control" id="cluster" value="{{ $user->cluster ?? 'N/A' }}" disabled>
                        </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control" id="unit" value="{{ $user->unit ?? 'N/A' }}" disabled>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="subUnit">Sub Unit</label>
                                <input type="text" class="form-control" id="subUnit" value="{{ $user->sub_unit ?? 'N/A' }}" disabled>
                            </div>
                        

                        <div class="col-md-6 form-group mb-3">
                            <label for="manager">Manager</label>
                            <input type="text" class="form-control" id="manager" value="{{ $user->manager ?? 'N/A' }}" disabled>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="seniorManager">Senior Manager</label>
                            <input type="text" class="form-control" id="seniorManager" value="{{ $user->senior_manager ?? 'N/A' }}" disabled>
                        </div>
                        </div>

                        @if (in_array(Auth::user()->role, ['ADMIN', 'ASS LEADER', 'CHIEF', 'LEADER']))
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="contractStart">Contract Start</label>
                                <input type="text" class="form-control" id="contractStart" value="{{ $user->contract_start ?? 'N/A' }}" disabled>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="contractEnd">Contract End</label>
                                <input type="text" class="form-control" id="contractEnd" value="{{ $user->contract_end ?? 'N/A' }}" disabled>
                            </div>
                        </div>
                        @endif

                        @if (in_array(Auth::user()->role, ['Admin', 'Ass Leader', 'Chief', 'Leader', 'Finance']))
                        <div class="form-group mb-3">
                            <label for="salary">Salary</label>
                            <input type="text" class="form-control" id="salary" value="Rp {{ $user->salary ? number_format((float)$user->salary, 0, ',', '.') : 'N/A' }}" disabled>
                        </div>
                        @endif
                    </form>
                </div>

                <div class="tab-pane fade" id="biodata" role="tabpanel" aria-labelledby="biodata-tab">
                    <form class="personal-data-form">
                        <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName">NIK</label>
                            <input type="text" class="form-control" id="NIK" value="{{ $user->nik }}" disabled>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="email">KK</label>
                            <input type="text" class="form-control" id="KK" value="{{ $user->kk }}" disabled>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName">BPJS Kesehatan</label>
                            <input type="text" class="form-control" id="bpjs_kesehatan" value="{{ $user->bpjs_kesehatan }}" disabled>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="email">BPJS TK</label>
                            <input type="text" class="form-control" id="bpjs_tk" value="{{ $user->bpjs_tk }}" disabled>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName">Pendidikan</label>
                            <input type="text" class="form-control" id="pendidikan" value="{{ $user->pendidikan }}" disabled>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="email">Domisili</label>
                            <input type="text" class="form-control" id="domisili" value="{{ $user->domisili }}" disabled>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName">Alamat</label>
                            <input type="text" class="form-control" id="alamat" value="{{ $user->alamat }}" disabled>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName">NPWP</label>
                            <input type="text" class="form-control" id="npwp" value="{{ $user->npwp }}" disnpwpabled>
                        </div>
                        </div>
                        </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Additional Information Card -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-info-circle me-2"></i> Additional Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info-item">
                                <span class="info-label">Employment Status</span>
                                <span class="info-value">
                                    <span class="badge {{ $user->status === 'Active' ? 'bg-label-success' : 'bg-label-warning' }}">
                                        {{ $user->status }}
                                    </span>
                                </span>
                            </div>
                            <div class="profile-info-item">
                                <span class="info-label">Join Date</span>
                                <span class="info-value">{{ $user->join_date ? \Carbon\Carbon::parse($user->join_date)->translatedFormat('d F Y') : 'N/A' }}</span>
                            </div>
                            <div class="profile-info-item">
                                <span class="info-label">Gender</span>
                                <span class="info-value">{{ $user->gender ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($user->pas_registered)
                            <div class="profile-info-item">
                                <span class="info-label">PAS Registered</span>
                                <span class="info-value">{{ $user->pas_registered }}</span>
                            </div>
                            @endif
                            @if($user->pas_expired)
                            <div class="profile-info-item">
                                <span class="info-label">PAS Expired</span>
                                <span class="info-value {{ \Carbon\Carbon::parse($user->pas_expired)->isPast() ? 'text-danger' : 'text-success' }}">
                                    {{ \Carbon\Carbon::parse($user->pas_expired)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            @endif
                            <div class="profile-info-item">
                                <span class="info-label">Last Updated</span>
                                <span class="info-value">{{ $user->updated_at->format('d M Y, H:i') }}</span>
                            </div>
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
        // Handle photo upload click
        const profilePhoto = document.querySelector('.profile-photo');
        const fileInput = document.getElementById('fileInput');
        
        if (profilePhoto && fileInput) {
            profilePhoto.addEventListener('click', function() {
                fileInput.click();
            });
        }

        // Show loading state when uploading photo
        const photoForm = document.getElementById('photoForm');
        if (photoForm) {
            photoForm.addEventListener('submit', function() {
                const submitButton = photoForm.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.innerHTML = '<i class="bx bx-loader bx-spin me-2"></i>Uploading...';
                    submitButton.disabled = true;
                }
            });
        }

        // Add hover effect to profile photo
        const photo = document.querySelector('.profile-photo');
        if (photo) {
            photo.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 4px 15px rgba(102, 126, 234, 0.3)';
            });
            
            photo.addEventListener('mouseleave', function() {
                this.style.boxShadow = 'none';
            });
        }
    });
</script>
@endsection