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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.34.1/dist/tabler-icons.min.css">

    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/css/core.css"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/css/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('template/') }}/assets/css/demo.css" />

    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/libs/apex-charts/apex-charts.css" />

    <script src="{{ asset('template/') }}/assets/vendor/js/helpers.js"></script>
    <script src="{{ asset('template/') }}/assets/js/config.js"></script>

    <!-- pjax-page-styles-start -->
    @yield('styles')
    <!-- pjax-page-styles-end -->
    <style>
        /* --- KUSTOMISASI SIDEBAR SESUAI KRITERIA --- */

        /* 1. Posisi Tetap (Persistent) & Ukuran Proporsional */
        #layout-menu, #layout-menu ul, #layout-menu li {
            list-style: none !important;
            list-style-type: none !important;
        }
        #layout-menu li::before, #layout-menu li::after {
            display: none !important;
            content: none !important;
        }
        #layout-menu {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            bottom: 0 !important;
            margin: 0 !important;
            height: 100vh !important;
            width: 250px !important;
            max-width: 250px !important;
            z-index: 1050 !important;
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease, transform 0.3s ease !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.05);
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
            width: 100% !important;
            max-width: 100% !important;
            border-radius: 0 !important;
            box-shadow: 0 1px 0 0 rgba(15, 23, 42, 0.05) !important;
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border-bottom: 1px solid rgba(229, 231, 235, 0.8) !important;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
            z-index: 1040 !important;
            position: sticky !important;
            top: 0 !important;
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

        /* Ensure no bullets appear on any li items */
        .menu-inner, .menu-sub, .menu-item {
            list-style: none !important;
        }

        /* Suppress default Sneat/Bootstrap bullets in submenus */
        .menu-sub .menu-item::before,
        .menu-sub .menu-item::after {
            display: none !important;
            content: none !important;
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

        /* Modern rounded sidebar */
        :root {
            --sidebar-width: 252px;
            --sidebar-collapsed-width: 74px;
            --sidebar-text: #1f2937;
            --sidebar-muted: #6b7280;
            --sidebar-border: #e5e7eb;
            --sidebar-hover: #eaf4ff;
            --sidebar-active: #2f80ed;
            --sidebar-active-deep: #2368c8;
            --sidebar-active-shadow: rgba(47, 128, 237, 0.28);
        }

        #layout-menu {
            width: var(--sidebar-width) !important;
            max-width: var(--sidebar-width) !important;
            background: #ffffff !important;
            color: var(--sidebar-text) !important;
            border-right: 1px solid var(--sidebar-border) !important;
            box-shadow: none !important;
            padding: 0 !important;
        }

        .layout-page {
            padding-left: var(--sidebar-width) !important;
        }

        #layout-menu .app-brand {
            height: 80px !important;
            min-height: 80px !important;
            padding: 0 18px !important;
            margin: 0 !important;
            border-bottom: 0 !important;
            background: #ffffff !important;
        }

        #layout-menu .app-brand-link,
        #layout-menu .app-brand-logo {
            display: flex !important;
            align-items: center !important;
            min-width: 0 !important;
        }

        #layout-menu .app-brand-logo img {
            width: 78px !important;
            max-width: 78px !important;
            height: auto !important;
            object-fit: contain !important;
            filter: none !important;
            opacity: 1;
        }

        #layout-menu .menu-inner-shadow {
            display: none !important;
        }

        #layout-menu .menu-inner {
            padding: 12px 0 20px !important;
        }

        #layout-menu .menu-header {
            height: auto !important;
            margin: 16px 0 8px !important;
            padding: 0 20px !important;
            border-top: 0 !important;
            color: var(--sidebar-muted) !important;
            font-size: 0.7rem !important;
            font-weight: 400 !important;
            letter-spacing: 0 !important;
            line-height: 1.2 !important;
        }

        #layout-menu .menu-inner > .menu-header:first-child {
            margin-top: 0 !important;
            padding-top: 0 !important;
            border-top: 0 !important;
        }

        #layout-menu .menu-header .menu-header-text {
            color: inherit !important;
        }

        #layout-menu .menu-inner .menu-item {
            margin: 1px 0 !important;
            padding: 0 !important;
        }

        #layout-menu .menu-inner .menu-item > .menu-link {
            width: calc(100% - 52px) !important;
            min-height: 42px !important;
            margin: 0 24px 0 20px !important;
            padding: 0 13px !important;
            border-radius: 9px !important;
            background: transparent !important;
            box-shadow: none !important;
            color: var(--sidebar-text) !important;
            font-size: 0.82rem !important;
            font-weight: 400 !important;
            line-height: 1.2 !important;
            gap: 10px !important;
            transition: background-color 0.18s ease, color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease !important;
        }

        #layout-menu .menu-inner .menu-item > .menu-link:hover,
        #layout-menu .menu-inner .menu-item > .menu-link:focus {
            background: var(--sidebar-hover) !important;
            color: var(--sidebar-active) !important;
        }

        #layout-menu .menu-link .menu-icon {
            width: 20px !important;
            min-width: 20px !important;
            margin-right: 0 !important;
            color: var(--sidebar-text) !important;
            opacity: 0.84 !important;
            text-align: center !important;
            font-size: 1.06rem !important;
            line-height: 1 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        #layout-menu .menu-link .menu-icon.ti {
            font-family: "tabler-icons" !important;
            font-weight: 400 !important;
        }

        #layout-menu .menu-link > div:not(.badge) {
            color: inherit !important;
        }

        #layout-menu .menu-toggle::after {
            color: #9ca3af !important;
            opacity: 0.9 !important;
        }

        #layout-menu .menu-inner .menu-item.active > .menu-link,
        #layout-menu .menu-inner .menu-item.open > .menu-link,
        html:not(.layout-menu-collapsed) .bg-menu-theme .menu-inner .menu-item.open > .menu-link {
            background: linear-gradient(135deg, var(--sidebar-active) 0%, var(--sidebar-active-deep) 100%) !important;
            color: #ffffff !important;
            font-weight: 500 !important;
            box-shadow: 0 8px 18px var(--sidebar-active-shadow) !important;
        }

        #layout-menu .menu-inner .menu-item.active > .menu-link .menu-icon,
        #layout-menu .menu-inner .menu-item.open > .menu-link .menu-icon,
        #layout-menu .menu-inner .menu-item.active > .menu-link div,
        #layout-menu .menu-inner .menu-item.open > .menu-link div {
            color: #ffffff !important;
            font-weight: 500 !important;
            opacity: 1 !important;
        }

        #layout-menu .menu-inner .menu-item.active > .menu-link.menu-toggle::after,
        #layout-menu .menu-inner .menu-item.open > .menu-link.menu-toggle::after {
            color: #ffffff !important;
        }

        #layout-menu .menu-inner .menu-item.active > .menu-link::before,
        #layout-menu .menu-inner .menu-item.active::before,
        #layout-menu .menu-inner .menu-item.active::after,
        #layout-menu .menu-sub > .menu-item > .menu-link::before {
            display: none !important;
            content: none !important;
        }

        #layout-menu .menu-sub {
            margin: 4px 0 6px !important;
            padding: 0 !important;
            background: transparent !important;
        }

        #layout-menu .menu-sub .menu-item > .menu-link {
            width: calc(100% - 82px) !important;
            min-height: 33px !important;
            margin: 1px 30px 1px 44px !important;
            padding: 0 12px !important;
            border-radius: 9px !important;
            color: #4b5563 !important;
            font-size: 0.76rem !important;
            font-weight: 400 !important;
            gap: 9px !important;
        }

        #layout-menu .menu-sub .menu-item.active > .menu-link {
            background: #eef5ff !important;
            color: var(--sidebar-active) !important;
            font-weight: 500 !important;
            box-shadow: none !important;
        }

        #layout-menu .menu-sub .menu-item.active > .menu-link .menu-icon,
        #layout-menu .menu-sub .menu-item.active > .menu-link div {
            color: var(--sidebar-active) !important;
        }

        #layout-menu .sidebar-time {
            margin-top: 14px !important;
            padding-top: 10px !important;
            border-top: 0 !important;
        }

        #layout-menu .sidebar-time .menu-link {
            min-height: auto !important;
            align-items: flex-start !important;
            padding: 9px 14px !important;
            color: #6b7280 !important;
            background: transparent !important;
            cursor: default !important;
        }

        #layout-menu .sidebar-time .menu-icon {
            margin-top: 2px !important;
            color: #6b7280 !important;
        }

        #tanggalSekarang {
            color: #6b7280 !important;
            font-size: 0.76rem !important;
            font-weight: 500 !important;
            line-height: 1.35 !important;
        }

        #custom-sidebar-toggle {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #475569 !important;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
            border-radius: 10px !important;
            box-shadow: 0 2px 4px rgba(15, 23, 42, 0.02) !important;
            transition: all 0.2s ease !important;
        }

        #custom-sidebar-toggle:hover {
            color: #2F80ED !important;
            background: #EAF4FF !important;
            border-color: rgba(47, 128, 237, 0.2) !important;
            transform: scale(1.03);
        }

        html.sidebar-pjax-loading #pjax-content {
            opacity: 0.55;
            pointer-events: none;
        }

        #pjax-content {
            transition: opacity 0.16s ease;
        }

        html.sidebar-collapsed #layout-menu {
            width: var(--sidebar-collapsed-width) !important;
            max-width: var(--sidebar-collapsed-width) !important;
        }

        html.sidebar-collapsed .layout-page {
            padding-left: var(--sidebar-collapsed-width) !important;
        }

        html.sidebar-collapsed #layout-menu:hover {
            width: var(--sidebar-width) !important;
            max-width: var(--sidebar-width) !important;
            box-shadow: 8px 0 24px rgba(15, 23, 42, 0.08) !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .app-brand {
            height: 76px !important;
            min-height: 76px !important;
            padding: 0 !important;
            justify-content: center !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .app-brand-logo img {
            width: 32px !important;
            max-width: 32px !important;
        }

        html.sidebar-collapsed #layout-menu:hover .app-brand-logo img {
            width: 78px !important;
            max-width: 78px !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .menu-inner > .menu-item > .menu-link {
            width: 42px !important;
            height: 42px !important;
            min-height: 42px !important;
            margin: 0 auto !important;
            padding: 0 !important;
            border-radius: 10px !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .menu-inner > .menu-item {
            width: var(--sidebar-collapsed-width) !important;
            margin: 0 0 10px !important;
        }

        @media (max-width: 1199.98px) {
            #layout-menu,
            html.sidebar-collapsed #layout-menu {
                width: 264px !important;
                max-width: 264px !important;
            }

            .layout-page,
            html.sidebar-collapsed .layout-page {
                padding-left: 0 !important;
            }

            #layout-menu .app-brand-logo img,
            html.sidebar-collapsed #layout-menu:hover .app-brand-logo img {
                width: 78px !important;
                max-width: 78px !important;
            }

            #custom-layout-overlay {
                background: rgba(17, 24, 39, 0.32) !important;
            }
        }

        /* Modern Profile Dropdown Styling */
        .dropdown-user .nav-link {
            padding: 0.25rem !important;
            border-radius: 999px;
            transition: background-color 0.18s ease, transform 0.18s ease;
        }

        .dropdown-user .nav-link:hover {
            background: #eaf4ff;
            transform: translateY(-1px);
        }

        .dropdown-user .avatar img {
            border: 2px solid rgba(47, 128, 237, 0.18) !important;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.08) !important;
            transition: all 0.22s ease;
        }

        .dropdown-user .nav-link:hover .avatar img {
            border-color: #2F80ED !important;
            box-shadow: 0 6px 14px rgba(47, 128, 237, 0.16) !important;
        }

        .navbar-nav .dropdown-menu {
            border: 1px solid rgba(226, 232, 240, 0.95) !important;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.14) !important;
            border-radius: 18px !important;
            padding: 0.65rem !important;
            min-width: 292px !important;
            margin-top: 12px !important;
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(14px);
            overflow: hidden;
        }

        .profile-dropdown-card::before {
            display: none;
            content: none;
        }

        .profile-dropdown-header {
            position: relative;
            display: flex;
            gap: 0.85rem;
            align-items: center;
            padding: 0.75rem 0.75rem 0.9rem;
            border-radius: 14px;
            background: linear-gradient(135deg, #f8fbff 0%, #ffffff 70%);
        }

        .profile-dropdown-avatar {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            padding: 3px;
            background: #ffffff;
            box-shadow: 0 14px 30px rgba(47, 128, 237, 0.16);
            flex: 0 0 auto;
        }

        .profile-dropdown-avatar img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            border-radius: 13px !important;
            border: 0 !important;
            box-shadow: none !important;
        }

        .profile-dropdown-status {
            position: absolute;
            left: 47px;
            bottom: 11px;
            width: 13px;
            height: 13px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.12);
        }

        .profile-dropdown-name {
            color: #1f2937;
            font-size: 0.98rem;
            font-weight: 600;
            line-height: 1.25;
            margin-bottom: 0.25rem;
        }

        .profile-dropdown-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.35rem;
            color: #64748b;
            font-size: 0.74rem;
        }

        .profile-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.24rem 0.5rem;
            border-radius: 999px;
            background: #eaf4ff;
            color: #2368c8;
            font-weight: 600;
        }

        .profile-dropdown-menu-group {
            padding-top: 0.45rem;
        }

        .navbar-nav .dropdown-item {
            border-radius: 12px !important;
            padding: 0.68rem 0.75rem !important;
            transition: background-color 0.18s ease, color 0.18s ease, transform 0.18s ease !important;
            margin: 2px 0 !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.7rem;
            color: #334155 !important;
            font-size: 0.88rem;
            font-weight: 500;
        }

        .navbar-nav .dropdown-item:hover {
            background-color: #f8fbff !important;
            color: #2368c8 !important;
            transform: translateX(3px);
        }

        .navbar-nav .dropdown-item i {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: #eaf4ff;
            color: #2368c8 !important;
            font-size: 1.05rem !important;
            margin-right: 0 !important;
            opacity: 1;
            flex: 0 0 auto;
        }

        .navbar-nav .dropdown-item.profile-logout-item {
            color: #dc2626 !important;
        }

        .navbar-nav .dropdown-item.profile-logout-item i {
            background: #fef2f2;
            color: #dc2626 !important;
        }

        .navbar-nav .dropdown-item.profile-logout-item:hover {
            background: #fff7f7 !important;
            color: #b91c1c !important;
        }

        .navbar-nav .dropdown-divider {
            margin: 0.45rem 0.2rem !important;
            border-color: #edf2f7 !important;
            opacity: 1;
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
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
            transition: all 0.3s ease;
            border: 2px solid #ffffff;
        }

        .nav-item .avatar:hover img {
            transform: scale(1.04);
            box-shadow: 0 12px 28px rgba(47, 128, 237, 0.2);
        }

        /* ============================================== */
        /* GLOBAL DATATABLE DESIGN SYSTEM (SaaS Clean)   */
        /* ============================================== */
        :root {
            --aps-blue: #2f80ed;
            --aps-blue-dark: #2368c8;
            --aps-blue-soft: #eaf4ff;
            --aps-amber: #f59e0b;
            --aps-amber-dark: #d97706;
            --aps-amber-soft: #fff7ed;
            --aps-red: #ef4444;
            --aps-red-dark: #dc2626;
            --aps-red-soft: #fef2f2;
            --aps-slate: #111827;
            --aps-muted: #64748b;
            --aps-line: #e6edf5;
        }

        /* --- 1. CARD CONTAINER --- */
        .card:not(.stat-card):not(.modern-card) {
            border: 1px solid var(--aps-line);
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.05) !important;
            border-radius: 1rem;
            background: #ffffff;
            overflow: hidden;
        }
        .card-header:not(.chart-header) {
            background: #ffffff !important;
            border-bottom: 1px solid #f3f4f6 !important;
            padding: 1.25rem 1.5rem !important;
        }
        .card:not(.stat-card):not(.modern-card) > .card-body { padding: 1.5rem !important; }

        /* --- 2. TABLE CORE --- */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            color: #334155;
            margin-bottom: 0;
        }
        .table th {
            background-color: #ffffff !important;
            color: #9aa4b2 !important;
            font-size: 0.72rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.08em;
            padding: 1rem 1.15rem !important;
            border-bottom: 1px solid var(--aps-line) !important;
            border-top: none !important;
            white-space: nowrap;
        }
        .table td {
            background-color: #ffffff !important;
            padding: 1.05rem 1.15rem !important;
            font-size: 0.86rem !important;
            vertical-align: middle;
            border-bottom: 1px solid #edf2f7 !important;
            color: #1f2937;
            line-height: 1.5;
        }
        .table th:last-child,
        .table td:last-child {
            min-width: 7.75rem;
            white-space: nowrap;
        }
        .table td:last-child > .d-flex {
            width: max-content;
        }
        .table tbody tr {
            transition: background-color 0.15s ease, transform 0.15s ease;
        }
        .table tbody tr:hover td {
            background-color: #f8fbff !important;
        }
        .table tbody tr:last-child td {
            border-bottom: none !important;
        }

        /* Kill vertical borders & striped */
        .table-bordered, .table-bordered th, .table-bordered td {
            border-left: none !important;
            border-right: none !important;
            border-top: none !important;
        }
        .table-striped tbody tr:nth-of-type(odd),
        .table-striped tbody tr:nth-of-type(odd) td {
            background-color: transparent !important;
        }
        .table-responsive {
            border-radius: 0.875rem;
            overflow-x: auto;
        }

        /* --- 3. BADGES (Pill / Soft Color) --- */
        .table .badge, .badge {
            font-weight: 500;
            font-size: 0.75rem;
            padding: 0.3em 0.75em;
            border-radius: 9999px;
            border: none;
        }
        /* Soft badge palette (scoped to table only) */
        .table .badge.bg-primary, .table .bg-primary   { background-color: var(--aps-blue-soft) !important; color: var(--aps-blue-dark) !important; }
        .table .badge.bg-success, .table .bg-success    { background-color: #f0fdf4 !important; color: #16a34a !important; }
        .table .badge.bg-warning, .table .bg-warning    { background-color: var(--aps-amber-soft) !important; color: var(--aps-amber-dark) !important; }
        .table .badge.bg-danger,  .table .bg-danger     { background-color: var(--aps-red-soft) !important; color: var(--aps-red-dark) !important; }
        .table .badge.bg-info,    .table .bg-info       { background-color: #f0f9ff !important; color: #0284c7 !important; }
        .table .badge.bg-dark,    .table .bg-dark       { background-color: #f3f4f6 !important; color: #374151 !important; }
        .table .badge.bg-secondary,.table .bg-secondary { background-color: #f3f4f6 !important; color: #6b7280 !important; }

        .bg-label-primary   { background-color: var(--aps-blue-soft) !important; color: var(--aps-blue-dark) !important; }
        .bg-label-success   { background-color: #f0fdf4 !important; color: #16a34a !important; }
        .bg-label-warning   { background-color: var(--aps-amber-soft) !important; color: var(--aps-amber-dark) !important; }
        .bg-label-danger    { background-color: var(--aps-red-soft) !important; color: var(--aps-red-dark) !important; }
        .bg-label-info      { background-color: #f0f9ff !important; color: #0284c7 !important; }

        /* Status badge system for leaves/etc */
        .status-badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.3em 0.75em;
            border-radius: 9999px;
            white-space: nowrap;
        }
        .status-approved  { background-color: #f0fdf4 !important; color: #16a34a !important; }
        .status-rejected  { background-color: #fef2f2 !important; color: #dc2626 !important; }
        .status-pending   { background-color: #fefce8 !important; color: #ca8a04 !important; }
        .status-canceled  { background-color: #f3f4f6 !important; color: #6b7280 !important; }

        /* Row highlight for monitoring pages (kontrak/PAS/TIM) */
        .row-critical td { background-color: #fef2f2 !important; }
        .row-critical:hover td { background-color: #fee2e2 !important; }
        .row-warning td  { background-color: #fffbeb !important; }
        .row-warning:hover td  { background-color: #fef3c7 !important; }

        /* --- 4. CUSTOM PAGINATION (3-Part Layout) --- */
        .dt-pagination-wrapper {
            border-top: 1px solid #f3f4f6;
            margin-top: 1.25rem;
            padding-top: 1rem;
        }
        .dt-pagination {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }
        .dt-pagination-info {
            font-size: 0.8125rem;
            color: #9ca3af;
            white-space: nowrap;
            font-weight: 400;
        }
        .dt-pagination-nav {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .dt-page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.15s ease;
            border: 1px solid transparent;
            background: transparent;
            cursor: pointer;
        }
        .dt-page-btn:hover:not(.disabled):not(.active) {
            background-color: #f3f4f6;
            color: #111827;
        }
        .dt-page-btn.active {
            background-color: #111827;
            color: #ffffff;
            border-color: #111827;
            font-weight: 600;
        }
        .dt-page-btn.disabled {
            color: #d1d5db;
            pointer-events: none;
            cursor: default;
        }
        .dt-page-btn i {
            font-size: 1rem;
        }
        .dt-page-ellipsis {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            font-size: 0.8125rem;
            color: #9ca3af;
        }
        .dt-page-numbers {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .dt-pagination-perpage {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            color: #9ca3af;
        }
        .dt-pagination-perpage select {
            width: auto;
            min-width: 65px;
            height: 36px;
            padding: 0.25rem 2rem 0.25rem 0.625rem;
            font-size: 0.8125rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            color: #374151;
            background-color: #ffffff;
            cursor: pointer;
        }

        /* Legacy pagination - keep for backward compat but style consistently */
        .pagination {
            margin-bottom: 0;
            gap: 0.25rem;
        }
        .page-item .page-link {
            color: #6b7280;
            border: none;
            padding: 0.5rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            line-height: 1.25;
            transition: all 0.15s ease;
        }
        .page-item.active .page-link {
            background-color: #111827 !important;
            border-color: #111827 !important;
            color: #ffffff !important;
            border-radius: 0.5rem;
            font-weight: 500;
        }
        .page-item .page-link:hover {
            background-color: #f3f4f6;
            color: #111827;
        }
        .page-item.disabled .page-link {
            color: #d1d5db;
            background: transparent;
        }

        /* --- 5. NAV TABS (Station Tabs) --- */
        .nav-scroller {
            position: relative;
            z-index: 2;
            height: auto !important;
            overflow-y: visible;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 0;
        }
        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            white-space: nowrap;
        }
        .nav-scroller .nav::-webkit-scrollbar { height: 0; }
        .nav-tabs {
            border-bottom: 1px solid #e5e7eb !important;
        }
        .nav-tabs .nav-link {
            border: none !important;
            border-bottom: 2px solid transparent !important;
            color: #9ca3af;
            padding: 0.75rem 1.25rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border-radius: 0 !important;
        }
        .nav-tabs .nav-link:hover {
            color: #374151;
            border-bottom-color: #d1d5db !important;
            background: transparent !important;
        }
        .nav-tabs .nav-link.active {
            color: #111827 !important;
            border-bottom: 2px solid #111827 !important;
            background: transparent !important;
            font-weight: 600;
        }

        /* --- 6. TOOLBAR (Search + Actions bar) --- */
        .dt-toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 1rem 0;
        }
        .dt-toolbar .dt-search {
            position: relative;
            flex: 1;
            max-width: 320px;
            min-width: 200px;
        }
        .dt-toolbar .dt-search .form-control {
            padding-left: 2.5rem;
            border-radius: 0.75rem;
            border: 1px solid var(--aps-line);
            height: 42px;
            font-size: 0.875rem;
            background: #f9fafb;
            transition: all 0.2s ease;
        }
        .dt-toolbar .dt-search .form-control:focus {
            background: #ffffff;
            border-color: rgba(47, 128, 237, 0.35);
            box-shadow: 0 0 0 4px rgba(47, 128, 237, 0.08);
        }
        .dt-toolbar .dt-search .search-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 0.875rem;
            pointer-events: none;
        }
        .dt-toolbar .dt-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        /* --- 7. FORM CONTROLS (Filters) --- */
        .form-control, .form-select {
            border: 1px solid var(--aps-line);
            border-radius: 0.75rem;
            font-size: 0.875rem;
            color: #374151;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: rgba(47, 128, 237, 0.35);
            box-shadow: 0 0 0 4px rgba(47, 128, 237, 0.08);
        }
        .form-label {
            font-size: 0.8125rem;
            font-weight: 500;
            color: #6b7280;
            margin-bottom: 0.375rem;
        }

        /* --- 8. BUTTONS (Clean style) --- */
        .btn {
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease, border-color 0.18s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--aps-blue) 0%, var(--aps-blue-dark) 100%) !important;
            border-color: var(--aps-blue) !important;
            color: #ffffff !important;
            box-shadow: 0 10px 22px rgba(47, 128, 237, 0.22) !important;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #3b8df3 0%, #1f62c4 100%) !important;
            border-color: var(--aps-blue-dark) !important;
            box-shadow: 0 14px 28px rgba(47, 128, 237, 0.28) !important;
        }
        .btn-warning {
            background: linear-gradient(135deg, #fbbf24 0%, var(--aps-amber) 100%) !important;
            border-color: var(--aps-amber) !important;
            color: #78350f !important;
            box-shadow: 0 10px 22px rgba(245, 158, 11, 0.2) !important;
        }
        .btn-warning:hover {
            background: linear-gradient(135deg, #f59e0b 0%, var(--aps-amber-dark) 100%) !important;
            border-color: var(--aps-amber-dark) !important;
            color: #ffffff !important;
        }
        .btn-danger {
            background: linear-gradient(135deg, var(--aps-red) 0%, var(--aps-red-dark) 100%) !important;
            border-color: var(--aps-red) !important;
            color: #ffffff !important;
            box-shadow: 0 10px 22px rgba(239, 68, 68, 0.2) !important;
        }
        .btn-danger:hover {
            background: linear-gradient(135deg, #f87171 0%, #dc2626 100%) !important;
            border-color: var(--aps-red-dark) !important;
        }
        .create-btn,
        .auto-create-btn {
            background: linear-gradient(135deg, var(--aps-blue) 0%, var(--aps-blue-dark) 100%) !important;
            border: 1px solid var(--aps-blue) !important;
            border-radius: 0.75rem !important;
            color: #ffffff !important;
            box-shadow: 0 10px 22px rgba(47, 128, 237, 0.22) !important;
        }
        .create-btn:hover,
        .auto-create-btn:hover {
            background: linear-gradient(135deg, #3b8df3 0%, #1f62c4 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 14px 28px rgba(47, 128, 237, 0.28) !important;
        }
        .btn-success {
            background-color: #059669 !important;
            border-color: #059669 !important;
        }
        .btn-success:hover {
            background-color: #047857 !important;
            border-color: #047857 !important;
        }
        .btn-outline-secondary {
            border-color: var(--aps-line) !important;
            color: var(--aps-muted) !important;
            background: #ffffff !important;
        }
        .btn-outline-secondary:hover {
            background-color: #f8fbff !important;
            border-color: rgba(47, 128, 237, 0.22) !important;
            color: #374151 !important;
        }
        .btn i,
        .action-btn i {
            font-size: 1rem;
            line-height: 1;
        }
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 0.7rem;
            background: var(--aps-blue-soft) !important;
            color: var(--aps-blue-dark) !important;
            text-decoration: none;
            transition: transform 0.16s ease, box-shadow 0.16s ease, background-color 0.16s ease, color 0.16s ease;
            border: 1px solid rgba(47, 128, 237, 0.16) !important;
            box-shadow: none;
        }
        .action-btn:hover {
            background: var(--aps-blue) !important;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(47, 128, 237, 0.18);
        }
        .action-btn[title*="Edit"],
        .action-btn.action-edit {
            background: var(--aps-amber-soft) !important;
            color: var(--aps-amber-dark) !important;
            border-color: rgba(245, 158, 11, 0.2) !important;
        }
        .action-btn[title*="Edit"]:hover,
        .action-btn.action-edit:hover {
            background: var(--aps-amber) !important;
            color: #ffffff !important;
            box-shadow: 0 10px 22px rgba(245, 158, 11, 0.2);
        }
        .action-btn[title*="Delete"],
        .action-btn[title*="Hapus"],
        .action-btn[title*="Blacklist"],
        .action-btn.action-delete,
        .table .action-btn.bg-danger {
            background: var(--aps-red-soft) !important;
            color: var(--aps-red-dark) !important;
            border-color: rgba(239, 68, 68, 0.2) !important;
        }
        .action-btn[title*="Delete"]:hover,
        .action-btn[title*="Hapus"]:hover,
        .action-btn[title*="Blacklist"]:hover,
        .action-btn.action-delete:hover,
        .table .action-btn.bg-danger:hover {
            background: var(--aps-red) !important;
            color: #ffffff !important;
            box-shadow: 0 10px 22px rgba(239, 68, 68, 0.2);
        }
        .table .btn-sm {
            min-height: 34px;
            padding: 0.45rem 0.85rem;
            font-size: 0.82rem;
        }
        .form-switch .form-check-input {
            width: 2.8rem !important;
            height: 1.45rem !important;
            border-color: #dbe3ee;
            background-color: #e5eaf1;
            cursor: pointer;
            box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.08);
        }
        .form-switch .form-check-input:checked {
            background-color: var(--aps-blue);
            border-color: var(--aps-blue);
            box-shadow: 0 8px 18px rgba(47, 128, 237, 0.24);
        }
        .form-switch .form-check-input:focus {
            box-shadow: 0 0 0 4px rgba(47, 128, 237, 0.1);
        }
        .form-switch .form-check-label {
            color: #475569;
            font-weight: 500;
        }

        /* --- 9. EMPTY STATE --- */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }
        .empty-state i {
            font-size: 2.5rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }
        .empty-state p {
            color: #9ca3af;
            font-size: 0.875rem;
        }

        /* --- 10. RESPONSIVE --- */
        @media (max-width: 768px) {
            .table th, .table td {
                padding: 0.75rem 1rem !important;
            }
            .dt-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
            .dt-toolbar .dt-search {
                max-width: 100%;
            }
            .dt-toolbar .dt-actions {
                flex-wrap: wrap;
            }
            .card-body { padding: 1rem !important; }
            .card-header { padding: 1rem !important; }

            /* Pagination responsive */
            .dt-pagination {
                flex-direction: column;
                align-items: center;
                gap: 0.75rem;
            }
            .dt-page-numbers {
                display: none;
            }
            .dt-pagination-info {
                order: 1;
                text-align: center;
            }
            .dt-pagination-nav {
                order: 2;
            }
            .dt-pagination-perpage {
                order: 3;
            }
        }

        /* --- 11. SWEETALERT2 PREMIUM CUSTOM STYLE --- */
        .swal2-popup {
            border-radius: 1.25rem !important;
            padding: 1.5rem !important;
            font-family: 'Public Sans', sans-serif !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            border: none !important;
        }
        .swal2-title {
            font-size: 1.25rem !important;
            font-weight: 700 !important;
            color: #111827 !important;
            margin-bottom: 0.75rem !important;
        }
        .swal2-html-container {
            font-size: 0.875rem !important;
            color: #4b5563 !important;
            line-height: 1.5 !important;
        }
        .swal2-actions {
            margin-top: 1.5rem !important;
            gap: 0.75rem !important;
        }
        .swal2-confirm, .swal2-cancel {
            margin: 0 !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            padding: 0.625rem 1.25rem !important;
            border-radius: 0.5rem !important;
            box-shadow: none !important;
        }
        .swal2-confirm { background-color: #111827 !important; }
        .swal2-cancel { background-color: #f3f4f6 !important; color: #374151 !important; }
        .swal2-icon { border-width: 2px !important; margin-bottom: 1.25rem !important; }
        .swal2-backdrop-show {
            background: rgba(17, 24, 39, 0.4) !important;
            backdrop-filter: blur(4px) !important;
        }
        .logout-confirm-popup {
            border: 1px solid rgba(226, 232, 240, 0.95) !important;
            border-radius: 1rem !important;
        }
        .logout-confirm-popup .swal2-icon {
            margin-top: 0.5rem !important;
            margin-bottom: 1rem !important;
            color: #ef4444 !important;
            border-color: #fecaca !important;
        }
        .logout-confirm-popup .swal2-title {
            font-size: 1.15rem !important;
            font-weight: 650 !important;
        }
        .logout-confirm-button,
        .logout-cancel-button {
            min-width: 118px;
            border-radius: 0.75rem !important;
            font-size: 0.88rem !important;
            font-weight: 600 !important;
            padding: 0.65rem 1rem !important;
        }
        .logout-confirm-button {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border: 1px solid #ef4444 !important;
            color: #ffffff !important;
            box-shadow: 0 12px 24px rgba(239, 68, 68, 0.2) !important;
        }
        .logout-cancel-button {
            background: #f8fafc !important;
            border: 1px solid #e6edf5 !important;
            color: #475569 !important;
            box-shadow: none !important;
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

            const originalAddEventListener = document.addEventListener.bind(document);
            document.addEventListener = function(type, listener, options) {
                if (type === 'DOMContentLoaded' && document.readyState !== 'loading') {
                    window.setTimeout(function() {
                        const event = new Event('DOMContentLoaded');
                        if (typeof listener === 'function') {
                            listener.call(document, event);
                        } else if (listener && typeof listener.handleEvent === 'function') {
                            listener.handleEvent(event);
                        }
                    }, 0);
                    return;
                }

                return originalAddEventListener(type, listener, options);
            };
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
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Menu</span>
                    </li>

                    <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-layout-dashboard"></i>
                            <div data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->routeIs('users.profile') ? 'active' : '' }}">
                        <a href="{{ route('users.profile', Auth::user()->id) }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-user-circle"></i>
                            <div data-i18n="Profile">Profile</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->is('schedule*') || request()->routeIs('schedule.*') || request()->routeIs('freelance.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-calendar-week"></i>
                            <div data-i18n="Schedule">Schedule</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->routeIs('schedule.now') ? 'active' : '' }}">
                                <a href="{{ route('schedule.now') }}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-calendar-check"></i>
                                    <div data-i18n="Jadwal Hari Ini">Jadwal Hari Ini</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('schedule.index') ? 'active' : '' }}">
                                <a href="{{ route('schedule.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-calendar"></i>
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
                                    class="menu-item {{ request()->routeIs('schedule.create') || request()->routeIs('schedule.edit') || request()->routeIs('schedule.view') || request()->routeIs('schedule.show') ? 'active' : '' }}">
                                    <a href="{{ route('schedule.view') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-calendar-plus"></i>
                                        <div data-i18n="Create/Update">Create / Update</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <li class="menu-item {{ request()->routeIs('shift.index') ? 'active' : '' }}">
                        <a href="{{ route('shift.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-clock"></i>
                            <div data-i18n="Shift">Shift</div>
                        </a>
                    </li>


                    <li
                        class="menu-item {{ request()->is('attendance*') || request()->is('overtime*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-circle-check"></i>
                            <div data-i18n="Attendance & Lembur">Attendance</div>
                        </a>

                        <ul class="menu-sub">


                            <li class="menu-item {{ request()->routeIs('attendance.index') ? 'active' : '' }}">
                                <a href="{{ route('attendance.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-stopwatch"></i>
                                    <div data-i18n="Absensi Hari Ini">Absensi Hari Ini</div>
                                </a>
                            </li>

                            @if (in_array(Auth::user()->role, ['Admin', 'CHIEF']))
                                <li class="menu-item {{ request()->routeIs('attendance.reports') ? 'active' : '' }}">
                                    <a href="{{ route('attendance.reports') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-file-text"></i>
                                        <div data-i18n="Laporan Absensi">Laporan Absensi</div>
                                    </a>
                                </li>
                            @endif


                            <li
                                class="menu-item {{ request()->routeIs('overtime.index') || request()->routeIs('overtime.create') ? 'active' : '' }}">
                                <a href="{{ route('overtime.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-hourglass"></i>
                                    <div data-i18n="Lembur Saya">Lembur Saya</div>
                                </a>
                            </li>


                            @if (in_array(Auth::user()->role, ['Admin', 'LEADER', 'CHIEF', 'ASS LEADER']))
                                <li class="menu-item {{ request()->routeIs('overtime.approval') ? 'active' : '' }}">
                                    <a href="{{ route('overtime.approval') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-circle-check"></i>
                                        <div data-i18n="Approval Lembur">Approval Lembur</div>
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->role == 'Admin')
                                <li class="menu-item {{ request()->routeIs('overtime.report') ? 'active' : '' }}">
                                    <a href="{{ route('overtime.report') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-chart-line"></i>
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
                                <i class="menu-icon tf-icons ti ti-building-store"></i>
                                <div data-i18n="Manajemen Station">Manajemen Station</div>
                            </a>
                        </li>

                        <li
                            class="menu-item {{ request()->routeIs('staff.*') || request()->routeIs('blacklist.*') || request()->routeIs('users.kontrak') || request()->routeIs('users.pas') || request()->routeIs('users.tim') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons ti ti-users"></i>
                                <div data-i18n="User Management">User</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                                    <a href="{{ route('staff.index') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-device-desktop"></i>
                                        <div data-i18n="Monitor Station">Monitor Station</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('blacklist.*') ? 'active' : '' }}">
                                    <a href="{{ route('blacklist.index') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-user-x"></i>
                                        <div data-i18n="Blacklist"> Blacklist</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('users.kontrak') ? 'active' : '' }}">
                                    <a href="{{ route('users.kontrak') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-file-text"></i>
                                        <div data-i18n="Kontrak">Kontrak</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('users.pas') ? 'active' : '' }}">
                                    <a href="{{ route('users.pas') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-id"></i>
                                        <div data-i18n="PAS Tahunan">PAS Bandara</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('users.tim') ? 'active' : '' }}">
                                    <a href="{{ route('users.tim') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-badge"></i>
                                        <div data-i18n="TIM Bandara">TIM Bandara</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">General</span>
                    </li>

                    <li class="menu-item {{ request()->routeIs('document') ? 'active' : '' }}">
                        <a href="{{ route('document') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-file-text"></i>
                            <div data-i18n="Dokumen">Dokumen</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->is('training*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-award"></i>
                            <div data-i18n="Training">Training</div>
                        </a>
                        <ul class="menu-sub">
                            @if (in_array(Auth::user()->role, ['Admin', 'HSE', 'Head Of Airport Service']))
                                <li class="menu-item {{ request()->routeIs('admin.training.certificates.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.training.certificates.index') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-book"></i>
                                        <div data-i18n="Manajemen">Manajemen Training</div>
                                    </a>
                                </li>
                                
                                <li class="menu-item {{ request()->routeIs('admin.training.certificates.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.training.certificates.create') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-circle-plus"></i>
                                        <div data-i18n="Tambah">Tambah Sertifikat</div>
                                    </a>
                                </li>
                            @else
                                <li class="menu-item {{ request()->routeIs('my.certificates') ? 'active' : '' }}">
                                    <a href="{{ route('my.certificates') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-certificate"></i>
                                        <div data-i18n="Saya">Sertifikat Saya</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <li class="menu-item {{ request()->is('leaves*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-logout-2"></i>
                            <div data-i18n="Leave">Apply Leave</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->routeIs('leaves.pengajuan') ? 'active' : '' }}">
                                <a href="{{ route('leaves.pengajuan') }}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-send"></i>
                                    <div data-i18n="Pengajuan">Pengajuan Leave</div>
                                </a>
                            </li>
                            @if (in_array(Auth::user()->role, [
                                
                                    'Admin',
                                    
                                    'Head Of Airport Service',
                                ]))
                                <li class="menu-item {{ request()->routeIs('leaves.index') ? 'active' : '' }}">
                                    <a href="{{ route('leaves.index') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-circle-check"></i>
                                        <div data-i18n="Approval">Approval Leave</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('leaves.laporan') ? 'active' : '' }}">
                                    <a href="{{ route('leaves.laporan') }}" class="menu-link">
                                        <i class="menu-icon tf-icons ti ti-file-text"></i>
                                        <div data-i18n="Laporan">Laporan Leave</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <li class="menu-item {{ request()->routeIs('faq') ? 'active' : '' }}">
                        <a href="{{ route('faq') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-help-circle"></i>
                            <div data-i18n="FAQ">FAQ</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->routeIs('kebijakan') ? 'active' : '' }}">
                        <a href="{{ route('kebijakan') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-shield-check"></i>
                            <div data-i18n="Kebijakan Privasi">Kebijakan Privasi</div>
                        </a>
                    </li>

                    <li class="menu-item mt-3 sidebar-time">
                        <div class="menu-link disabled">
                            <i class="menu-icon tf-icons ti ti-clock"></i>
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
                                                style="width: 40px; height: 40px; object-fit: cover;"
                                                onerror="this.onerror=null; this.src='{{ asset('storage/photo/user.jpg') }}';" />
                                        @else
                                            <img src="{{ asset('storage/photo/user.jpg') }}" alt
                                                class="w-px-40 h-auto rounded-circle" />
                                        @endif
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end profile-dropdown-card">
                                    <li>
                                        <div class="profile-dropdown-header">
                                            <div class="profile-dropdown-avatar">
                                                @if (!empty(Auth::user()->profile_picture))
                                                    <img src="{{ asset('storage/photo/' . Auth::user()->profile_picture) }}"
                                                        alt="Profile"
                                                        onerror="this.onerror=null; this.src='{{ asset('storage/photo/user.jpg') }}';" />
                                                @else
                                                    <img src="{{ asset('storage/photo/user.jpg') }}" alt="Profile" />
                                                @endif
                                                <span class="profile-dropdown-status"></span>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="profile-dropdown-name text-truncate">{{ Auth::user()->fullname }}</div>
                                                <div class="profile-dropdown-meta">
                                                    <span class="profile-role-badge">
                                                        <i class="ti ti-shield-check"></i>
                                                        {{ Auth::user()->role }}
                                                    </span>
                                                    @if (!empty(Auth::user()->station))
                                                        <span>{{ Auth::user()->station }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li class="profile-dropdown-menu-group">
                                        <a class="dropdown-item"
                                            href="{{ route('users.profile', Auth::user()->id) }}">
                                            <i class="ti ti-user-circle"></i>
                                            <span class="align-middle">Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item profile-logout-item" href="{{ route('logout') }}"
                                            id="profile-logout-link">
                                            <i class="ti ti-logout-2"></i>
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
                    <div id="pjax-content" class="container-xxl flex-grow-1 container-p-y">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div id="pjax-page-scripts" hidden>
        @yield('scripts')
    </div>
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
    <script>
        (function() {
            const contentSelector = '#pjax-content';
            const scriptsSelector = '#pjax-page-scripts';
            const sidebarScrollKey = 'apsSidebarScrollTop';
            let activeRequest = null;

            function getSidebarScroller() {
                return document.querySelector('#layout-menu .menu-inner');
            }

            function saveSidebarScroll() {
                const scroller = getSidebarScroller();
                if (scroller) {
                    sessionStorage.setItem(sidebarScrollKey, String(scroller.scrollTop || 0));
                }
            }

            function restoreSidebarScroll() {
                const scroller = getSidebarScroller();
                const saved = Number(sessionStorage.getItem(sidebarScrollKey) || 0);
                if (!scroller || Number.isNaN(saved)) return;

                scroller.scrollTop = saved;
                requestAnimationFrame(function() {
                    scroller.scrollTop = saved;
                });
                setTimeout(function() {
                    scroller.scrollTop = saved;
                }, 120);
            }

            function isSameOriginPage(url) {
                return url.origin === window.location.origin &&
                    (url.pathname !== window.location.pathname || url.search !== window.location.search);
            }

            function shouldHandleLink(event, link) {
                if (!link || event.defaultPrevented) return false;
                if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button !== 0) return false;
                if (link.target && link.target !== '_self') return false;
                if (link.hasAttribute('download')) return false;

                const href = link.getAttribute('href') || '';
                if (!href || href.startsWith('#') || href.startsWith('javascript:')) return false;

                const url = new URL(link.href, window.location.href);
                return isSameOriginPage(url);
            }

            function syncSidebarState(newDocument) {
                const currentItems = document.querySelectorAll('#layout-menu li.menu-item');
                const nextItems = newDocument.querySelectorAll('#layout-menu li.menu-item');
                currentItems.forEach(function(item, index) {
                    const next = nextItems[index];
                    if (next) item.className = next.className;
                });
            }

            function findComment(root, marker) {
                return Array.from(root.childNodes).find(function(node) {
                    return node.nodeType === 8 && node.nodeValue.trim() === marker;
                });
            }

            function nodesBetween(root, startMarker, endMarker) {
                const nodes = Array.from(root.childNodes);
                const startIndex = nodes.indexOf(startMarker);
                const endIndex = nodes.indexOf(endMarker);
                if (startIndex === -1 || endIndex === -1 || endIndex <= startIndex) return [];
                return nodes.slice(startIndex + 1, endIndex);
            }

            async function replacePageStyles(newDocument) {
                const currentStart = findComment(document.head, 'pjax-page-styles-start');
                const currentEnd = findComment(document.head, 'pjax-page-styles-end');
                const nextStart = findComment(newDocument.head, 'pjax-page-styles-start');
                const nextEnd = findComment(newDocument.head, 'pjax-page-styles-end');

                if (!currentStart || !currentEnd || !nextStart || !nextEnd) return;

                nodesBetween(document.head, currentStart, currentEnd).forEach(function(node) {
                    node.remove();
                });

                const inserted = [];
                nodesBetween(newDocument.head, nextStart, nextEnd).forEach(function(node) {
                    const clone = document.importNode(node, true);
                    document.head.insertBefore(clone, currentEnd);
                    inserted.push(clone);
                });

                await Promise.all(inserted.map(function(node) {
                    if (
                        node.nodeType === 1 &&
                        node.tagName === 'LINK' &&
                        (node.getAttribute('rel') || '').toLowerCase() === 'stylesheet'
                    ) {
                        return new Promise(function(resolve) {
                            const timeout = setTimeout(resolve, 1600);
                            node.addEventListener('load', function() {
                                clearTimeout(timeout);
                                resolve();
                            }, { once: true });
                            node.addEventListener('error', function() {
                                clearTimeout(timeout);
                                resolve();
                            }, { once: true });
                        });
                    }

                    return Promise.resolve();
                }));
            }

            async function replacePageScripts(newDocument) {
                const currentScripts = document.querySelector(scriptsSelector);
                const nextScripts = newDocument.querySelector(scriptsSelector);
                if (!currentScripts || !nextScripts) return;

                currentScripts.innerHTML = '';
                const scripts = Array.from(nextScripts.querySelectorAll('script'));

                for (const script of scripts) {
                    await new Promise(function(resolve) {
                        const next = document.createElement('script');

                        Array.from(script.attributes).forEach(function(attribute) {
                            next.setAttribute(attribute.name, attribute.value);
                        });

                        if (script.src) {
                            next.onload = resolve;
                            next.onerror = resolve;
                            next.src = script.src;
                            currentScripts.appendChild(next);
                            return;
                        }

                        next.textContent = script.textContent;
                        currentScripts.appendChild(next);
                        resolve();
                    });
                }
            }

            async function loadContent(url, options) {
                const target = new URL(url, window.location.href);
                const shouldPush = !options || options.push !== false;
                const currentContent = document.querySelector(contentSelector);
                if (!currentContent) {
                    window.location.href = target.href;
                    return;
                }

                saveSidebarScroll();

                if (activeRequest) activeRequest.abort();
                activeRequest = new AbortController();
                const request = activeRequest;
                document.documentElement.classList.add('sidebar-pjax-loading');

                try {
                    const response = await fetch(target.href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-PJAX': 'true'
                        },
                            signal: request.signal
                        });

                    if (!response.ok) throw new Error('Navigation failed');

                    const html = await response.text();
                    const nextDocument = new DOMParser().parseFromString(html, 'text/html');
                    const nextContent = nextDocument.querySelector(contentSelector);
                    if (!nextContent) throw new Error('Missing PJAX content');

                    document.title = nextDocument.title || document.title;
                    await replacePageStyles(nextDocument);
                    currentContent.innerHTML = nextContent.innerHTML;
                    syncSidebarState(nextDocument);
                    await replacePageScripts(nextDocument);

                    if (shouldPush) {
                        history.pushState({
                            pjax: true
                        }, '', target.href);
                    }

                    if (document.scrollingElement) {
                        document.scrollingElement.scrollTop = 0;
                    }
                    restoreSidebarScroll();
                    window.dispatchEvent(new CustomEvent('aps:content-loaded', {
                        detail: {
                            url: target.href
                        }
                    }));
                } catch (error) {
                    if (error.name !== 'AbortError') {
                        window.location.href = target.href;
                    }
                } finally {
                    if (activeRequest === request) activeRequest = null;
                    document.documentElement.classList.remove('sidebar-pjax-loading');
                }
            }

            document.addEventListener('click', function(event) {
                const link = event.target.closest('#layout-menu a.menu-link');
                if (!shouldHandleLink(event, link)) return;

                event.preventDefault();
                loadContent(link.href);
            });

            window.addEventListener('popstate', function() {
                loadContent(window.location.href, {
                    push: false
                });
            });

            window.addEventListener('beforeunload', saveSidebarScroll);
            document.addEventListener('DOMContentLoaded', restoreSidebarScroll);
        })();
    </script>
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('click', function(event) {
            const logoutLink = event.target.closest('#profile-logout-link');
            if (!logoutLink) return;

            event.preventDefault();

            const logoutForm = document.getElementById('logout-form');
            if (!logoutForm) return;

            if (typeof Swal === 'undefined') {
                if (window.confirm('Yakin ingin logout?')) {
                    logoutForm.submit();
                }
                return;
            }

            Swal.fire({
                title: 'Yakin ingin logout?',
                text: 'Sesi akun akan diakhiri dan Anda perlu login kembali.',
                icon: 'question',
                showCancelButton: true,
                reverseButtons: true,
                focusCancel: true,
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'logout-confirm-popup',
                    confirmButton: 'btn logout-confirm-button',
                    cancelButton: 'btn logout-cancel-button'
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    logoutForm.submit();
                }
            });
        });
    </script>
</body>

</html>
