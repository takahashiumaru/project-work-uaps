@extends('layout.admin')

@section('title', 'Profil Pengguna')

@section('styles')
    <style>
        h4 {
            font-size: 1.3rem;
        }

        .profile-photo-container {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 1.25rem;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .profile-photo-container:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.2);
        }

        .profile-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .profile-photo-container:hover .photo-overlay {
            opacity: 1;
        }

        .photo-overlay i {
            font-size: 1.5rem;
            margin-bottom: 4px;
        }

        .profile-card {
            background: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 0.125rem 0.375rem rgba(161, 172, 184, 0.12);
            border: 1px solid #d9dee3;
            overflow: hidden;
        }

        /* Custom Navigation Tabs */
        .profile-card .nav-tabs {
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 0 1.5rem;
            background: #fcfcfd;
        }

        .profile-card .nav-link {
            border: none;
            color: #697a8d;
            padding: 1rem 1.25rem;
            font-weight: 500;
            position: relative;
            background: transparent;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .profile-card .nav-link:hover {
            color: #667eea;
        }

        .profile-card .nav-link.active {
            color: #667eea;
            background: transparent;
        }

        .profile-card .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: #667eea;
            border-radius: 3px 3px 0 0;
        }

        /* Info Tiles Grid */
        .info-tile {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            background: #f8f9fc;
            border: 1px solid rgba(102, 126, 234, 0.05);
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            height: 100%;
        }

        .info-tile:hover {
            background: #f1f4fc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.05);
            border-color: rgba(102, 126, 234, 0.15);
        }

        .tile-icon-wrapper {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(102, 126, 234, 0.08);
            color: #667eea;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-right: 1rem;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .info-tile:hover .tile-icon-wrapper {
            background: #667eea;
            color: #fff;
        }

        .tile-content {
            flex-grow: 1;
            min-width: 0;
        }

        .tile-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #8c9ba5;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .tile-value {
            font-size: 0.925rem;
            font-weight: 600;
            color: #4a545e;
            word-break: break-word;
        }

        /* Profile Info List */
        .profile-info-list {
            margin-top: 1.5rem;
        }

        .profile-info-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 0.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .profile-info-item:last-child {
            border-bottom: none;
        }

        .profile-info-item:hover {
            background: rgba(102, 126, 234, 0.02);
            padding-left: 0.75rem;
            padding-right: 0.25rem;
        }

        .info-icon-wrapper {
            font-size: 1.2rem;
            color: #667eea;
            margin-right: 0.75rem;
            display: flex;
            align-items: center;
        }

        .info-label {
            font-weight: 500;
            color: #697a8d;
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .info-value {
            margin-left: auto;
            font-weight: 600;
            color: #4a545e;
            font-size: 0.875rem;
            text-align: right;
        }

        @media (max-width: 768px) {
            h4 {
                font-size: 1.1rem !important;
            }

            .profile-photo-container {
                width: 120px;
                height: 120px;
            }

            .profile-info-item {
                padding: 0.75rem 0.25rem;
            }

            .info-label {
                font-size: 0.8rem;
            }

            .info-value {
                font-size: 0.85rem;
            }

            .badge {
                font-size: 0.7rem;
            }

            .profile-card .nav-link {
                font-size: 0.8rem;
                padding: 0.75rem 1rem;
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
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                    <h4 class="fw-bold pt-3 pb-1 mb-0">
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
                    <div class="card-body">
                        <!-- Photo Form -->
                        <form id="photoForm" method="POST" enctype="multipart/form-data"
                            action="{{ route('user.updatePhoto', ['userId' => $user->id]) }}">
                            @csrf
                            <input type="file" name="profile_picture" id="fileInput" style="display: none;"
                                onchange="document.getElementById('photoForm').submit();">

                            <div class="text-center mb-4">
                                <div class="profile-photo-container">
                                    <label for="fileInput" class="w-100 h-100 d-block m-0" style="cursor: pointer;">
                                        <img src="{{ $user->profile_picture ? asset('storage/photo/' . $user->profile_picture) : asset('storage/photo/user.jpg') }}"
                                            alt="User Photo" class="profile-photo">
                                        <div class="photo-overlay">
                                            <i class="bx bx-camera"></i>
                                            <span>Ubah Foto</span>
                                        </div>
                                    </label>
                                </div>
                                <h4 class="mt-3 mb-1 fw-bold text-dark">{{ $user->fullname }}</h4>
                                <p class="text-muted mb-3 fs-7">{{ $user->job_title ?? 'Staff' }}</p>
                                <div class="d-flex justify-content-center gap-2 mb-2">
                                    <span class="badge bg-label-primary px-2.5 py-1">{{ $user->cluster ?? 'N/A' }}</span>
                                    <span class="badge bg-label-info px-2.5 py-1">{{ $user->unit ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </form>

                        <!-- Quick Info -->
                        <div class="profile-info-list mt-3">
                            <div class="profile-info-item">
                                <div class="info-icon-wrapper">
                                    <i class="bx bx-shield-quarter"></i>
                                </div>
                                <span class="info-label">Status</span>
                                <span class="info-value">
                                    <span
                                        class="badge {{ $user->status === 'Active' || $user->status === 'Employed' ? 'bg-label-success' : 'bg-label-warning' }}">
                                        {{ $user->status ?? 'Empty' }}
                                    </span>
                                </span>
                            </div>
                            <div class="profile-info-item">
                                <div class="info-icon-wrapper">
                                    <i class="bx bx-calendar-event"></i>
                                </div>
                                <span class="info-label">Join Date</span>
                                <span
                                    class="info-value">{{ $user->join_date ? \Carbon\Carbon::parse($user->join_date)->translatedFormat('d F Y') : 'N/A' }}</span>
                            </div>
                            <div class="profile-info-item">
                                <div class="info-icon-wrapper">
                                    <i class="bx bx-user"></i>
                                </div>
                                <span class="info-label">Gender</span>
                                <span class="info-value">{{ $user->gender ?? 'N/A' }}</span>
                            </div>
                            @if ($user->pas_registered)
                                <div class="profile-info-item">
                                    <div class="info-icon-wrapper">
                                        <i class="bx bx-badge"></i>
                                    </div>
                                    <span class="info-label">PAS Registered</span>
                                    <span
                                        class="info-value">{{ \Carbon\Carbon::parse($user->pas_registered)->translatedFormat('d F Y') }}</span>
                                </div>
                            @endif
                            @if ($user->pas_expired)
                                <div class="profile-info-item">
                                    <div class="info-icon-wrapper">
                                        <i class="bx bx-badge-check"></i>
                                    </div>
                                    <span class="info-label">PAS Expired</span>
                                    <span
                                        class="info-value {{ \Carbon\Carbon::parse($user->pas_expired)->isPast() ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                                        {{ \Carbon\Carbon::parse($user->pas_expired)->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                            @endif
                            @if ($user->no_hp)
                                <div class="profile-info-item">
                                    <div class="info-icon-wrapper">
                                        <i class="bx bx-phone"></i>
                                    </div>
                                    <span class="info-label">Kontak</span>
                                    <span class="info-value">{{ $user->no_hp ?? 'N/A' }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Last Updated Footnote -->
                        <div class="mt-4 pt-3 border-top text-center">
                            <small class="text-muted d-block">
                                <i class="bx bx-time-five me-1"></i> Terakhir diperbarui:
                            </small>
                            <small class="text-dark fw-semibold">
                                {{ $user->updated_at ? $user->updated_at->format('d M Y, H:i') : 'N/A' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-7">
                <div class="card profile-card">
                    <div class="card-header bg-transparent border-bottom-0 p-0">
                        <ul class="nav nav-tabs card-header-tabs" id="profileTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="employment-tab" data-bs-toggle="tab"
                                    data-bs-target="#employment" type="button" role="tab" aria-controls="employment"
                                    aria-selected="true">
                                    <i class="bx bx-briefcase me-2"></i> Employment Data
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="biodata-tab" data-bs-toggle="tab" data-bs-target="#biodata"
                                    type="button" role="tab" aria-controls="biodata" aria-selected="false">
                                    <i class="bx bx-user me-2"></i> Biodata Staff
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <div class="tab-content p-0" id="profileTabContent">

                            <!-- Employment Data Tab -->
                            <div class="tab-pane fade show active" id="employment" role="tabpanel"
                                aria-labelledby="employment-tab">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-key"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">NIP</div>
                                                <div class="tile-value">{{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-building-house"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">Station</div>
                                                <div class="tile-value">{{ $user->station }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-briefcase"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">Job Title</div>
                                                <div class="tile-value">{{ $user->job_title ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-grid-alt"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">Cluster</div>
                                                <div class="tile-value">{{ $user->cluster ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-group"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">Unit</div>
                                                <div class="tile-value">{{ $user->unit ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-sitemap"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">Sub Unit</div>
                                                <div class="tile-value">{{ $user->sub_unit ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-user-voice"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">Manager</div>
                                                <div class="tile-value">{{ $user->manager ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-user-check"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">Senior Manager</div>
                                                <div class="tile-value">{{ $user->senior_manager ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    @if (in_array(Auth::user()->role, ['ADMIN', 'ASS LEADER', 'CHIEF', 'LEADER']))
                                        <div class="col-md-6">
                                            <div class="info-tile">
                                                <div class="tile-icon-wrapper">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                                <div class="tile-content">
                                                    <div class="tile-label">Contract Start</div>
                                                    <div class="tile-value">{{ $user->contract_start ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-tile">
                                                <div class="tile-icon-wrapper">
                                                    <i class="bx bx-calendar-x"></i>
                                                </div>
                                                <div class="tile-content">
                                                    <div class="tile-label">Contract End</div>
                                                    <div class="tile-value">{{ $user->contract_end ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if (in_array(Auth::user()->role, ['Admin', 'Ass Leader', 'Chief', 'Leader', 'Finance']))
                                        <div class="col-12">
                                            <div class="info-tile">
                                                <div class="tile-icon-wrapper">
                                                    <i class="bx bx-wallet"></i>
                                                </div>
                                                <div class="tile-content">
                                                    <div class="tile-label">Salary</div>
                                                    <div class="tile-value">Rp {{ $user->salary ? number_format((float) $user->salary, 0, ',', '.') : 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Biodata Staff Tab -->
                            <div class="tab-pane fade" id="biodata" role="tabpanel" aria-labelledby="biodata-tab">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-fingerprint"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">NIK</div>
                                                <div class="tile-value">{{ $user->no_nik ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-spreadsheet"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">No. KK</div>
                                                <div class="tile-value">{{ $user->no_kk ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-heart"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">BPJS Kesehatan</div>
                                                <div class="tile-value">{{ $user->bpjs_kesehatan ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-shield"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">BPJS Ketenagakerjaan</div>
                                                <div class="tile-value">{{ $user->bpjs_tk ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-book-reader"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">Pendidikan</div>
                                                <div class="tile-value">{{ $user->pendidikan ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-home-alt"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">Domisili</div>
                                                <div class="tile-value">{{ $user->domisili ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-map-alt"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">Alamat Sesuai KTP</div>
                                                <div class="tile-value">{{ $user->alamat ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-tile">
                                            <div class="tile-icon-wrapper">
                                                <i class="bx bx-credit-card-front"></i>
                                            </div>
                                            <div class="tile-content">
                                                <div class="tile-label">NPWP</div>
                                                <div class="tile-value">{{ $user->npwp ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>
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
