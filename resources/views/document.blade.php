@extends('layout.admin')

@section('styles')
    <style>
        .document-page {
            --doc-surface: #ffffff;
            --doc-surface-soft: #f8fbff;
            --doc-surface-muted: #eef5ff;
            --doc-border: #e5edf7;
            --doc-border-strong: #d8e4f2;
            --doc-text: #28364a;
            --doc-muted: #718096;
            --doc-faint: #9aa8bb;
            --doc-blue: #2f80ed;
            --doc-blue-deep: #2368c8;
            --doc-green: #16a163;
            --doc-green-soft: #e9f8f0;
            --doc-red: #e34d4d;
            --doc-red-soft: #fdecec;
            --doc-amber: #b7791f;
            --doc-amber-soft: #fff7e6;
            --doc-shadow: 0 18px 42px rgba(31, 49, 78, 0.075);
        }

        .document-page .document-page-header {
            margin-bottom: 1.35rem;
        }

        .document-page .document-total-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            min-height: 32px;
            padding: 0.4rem 0.8rem;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--doc-blue), var(--doc-blue-deep));
            color: #ffffff;
            font-size: 0.76rem;
            font-weight: 700;
            box-shadow: 0 10px 22px rgba(47, 128, 237, 0.18);
            white-space: nowrap;
        }

        .document-page .document-overview {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(360px, 0.8fr);
            gap: 1rem;
            margin-bottom: 1.35rem;
        }

        .document-page .document-overview-main,
        .document-page .document-stat,
        .document-page .document-card {
            border: 1px solid var(--doc-border);
            border-radius: 16px;
            background: var(--doc-surface);
            box-shadow: var(--doc-shadow);
        }

        .document-page .document-overview-main {
            position: relative;
            overflow: hidden;
            padding: 1.25rem;
            background:
                radial-gradient(circle at 94% 8%, rgba(22, 161, 99, 0.14), transparent 24%),
                linear-gradient(135deg, #2f80ed 0%, #2368c8 52%, #184fa8 100%);
            color: #ffffff;
        }

        .document-page .document-overview-main::after {
            content: "";
            position: absolute;
            inset: auto -6% -42% auto;
            width: 260px;
            height: 260px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 999px;
            pointer-events: none;
        }

        .document-page .overview-kicker {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            margin-bottom: 0.8rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.78);
        }

        .document-page .document-overview-main h5 {
            position: relative;
            margin: 0 0 0.35rem;
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 700;
            line-height: 1.35;
        }

        .document-page .document-overview-main p {
            position: relative;
            max-width: 680px;
            margin: 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.88rem;
            line-height: 1.55;
        }

        .document-page .document-stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .document-page .document-stat {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            min-height: 92px;
            padding: 1rem;
        }

        .document-page .document-stat-icon,
        .document-page .document-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            border-radius: 999px;
        }

        .document-page .document-stat-icon {
            width: 42px;
            height: 42px;
            background: var(--doc-surface-muted);
            color: var(--doc-blue);
            font-size: 1.15rem;
        }

        .document-page .document-stat-value {
            color: var(--doc-text);
            font-size: 1.25rem;
            font-weight: 750;
            line-height: 1.1;
        }

        .document-page .document-stat-label {
            margin-top: 0.25rem;
            color: var(--doc-muted);
            font-size: 0.78rem;
            font-weight: 650;
        }

        .document-page .document-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .document-page .document-card {
            overflow: hidden;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .document-page .document-card:hover {
            transform: translateY(-2px);
            border-color: var(--doc-border-strong);
            box-shadow: 0 22px 48px rgba(31, 49, 78, 0.1);
        }

        .document-page .document-empty {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            gap: 0.9rem;
            min-height: 118px;
            padding: 1.25rem;
            border: 1px solid var(--doc-border);
            border-radius: 16px;
            background: var(--doc-surface);
            box-shadow: var(--doc-shadow);
        }

        .document-page .document-card-header {
            padding: 1.1rem 1.25rem;
            background:
                linear-gradient(135deg, rgba(47, 128, 237, 0.1), rgba(22, 161, 99, 0.06)),
                var(--doc-surface-soft);
            border-bottom: 1px solid var(--doc-border);
        }

        .document-page .document-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .document-page .document-title-group {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            min-width: 0;
        }

        .document-page .document-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--doc-blue), var(--doc-blue-deep));
            color: #ffffff;
            font-size: 1.35rem;
            box-shadow: 0 12px 22px rgba(47, 128, 237, 0.18);
        }

        .document-page .document-kicker {
            margin-bottom: 0.15rem;
            color: var(--doc-blue);
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .document-page .document-name {
            margin: 0;
            color: var(--doc-text);
            font-size: 1.03rem;
            font-weight: 750;
            line-height: 1.3;
            text-align: left;
            word-break: break-word;
        }

        .document-page .access-badge,
        .document-page .document-size,
        .document-page .document-download {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            line-height: 1.25;
            white-space: normal;
        }

        .document-page .access-badge {
            flex: 0 0 auto;
            max-width: min(360px, 48%);
            padding: 0.5rem 0.75rem;
            text-align: right;
        }

        .document-page .access-badge.is-all {
            background: rgba(47, 128, 237, 0.1);
            color: var(--doc-blue-deep);
        }

        .document-page .access-badge.is-admin {
            background: var(--doc-red-soft);
            color: var(--doc-red);
        }

        .document-page .access-badge.is-manager {
            background: var(--doc-amber-soft);
            color: var(--doc-amber);
        }

        .document-page .access-badge.is-staff-admin {
            background: var(--doc-green-soft);
            color: var(--doc-green);
        }

        .document-page .document-card-body {
            display: flex;
            min-height: 135px;
            flex-direction: column;
            padding: 1.1rem 1.25rem 1.25rem;
        }

        .document-page .document-description {
            color: var(--doc-muted);
            font-size: 0.88rem;
            line-height: 1.55;
            margin: 0;
        }

        .document-page .document-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-top: auto;
            padding-top: 1rem;
        }

        .document-page .document-size {
            padding: 0.42rem 0.65rem;
            background: var(--doc-surface);
            border: 1px solid var(--doc-border);
            color: var(--doc-muted);
            font-family: "Courier New", monospace;
            opacity: 1;
        }

        .document-page .document-download {
            min-height: 38px;
            justify-content: center;
            padding: 0.52rem 0.9rem;
            border: 1px solid var(--doc-blue);
            background: linear-gradient(135deg, var(--doc-blue), var(--doc-blue-deep));
            color: #ffffff;
            text-decoration: none;
            box-shadow: 0 10px 22px rgba(47, 128, 237, 0.18);
            transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }

        .document-page .document-download:hover {
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(47, 128, 237, 0.26);
        }

        .document-page .document-download-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
            font-size: 0.92rem;
        }

        html.aps-dark .document-page {
            --doc-surface: #111c31;
            --doc-surface-soft: #16243a;
            --doc-surface-muted: #162842;
            --doc-border: #263653;
            --doc-border-strong: #315071;
            --doc-text: #e7f0fb;
            --doc-muted: #a5b7cf;
            --doc-faint: #72849d;
            --doc-green: #6ee7a8;
            --doc-green-soft: rgba(34, 197, 94, 0.14);
            --doc-red: #fb7185;
            --doc-red-soft: rgba(239, 68, 68, 0.14);
            --doc-amber: #fbbf24;
            --doc-amber-soft: rgba(245, 158, 11, 0.16);
            --doc-shadow: 0 18px 42px rgba(0, 0, 0, 0.22);
        }

        html.aps-dark .document-page .document-overview-main {
            background:
                radial-gradient(circle at 94% 8%, rgba(110, 231, 168, 0.14), transparent 26%),
                linear-gradient(135deg, #172942 0%, #132039 58%, #111c31 100%);
            border-color: #315071;
        }

        html.aps-dark .document-page .document-card-header {
            background:
                linear-gradient(135deg, rgba(47, 128, 237, 0.14), rgba(110, 231, 168, 0.07)),
                var(--doc-surface-soft);
        }

        @media (max-width: 1199.98px) {
            .document-page .document-overview {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 991.98px) {
            .document-page .document-list {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .document-page .document-stats {
                grid-template-columns: 1fr;
            }

            .document-page .document-head,
            .document-page .document-card-footer {
                align-items: flex-start;
                flex-direction: column;
            }

            .document-page .access-badge {
                align-self: flex-start;
                max-width: 100%;
                text-align: left;
            }

            .document-page .document-download {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y document-page">
        <div class="document-page-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <h4 class="fw-bold pt-3 pb-1 mb-0">
                <span class="text-muted fw-light">Dokumen /</span> Cetak Dokumen
            </h4>
            <span class="document-total-pill">
                <i class="bx bx-file"></i>
                {{ $totalDocuments }} Dokumen
            </span>
        </div>

        <div class="document-overview">
            <section class="document-overview-main" aria-label="Ringkasan dokumen">
                <div class="overview-kicker">
                    <i class="bx bx-folder-open"></i>
                    Pusat Dokumen AP3
                </div>
                <h5>Dokumen Operasional & Administrasi</h5>
                <p>
                    Akses formulir, kebijakan, laporan, dan panduan kerja resmi sesuai kebutuhan role masing-masing.
                </p>
            </section>

            <div class="document-stats" aria-label="Statistik dokumen">
                <div class="document-stat">
                    <span class="document-stat-icon"><i class="bx bx-file"></i></span>
                    <div>
                        <div class="document-stat-value">{{ $totalDocuments }}</div>
                        <div class="document-stat-label">Total</div>
                    </div>
                </div>
                <div class="document-stat">
                    <span class="document-stat-icon"><i class="bx bx-group"></i></span>
                    <div>
                        <div class="document-stat-value">{{ $allRoleDocuments }}</div>
                        <div class="document-stat-label">Semua Role</div>
                    </div>
                </div>
                <div class="document-stat">
                    <span class="document-stat-icon"><i class="bx bx-shield-quarter"></i></span>
                    <div>
                        <div class="document-stat-value">{{ $adminDocuments }}</div>
                        <div class="document-stat-label">Admin</div>
                    </div>
                </div>
                <div class="document-stat">
                    <span class="document-stat-icon"><i class="bx bx-briefcase"></i></span>
                    <div>
                        <div class="document-stat-value">{{ $managerDocuments }}</div>
                        <div class="document-stat-label">Manager</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="document-list">
            @forelse ($visibleDocuments as $document)
                <article class="document-card">
                    <div class="document-card-header">
                        <div class="document-head">
                            <div class="document-title-group">
                                <span class="document-icon">
                                    <i class="bx bx-file"></i>
                                </span>
                                <div>
                                    <div class="document-kicker">Dokumen</div>
                                    <h5 class="document-name">{{ $document->nama_dokumen }}</h5>
                                </div>
                            </div>
                            <span class="access-badge {{ $document->access_class }}">
                                {{ $document->access_label }}
                            </span>
                        </div>
                    </div>

                    <div class="document-card-body">
                        <p class="document-description">{{ $document->deskripsi_dokumen }}</p>

                        <div class="document-card-footer">
                            <span class="document-size">
                                <i class="bx bx-data"></i>
                                {{ $document->ukuran_file ?? '-' }}
                            </span>
                            <a href="{{ route('document.download', $document) }}" class="document-download"
                                aria-label="Unduh {{ $document->nama_dokumen }}">
                                <span class="document-download-icon"><i class="bx bx-download"></i></span>
                                <span>Unduh</span>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="document-empty">
                    <span class="document-icon">
                        <i class="bx bx-file"></i>
                    </span>
                    <div>
                        <h5 class="document-name mb-1">Belum ada dokumen</h5>
                        <p class="document-description mb-0">Dokumen untuk role Anda belum tersedia.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
