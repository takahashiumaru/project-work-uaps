<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('template/') }}/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>PT. Angkasa Pratama Sejahtera</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/css/core.css"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/css/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('template/') }}/assets/css/demo.css" />

    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/libs/apex-charts/apex-charts.css" />

    <script src="{{ asset('template/') }}/assets/vendor/js/helpers.js"></script>
    <script src="{{ asset('template/') }}/assets/js/config.js"></script>

    @yield('styles')
    <style>
        /* --- KUSTOMISASI SIDEBAR SESUAI KRITERIA --- */

        /* 1. Posisi Tetap (Persistent) & Ukuran Proporsional */
        #layout-menu {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            bottom: 0 !important;
            margin: 0 !important;
            height: 100vh !important;
            width: 250px !important;
            max-width: 250px !important;
            z-index: 1099 !important;
            /* Menutupi navbar di mobile */
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease, transform 0.3s ease !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.05);
            /* Tambah shadow agar terpisah dengan konten */
        }

        /* --- KUSTOMISASI FONT HEADER SECARA GLOBAL --- */
        h4,
        .h4,
        h4.fw-bold.py-3 {
            font-size: 1.25rem !important;
        }

        @media (max-width: 768px) {

            h4,
            .h4,
            h4.fw-bold.py-3 {
                font-size: 1.1rem !important;
            }
        }

        .layout-page {
            padding-left: 250px !important;
            transition: padding-left 0.3s ease !important;
        }

        /* 4. Menyatukan Konten (Hilangkan Gap) dan Perluas Area Data (Full Width) */
        .container-xxl {
            max-width: 100% !important;
            width: 100% !important;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }

        .layout-navbar.navbar-detached {
            margin: 0 !important;
            /* Hilangkan gap atas, kiri, kanan */
            width: 100% !important;
            max-width: 100% !important;
            border-radius: 0 !important;
            /* Buat navbar kotak nempel sisi */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02) !important;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }

        /* Optimasi Padding di Layar HP agar Lebih Lebar */
        @media (max-width: 767.98px) {

            .container-xxl,
            .layout-navbar.navbar-detached {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }
        }

        .menu-link {
            font-size: 0.82rem !important;
            padding: 0.48rem 0.85rem !important; /* Memberi sedikit lebih banyak ruang napas vertikal */
        }

        /* Prevent long text from pushing the layout */
        .menu-link > div:not(.badge) {
            flex: 1;
            min-width: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Khusus tanggal agar bisa bungkus (wrap) dan tidak kepotong */
        #tanggalSekarang {
            white-space: normal !important;
            font-size: 0.75rem !important;
            line-height: 1.2 !important;
            overflow: visible !important;
        }

        .menu-inner > .menu-item > .menu-link .menu-icon {
            font-size: 1.05rem !important;
            flex-shrink: 0 !important; /* Pastikan ikon tidak ikut diperkecil */
        }

        /* Pastikan chevron/arrow tidak terpotong */
        .menu-link .menu-toggle-icon {
            flex-shrink: 0 !important;
            margin-left: auto !important;
        }

        /* Make all menu links have the same pill shape and alignment */
        .layout-menu .menu-inner .menu-item > .menu-link {
            margin: 0.12rem 1rem !important; /* Memberi sedikit jarak agar tidak terlalu dempet */
            width: auto !important;
            border-radius: 0.5rem !important; /* Semua sudut melengkung */
            transition: all 0.3s ease;
            position: relative !important;
        }

        /* Active Menu State ("Menyala") - Elegant Transparent Look */
        .layout-menu .menu-inner .menu-item.active > .menu-link {
            background-color: rgba(74, 126, 187, 0.12) !important;
            color: #4A7EBB !important;
            font-weight: 700 !important;
            box-shadow: none !important; /* No shadow for flat elegant look */
        }

        .layout-menu .menu-inner .menu-item.active > .menu-link .menu-icon,
        .layout-menu .menu-inner .menu-item.active > .menu-link div {
            color: #4A7EBB !important;
            font-weight: 700 !important;
        }

        /* Garis vertikal biru di sisi kiri menu aktif */
        .layout-menu .menu-inner .menu-item.active > .menu-link::before {
            content: "" !important;
            position: absolute !important;
            left: 0 !important;
            top: 20% !important;
            height: 60% !important;
            width: 3px !important;
            background-color: #4A7EBB !important;
            display: block !important;
            border-radius: 0 3px 3px 0 !important;
        }

        /* Sembunyikan garis/indikator tambahan bawaan Sneat di sisi kanan */
        .layout-menu .menu-inner .menu-item.active::before,
        .layout-menu .menu-inner .menu-item.active::after {
            display: none !important;
            content: none !important;
            background: none !important;
            width: 0 !important;
        }

        /* Sub-menu indentation - padding kiri agar terlihat rapi */
        .layout-menu .menu-inner .menu-sub .menu-item > .menu-link {
            padding-left: 1.5rem !important;
        }

        /* 2. State Collapsed (Diringkas) */
        html.sidebar-collapsed #layout-menu {
            width: 80px !important;
            max-width: 80px !important;
        }

        html.sidebar-collapsed .layout-page {
            padding-left: 80px !important;
        }

        /* Center logo container */
        html.sidebar-collapsed #layout-menu:not(:hover) .app-brand {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            padding: 24px 0 !important;
            /* Ruang napas vertikal */
            height: auto !important;
        }

        /* Sembunyikan tanda chevron "<" agar logo bisa ke tengah sempurna */
        html.sidebar-collapsed #layout-menu:not(:hover) #custom-sidebar-close-mobile,
        html.sidebar-collapsed #layout-menu:not(:hover) .layout-menu-toggle {
            display: none !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .app-brand-link {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            width: 100%;
            margin: 0 !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .app-brand-logo {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            width: 100%;
            margin: 0 !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .app-brand-logo img {
            width: 55px !important;
            /* Ukuran ideal untuk logo mini */
            height: auto;
            object-fit: contain;
            margin: 0 !important;
            transition: width 0.3s ease;
        }

        /* Penyesuaian ukuran icon dan jarak menu saat mode collapsed/minimize */
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-inner > .menu-item > .menu-link {
            margin: 0.05rem 1rem !important; /* Jarak vertikal lebih rapat saat minimize */
            padding: 0.35rem 0.85rem !important; /* Pill sedikit lebih tipis saat minimize */
        }
        
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-inner > .menu-item > .menu-link .menu-icon {
            font-size: 0.95rem !important; /* Icon sedikit lebih kecil */
            margin-right: 0 !important;
        }

        /* Sembunyikan teks saat collapsed agar rapi */
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-link div,
        html.sidebar-collapsed #layout-menu:not(:hover) .app-brand-text {
            opacity: 0;
            visibility: hidden;
            display: none !important;
        }

        /* Sembunyikan submenu, chevron, dan menu header (divider) saat collapsed */
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-sub,
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-toggle::after,
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-header {
            display: none !important;
        }

        /* Hapus padding bawaan di container menu */
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-inner {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Menengahkan icon saat collapsed */
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-link i {
            margin: 0 !important;
            font-size: 1.25rem !important;
            /* Dikecilkan sedikit */
            width: auto !important;
            display: block !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .menu-link {
            justify-content: center !important;
            align-items: center !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 50px !important;
            height: 50px !important;
            display: flex !important;
            border-radius: 12px !important;
            /* Sudut melengkung rapi */
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .menu-item {
            width: 80px !important;
            padding: 0 !important;
            margin: 0 0 8px 0 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        /* Sembunyikan garis biru vertikal bawaan Sneat saat collapsed */
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-item.active::before,
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-item.active>.menu-link::before {
            display: none !important;
        }

        /* EXPAND ON HOVER BEHAVIOR (Ketika Collapsed lalu di-hover) */
        html.sidebar-collapsed #layout-menu:hover {
            width: 250px !important;
            max-width: 250px !important;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1) !important;
        }

        html.sidebar-collapsed #layout-menu:hover .app-brand-logo img {
            width: 120px !important;
        }

        /* 3. Responsive Mobile */
        @media (max-width: 1199.98px) {
            #layout-menu {
                transform: translateX(-100%) !important;
            }

            #layout-menu .app-brand {
                display: flex !important;
                /* Pastikan logo muncul di mobile */
                height: 64px;
                padding: 0 1.5rem;
            }

            .layout-page {
                padding-left: 0 !important;
            }

            /* Saat dibuka di mobile */
            html.sidebar-mobile-open #layout-menu {
                transform: translateX(0) !important;
            }

            /* Mencegah scroll body saat sidebar terbuka di mobile */
            html.sidebar-mobile-open {
                overflow: hidden;
            }

            html.sidebar-collapsed #layout-menu {
                width: 250px !important;
                /* Tetap full width di mobile */
                max-width: 250px !important;
            }
        }

        /* Overlay untuk mobile */
        #custom-layout-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1049;
            display: none;
        }

        html.sidebar-mobile-open #custom-layout-overlay {
            display: block;
        }

        /* Menghilangkan garis pemisah (divider) di menu header sidebar */
        .menu-header::before {
            display: none !important;
        }

        /* Prevent sidebar from closing on click if not mobile */
        @media (min-width: 1200px) {
            .layout-menu-toggle {
                display: block !important;
            }
        }

        .app-brand-logo img {
            max-width: 100px;
            height: auto;
            transition: all 0.3s ease;
        }

        /* Submenu icon smaller */
        .menu-sub .menu-icon {
            font-size: 0.65rem !important;
            margin-right: 0.5rem !important;
        }
        /* Modern Profile Dropdown Styling */
        .navbar-nav .dropdown-menu {
            border: none !important;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1) !important;
            border-radius: 16px !important;
            padding: 8px !important;
            min-width: 260px !important;
            margin-top: 15px !important;
            border: 1px solid rgba(0,0,0,0.05) !important;
        }

        .navbar-nav .dropdown-item {
            border-radius: 12px !important;
            padding: 12px 16px !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            margin: 2px 0 !important;
            display: flex !important;
            align-items: center !important;
        }

        .navbar-nav .dropdown-item:hover {
            background-color: rgba(74, 126, 187, 0.08) !important;
            color: #4A7EBB !important;
            transform: translateX(6px);
        }

        .navbar-nav .dropdown-item i {
            font-size: 1.25rem !important;
            color: #4A7EBB !important;
            margin-right: 12px !important;
            opacity: 0.8;
        }

        .navbar-nav .dropdown-divider {
            margin: 8px 8px !important;
            border-color: #f1f3f5 !important;
            opacity: 0.6;
        }

        /* User Header Info in Dropdown */
        .navbar-nav .dropdown-item .avatar img {
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            border: 2px solid #fff;
        }

        .navbar-nav .dropdown-item .fw-semibold {
            font-size: 0.95rem;
            color: #2c3e50;
        }

        .navbar-nav .dropdown-item .text-muted {
            font-size: 0.8rem;
        }

        /* Nav Avatar Shadow */
        .nav-item .avatar img {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .nav-item .avatar:hover img {
            transform: scale(1.08);
            box-shadow: 0 4px 15px rgba(74, 126, 187, 0.2);
        }

    </style>

    <!-- 4. State Management (Anti-Refresh/Flicker) -->
    <script>
        // Eksekusi LANGSUNG sebelum body dirender
        (function() {
            const state = localStorage.getItem('customSidebarState');
            if (state === 'collapsed') {
                document.documentElement.classList.add('sidebar-collapsed');
            }
        })();
    </script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('home') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('storage/aps_mini.png') }}" alt="APS"
                                style="width: 70px; height: auto;">
                        </span>
                    </a>

                    <a href="javascript:void(0);" id="custom-sidebar-close-mobile"
                        class="menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">

                    <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-home"></i>
                            <div data-i18n="Home">Home</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->routeIs('users.profile') ? 'active' : '' }}">
                        <a href="{{ route('users.profile', Auth::user()->id) }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-user"></i>
                            <div data-i18n="Profile">Profile</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->is('schedule*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons fas fa-users"></i>
                            <div data-i18n="Schedule">Schedule</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->routeIs('schedule.now') ? 'active' : '' }}">
                                <a href="{{ route('schedule.now') }}" class="menu-link">
                                    <i class="menu-icon tf-icons fas fa-calendar-day fa-xs me-2"></i>
                                    <div data-i18n="Jadwal Hari Ini">Jadwal Hari Ini</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('schedule.index') ? 'active' : '' }}">
                                <a href="{{ route('schedule.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons fas fa-calendar-alt fa-xs me-2"></i>
                                    <div data-i18n="Data Schedule">Data Schedule</div>
                                </a>
                            </li>
                            @if (in_array(Auth::user()->role, [
                                    'Admin',
                                    'Ass Leader Bge',
                                    'Ass Leader Apron',
                                    'Head Of Airport Service',
                                    'SPV',
                                    'Bge',
                                    'Apron',
                                ]))
                                <li
                                    class="menu-item {{ request()->routeIs('schedule.create') || request()->routeIs('schedule.edit') ? 'active' : '' }}">
                                    <a href="{{ route('schedule.index') }}" class="menu-link">
                                        <i class="menu-icon tf-icons fas fa-calendar-plus fa-xs me-2"></i>
                                        <div data-i18n="Create/Update">Create / Update</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <li class="menu-item {{ request()->routeIs('shift.index') ? 'active' : '' }}">
                        <a href="{{ route('shift.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bi bi-clock"></i>
                            <div data-i18n="Shift">Shift</div>
                        </a>
                    </li>


                    <li
                        class="menu-item {{ request()->is('attendance*') || request()->is('overtime*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons fas fa-clipboard-check"></i>
                            <div data-i18n="Attendance & Lembur">Attendance</div>
                        </a>

                        <ul class="menu-sub">


                            <li class="menu-item {{ request()->routeIs('attendance.index') ? 'active' : '' }}">
                                <a href="{{ route('attendance.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons fas fa-user-clock fa-xs me-2"></i>
                                    <div data-i18n="Absensi Hari Ini">Absensi Hari Ini</div>
                                </a>
                            </li>

                            @if (in_array(Auth::user()->role, ['Admin', 'CHIEF']))
                                <li class="menu-item {{ request()->routeIs('attendance.reports') ? 'active' : '' }}">
                                    <a href="{{ route('attendance.reports') }}" class="menu-link">
                                        <i class="menu-icon tf-icons fas fa-file-invoice fa-xs me-2"></i>
                                        <div data-i18n="Laporan Absensi">Laporan Absensi</div>
                                    </a>
                                </li>
                            @endif


                            <li
                                class="menu-item {{ request()->routeIs('overtime.index') || request()->routeIs('overtime.create') ? 'active' : '' }}">
                                <a href="{{ route('overtime.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons fas fa-history fa-xs me-2"></i>
                                    <div data-i18n="Lembur Saya">Lembur Saya</div>
                                </a>
                            </li>


                            @if (in_array(Auth::user()->role, ['Admin', 'LEADER', 'CHIEF', 'ASS LEADER']))
                                <li class="menu-item {{ request()->routeIs('overtime.approval') ? 'active' : '' }}">
                                    <a href="{{ route('overtime.approval') }}" class="menu-link">
                                        <i class="menu-icon tf-icons fas fa-check-double fa-xs me-2"></i>
                                        <div data-i18n="Approval Lembur">Approval Lembur</div>
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->role == 'Admin')
                                <li class="menu-item {{ request()->routeIs('overtime.report') ? 'active' : '' }}">
                                    <a href="{{ route('overtime.report') }}" class="menu-link">
                                        <i class="menu-icon tf-icons fas fa-chart-line fa-xs me-2"></i>
                                        <div data-i18n="Laporan Lembur">Laporan Lembur</div>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>

                    @if (in_array(Auth::user()->role, ['Admin']))
                        {{-- HEADER KHUSUS ADMIN --}}
                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">Administrator</span>
                        </li>

                        {{-- MENU BARU: STATION MANAGEMENT (ON/OFF) --}}
                        <li class="menu-item {{ request()->routeIs('stations.*') ? 'active' : '' }}">
                            <a href="{{ route('stations.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons fas fa-building"></i>
                                <div data-i18n="Manajemen Station">Manajemen Station</div>
                            </a>
                        </li>

                        <li
                            class="menu-item {{ request()->routeIs('staff.*') || request()->routeIs('blacklist.*') || request()->routeIs('users.kontrak') || request()->routeIs('users.pas') || request()->routeIs('users.tim') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons fas fa-users"></i>
                                <div data-i18n="User Management">User</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                                    <a href="{{ route('staff.index') }}" class="menu-link"
                                        style="color: #f1c40f !important; font-weight: bold;">
                                        <i class="menu-icon tf-icons fas fa-desktop fa-xs me-2"></i>
                                        <div data-i18n="Monitor Station">Monitor Station</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('blacklist.*') ? 'active' : '' }}">
                                    <a href="{{ route('blacklist.index') }}" class="menu-link"
                                        style="color: #000000ff !important; font-weight: bold;">
                                        <i class="menu-icon tf-icons fas fa-user-slash fa-xs me-2"></i>
                                        <div data-i18n="Blacklist"> Blacklist</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('users.kontrak') ? 'active' : '' }}">
                                    <a href="{{ route('users.kontrak') }}" class="menu-link">
                                        <i class="menu-icon tf-icons fas fa-file-contract fa-xs me-2"></i>
                                        <div data-i18n="Kontrak">Kontrak</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('users.pas') ? 'active' : '' }}">
                                    <a href="{{ route('users.pas') }}" class="menu-link">
                                        <i class="menu-icon tf-icons fas fa-id-card fa-xs me-2"></i>
                                        <div data-i18n="PAS Tahunan">PAS Bandara</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('users.tim') ? 'active' : '' }}">
                                    <a href="{{ route('users.tim') }}" class="menu-link">
                                        <i class="menu-icon tf-icons fas fa-id-badge fa-xs me-2"></i>
                                        <div data-i18n="TIM Bandara">TIM Bandara</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Lainnya</span>
                    </li>

                    <li class="menu-item {{ request()->routeIs('document') ? 'active' : '' }}">
                        <a href="{{ route('document') }}" class="menu-link">
                            <i class="menu-icon tf-icons bi bi-files"></i>
                            <div data-i18n="Dokumen">Dokumen</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->is('training*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons fas fa-certificate"></i>
                            <div data-i18n="Training">Training</div>
                        </a>
                        <ul class="menu-sub">
                            @if (in_array(Auth::user()->role, ['Admin', 'CHIEF']))
                                <li class="menu-item {{ request()->routeIs('admin.training.certificates.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.training.certificates.index') }}" class="menu-link">
                                        <i class="menu-icon tf-icons fas fa-tasks fa-xs me-2"></i>
                                        <div data-i18n="Manajemen">Manajemen Training</div>
                                    </a>
                                </li>
                                
                                <li class="menu-item {{ request()->routeIs('admin.training.certificates.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.training.certificates.create') }}" class="menu-link">
                                        <i class="menu-icon tf-icons fas fa-plus-square fa-xs me-2"></i>
                                        <div data-i18n="Tambah">Tambah Sertifikat</div>
                                    </a>
                                </li>
                            @else
                                <li class="menu-item {{ request()->routeIs('my.certificates') ? 'active' : '' }}">
                                    <a href="{{ route('my.certificates') }}" class="menu-link">
                                        <i class="menu-icon tf-icons fas fa-award fa-xs me-2"></i>
                                        <div data-i18n="Saya">Sertifikat Saya</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <li class="menu-item {{ request()->is('leaves*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons fas fa-sign-out-alt"></i>
                            <div data-i18n="Leave">Apply Leave</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->routeIs('leaves.pengajuan') ? 'active' : '' }}">
                                <a href="{{ route('leaves.pengajuan') }}" class="menu-link">
                                    <i class="menu-icon tf-icons fas fa-paper-plane fa-xs me-2"></i>
                                    <div data-i18n="Pengajuan">Pengajuan Leave</div>
                                </a>
                            </li>
                            @if (in_array(Auth::user()->role, [
                                    'Leader Bge',
                                    'Leader Apron',
                                    'Ass Leader Apron',
                                    'Ass Leader Bge',
                                    'Admin',
                                    'SPV',
                                    'Head Of Airport Service',
                                ]))
                                <li class="menu-item {{ request()->routeIs('leaves.index') ? 'active' : '' }}">
                                    <a href="{{ route('leaves.index') }}" class="menu-link">
                                        <i class="menu-icon tf-icons fas fa-check-circle fa-xs me-2"></i>
                                        <div data-i18n="Approval">Approval Leave</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('leaves.laporan') ? 'active' : '' }}">
                                    <a href="{{ route('leaves.laporan') }}" class="menu-link">
                                        <i class="menu-icon tf-icons fas fa-file-alt fa-xs me-2"></i>
                                        <div data-i18n="Laporan">Laporan Leave</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <li class="menu-item mt-3">
                        <div class="menu-link disabled">
                            <i class="menu-icon tf-icons fas fa-clock"></i>
                            <div id="tanggalSekarang">Loading...</div>
                        </div>
                    </li>
                </ul>
            </aside>
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <!-- Tombol Toggle Sidebar (Ditampilkan di semua ukuran layar) -->
                    <div class="navbar-nav align-items-xl-center me-3 me-xl-0">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)"
                            id="custom-sidebar-toggle">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        @if (!empty(Auth::user()->profile_picture))
                                            <img src="{{ asset('storage/photo/' . Auth::user()->profile_picture) }}"
                                                alt="Profile" class="rounded-circle"
                                                style="width: 40px; height: 40px; object-fit: cover;" />
                                        @else
                                            <img src="{{ asset('storage/photo/user.jpg') }}" alt
                                                class="w-px-40 h-auto rounded-circle" />
                                        @endif
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        @if (!empty(Auth::user()->profile_picture))
                                                            <img src="{{ asset('storage/photo/' . Auth::user()->profile_picture) }}"
                                                                alt="Profile" class="rounded-circle"
                                                                style="width: 40px; height: 40px; object-fit: cover;" />
                                                        @else
                                                            <img src="{{ asset('storage/photo/user.jpg') }}" alt
                                                                class="w-px-40 h-auto rounded-circle" />
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-semibold d-block">{{ Auth::user()->fullname }}</span>
                                                    <small class="text-muted">{{ Auth::user()->role }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('users.profile', Auth::user()->id) }}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-center py-3">
                            <div class="text-center">
                                <p class="mb-0" style="font-size: 0.85rem; color: #a1acb8;">
                                    © 2025 <span class="fw-semibold" style="color: #697a8d;">PT. Angkasa Pratama
                                        Sejahtera</span>.
                                    All Rights Reserved.
                                </p>
                            </div>
                        </div>
                    </footer>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay" id="custom-layout-overlay"></div>
    </div>
    <script src="{{ asset('template/') }}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('template/') }}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('template/') }}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('template/') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{ asset('template/') }}/assets/vendor/js/menu.js"></script>

    <script src="{{ asset('template/') }}/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <script src="{{ asset('template/') }}/assets/js/main.js"></script>

    <script src="{{ asset('template/') }}/assets/js/dashboards-analytics.js"></script>

    <script>
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const formattedDate = now.toLocaleDateString('id-ID', options);
            const el = document.getElementById('tanggalSekarang');
            if (el) el.textContent = formattedDate;
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('custom-sidebar-toggle');
            const mobileCloseBtn = document.getElementById('custom-sidebar-close-mobile');
            const overlay = document.getElementById('custom-layout-overlay');
            const htmlTag = document.documentElement;

            function toggleSidebar() {
                const isMobile = window.innerWidth < 1200;

                if (isMobile) {
                    // Logika Mobile: Toggle class sidebar-mobile-open
                    htmlTag.classList.toggle('sidebar-mobile-open');
                } else {
                    // Logika Desktop: Toggle class sidebar-collapsed & simpan ke localStorage
                    htmlTag.classList.toggle('sidebar-collapsed');

                    if (htmlTag.classList.contains('sidebar-collapsed')) {
                        localStorage.setItem('customSidebarState', 'collapsed');
                    } else {
                        localStorage.setItem('customSidebarState', 'expanded');
                    }
                }
            }

            if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);

            if (mobileCloseBtn) {
                mobileCloseBtn.addEventListener('click', function() {
                    htmlTag.classList.remove('sidebar-mobile-open');
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    htmlTag.classList.remove('sidebar-mobile-open');
                });
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1200) {
                    htmlTag.classList.remove('sidebar-mobile-open');
                }
            });

            // State Restoration (Desktop)
            if (window.innerWidth >= 1200) {
                const state = localStorage.getItem('customSidebarState');
                if (state === 'expanded' || !state) {
                    htmlTag.classList.remove('sidebar-collapsed');
                }
            }
        });
    </script>
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
