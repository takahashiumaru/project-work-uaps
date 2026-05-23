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

        /* APS profile refresh */
        .profile-page {
            --aps-blue: #2f80ed;
            --aps-blue-deep: #2368c8;
            --aps-blue-soft: #eaf4ff;
            --aps-ink: #1f2937;
            --aps-muted: #64748b;
            --aps-line: #e6edf5;
        }

        .profile-page .text-primary,
        .profile-page .profile-card .nav-link:hover,
        .profile-page .profile-card .nav-link.active {
            color: var(--aps-blue) !important;
        }

        .profile-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.25rem;
            padding: 0;
            background: transparent;
            border: 0;
            border-radius: 0;
            box-shadow: none;
        }

        html.aps-dark .profile-page .profile-page-header {
            background: transparent !important;
            background-color: transparent !important;
            border-color: transparent !important;
            box-shadow: none !important;
            color: inherit !important;
        }

        .profile-page-title {
            margin: 0;
            color: var(--aps-ink);
            font-size: 1.25rem !important;
            font-weight: 700;
            line-height: 1.25;
        }

        .profile-page-title .text-muted {
            color: #94a3b8 !important;
            font-weight: 400 !important;
        }

        .profile-page-badges,
        .profile-meta-badges {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.45rem;
        }

        .profile-page-badges {
            justify-content: flex-end;
        }

        .profile-page-badges .badge,
        .profile-meta-badges .badge {
            border-radius: 999px;
            padding: 0.38rem 0.68rem;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0;
        }

        .profile-page-badges .bg-primary,
        .profile-meta-badges .bg-label-primary {
            background: linear-gradient(135deg, var(--aps-blue) 0%, var(--aps-blue-deep) 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 8px 18px rgba(47, 128, 237, 0.18);
        }

        .profile-page-badges .bg-label-secondary,
        .profile-meta-badges .bg-label-info {
            background: #eef2f7 !important;
            color: #64748b !important;
        }

        .profile-page .profile-card {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--aps-line);
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 18px 44px rgba(15, 23, 42, 0.055);
        }

        .profile-summary-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 118px;
            background:
                radial-gradient(circle at 18% 0%, rgba(47, 128, 237, 0.14), transparent 35%),
                linear-gradient(135deg, rgba(47, 128, 237, 0.11), rgba(255, 255, 255, 0));
            pointer-events: none;
        }

        .profile-page .card-body {
            position: relative;
            z-index: 1;
        }

        .profile-photo-container {
            width: 124px;
            height: 124px;
            margin-bottom: 1rem;
            border: 5px solid #ffffff;
            box-shadow: 0 18px 34px rgba(47, 128, 237, 0.16);
        }

        .profile-photo-container:hover {
            transform: translateY(-2px) scale(1.015);
            box-shadow: 0 22px 42px rgba(47, 128, 237, 0.2);
        }

        .profile-summary-name {
            max-width: 100%;
            color: var(--aps-ink) !important;
            font-size: 1.08rem !important;
            line-height: 1.25;
        }

        .profile-summary-title {
            color: #7a8797 !important;
            font-size: 0.82rem !important;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        .profile-info-list {
            margin-top: 1.25rem;
        }

        .profile-info-item {
            gap: 0.7rem;
            min-height: 50px;
            margin-bottom: 0.55rem;
            padding: 0.72rem 0.78rem;
            border: 1px solid #eef2f7;
            border-radius: 14px;
            background: #ffffff;
        }

        .profile-info-item:last-child {
            margin-bottom: 0;
            border-bottom: 1px solid #eef2f7;
        }

        .profile-info-item:hover {
            padding-left: 0.78rem;
            padding-right: 0.78rem;
            background: #f8fbff;
            border-color: rgba(47, 128, 237, 0.16);
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.04);
        }

        .info-icon-wrapper {
            width: 34px;
            height: 34px;
            margin-right: 0;
            border-radius: 999px;
            background: var(--aps-blue-soft);
            color: var(--aps-blue);
            justify-content: center;
            flex: 0 0 auto;
        }

        .info-label {
            color: #64748b;
            font-size: 0.82rem;
            font-weight: 560;
        }

        .info-value {
            color: var(--aps-ink);
            font-size: 0.82rem;
            font-weight: 620;
            word-break: break-word;
        }

        .profile-updated {
            margin-top: 1rem !important;
            padding: 0.85rem !important;
            border: 1px dashed #dbe7f6 !important;
            border-radius: 14px;
            background: #f8fbff;
        }

        .profile-page .profile-card .nav-tabs {
            display: inline-flex;
            gap: 0.4rem;
            margin: 1rem;
            padding: 0.35rem;
            border: 1px solid #eef2f7;
            border-radius: 999px;
            background: #f8fafc;
        }

        .profile-page .profile-card .nav-link {
            min-height: 42px;
            padding: 0.55rem 1rem;
            border-radius: 999px;
            color: #64748b;
            font-size: 0.86rem;
            font-weight: 600;
            gap: 0.35rem;
        }

        .profile-page .profile-card .nav-link.active {
            background: #ffffff;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.07);
        }

        .profile-page .profile-card .nav-link.active::after {
            display: none;
            content: none;
        }

        .profile-page .profile-card .nav-link i {
            font-size: 1.05rem;
            color: currentColor;
        }

        .profile-page .profile-card .card-body {
            padding: 1rem 1.35rem 1.35rem !important;
        }

        .info-tile {
            min-height: 82px;
            align-items: center;
            padding: 0.9rem;
            border: 1px solid #eef2f7;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: none;
        }

        .info-tile:hover {
            transform: translateY(-2px);
            background: #fbfdff;
            border-color: rgba(47, 128, 237, 0.2);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.055);
        }

        .tile-icon-wrapper {
            width: 42px;
            height: 42px;
            margin-right: 0.85rem;
            border-radius: 999px;
            background: var(--aps-blue-soft);
            color: var(--aps-blue);
            font-size: 1.08rem;
        }

        .info-tile:hover .tile-icon-wrapper {
            background: linear-gradient(135deg, var(--aps-blue) 0%, var(--aps-blue-deep) 100%);
            color: #ffffff;
            box-shadow: 0 10px 20px rgba(47, 128, 237, 0.18);
        }

        .tile-label {
            margin-bottom: 0.22rem;
            color: #94a3b8;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        .tile-value {
            color: #334155;
            font-size: 0.9rem;
            font-weight: 650;
            line-height: 1.35;
        }

        @media (min-width: 1200px) {
            .profile-page .profile-sidebar-col {
                width: 330px;
                flex: 0 0 330px;
            }

            .profile-page .profile-detail-col {
                width: calc(100% - 330px);
                flex: 0 0 calc(100% - 330px);
            }
        }

        @media (max-width: 991.98px) {
            .profile-page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .profile-page-badges {
                justify-content: flex-start;
            }
        }

        @media (max-width: 767.98px) {
            .profile-page {
                padding-left: 0.85rem !important;
                padding-right: 0.85rem !important;
            }

            .profile-page-header {
                padding: 0;
                border-radius: 0;
            }

            .profile-page-title {
                font-size: 1.1rem !important;
            }

            .profile-page .profile-card {
                margin-left: 0 !important;
                margin-right: 0 !important;
                border-radius: 16px !important;
                border-left: 1px solid var(--aps-line) !important;
                border-right: 1px solid var(--aps-line) !important;
            }

            .profile-page .card-body {
                padding: 1rem !important;
            }

            .profile-photo-container {
                width: 108px;
                height: 108px;
            }

            .profile-page .profile-card .nav-tabs {
                display: grid;
                grid-template-columns: 1fr;
                width: auto;
                margin: 0.85rem;
                border-radius: 16px;
            }

            .profile-page .profile-card .nav-link {
                justify-content: center;
                width: 100%;
                min-height: 40px;
                padding: 0.55rem 0.8rem;
                font-size: 0.82rem;
            }

            .info-tile {
                min-height: 74px;
                padding: 0.78rem;
            }

            .tile-icon-wrapper {
                width: 38px;
                height: 38px;
                margin-right: 0.7rem;
            }

            .profile-info-item {
                align-items: flex-start;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y profile-page">
        <!-- Header -->
        <div class="profile-page-header">
            <h4 class="profile-page-title">
                <span class="text-muted fw-light">Profile /</span> {{ $user->fullname }}
            </h4>
            <div class="profile-page-badges">
                <span class="badge bg-primary">{{ $user->role }}</span>
                <span class="badge bg-label-secondary">{{ $user->station }}</span>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="row">
            <div class="col-lg-4 col-md-5 profile-sidebar-col">
                <div class="card profile-card profile-summary-card mb-4">
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
                                <h4 class="profile-summary-name mt-3 mb-1 fw-bold text-dark">{{ $user->fullname }}</h4>
                                <p class="profile-summary-title text-muted mb-3 fs-7">{{ $user->job_title ?? 'Staff' }}</p>
                                <div class="profile-meta-badges d-flex justify-content-center gap-2 mb-2">
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
                        <div class="profile-updated mt-4 pt-3 border-top text-center">
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

            <div class="col-lg-8 col-md-7 profile-detail-col">
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
