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

        /* Modern floating top bar + round sidebar controls */
        .layout-navbar.navbar-detached {
            min-height: 74px !important;
            height: 74px !important;
            margin: 0 !important;
            padding: 12px 24px !important;
            background: transparent !important;
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        .layout-navbar.navbar-detached::before {
            content: "";
            position: absolute;
            left: 24px;
            right: 24px;
            bottom: 0;
            height: 1px;
            background: linear-gradient(90deg, rgba(226, 232, 240, 0), rgba(226, 232, 240, 0.8), rgba(226, 232, 240, 0));
            pointer-events: none;
        }

        #layout-navbar .navbar-nav.align-items-xl-center {
            min-height: 50px;
        }

        #layout-navbar .navbar-nav-right {
            min-height: 50px;
        }

        #custom-sidebar-toggle {
            width: 52px !important;
            height: 52px !important;
            border-radius: 999px !important;
            background: rgba(255, 255, 255, 0.92) !important;
            border: 1px solid rgba(226, 232, 240, 0.92) !important;
            color: #334155 !important;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            user-select: none;
            -webkit-user-drag: none;
        }

        #custom-sidebar-toggle i {
            font-size: 1.35rem !important;
            line-height: 1 !important;
        }

        #custom-sidebar-toggle:hover {
            color: #2f80ed !important;
            background: #ffffff !important;
            border-color: rgba(47, 128, 237, 0.24) !important;
            box-shadow: 0 16px 32px rgba(47, 128, 237, 0.16) !important;
            transform: translateY(-1px) scale(1.02);
        }

        .dropdown-user .nav-link {
            width: 54px;
            height: 54px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .dropdown-user .avatar,
        .dropdown-user .avatar img {
            width: 42px !important;
            height: 42px !important;
            border-radius: 999px !important;
            overflow: hidden;
        }

        .dropdown-user .avatar::after {
            right: 0 !important;
            bottom: 1px !important;
        }

        #layout-menu .menu-inner .menu-item > .menu-link {
            border-radius: 999px !important;
            min-height: 44px !important;
            padding: 0 10px !important;
            gap: 10px !important;
        }

        #layout-menu .menu-link .menu-icon {
            width: 30px !important;
            height: 30px !important;
            min-width: 30px !important;
            border-radius: 999px !important;
            background: #f8fafc !important;
            color: #475569 !important;
            font-size: 1rem !important;
            transition: background-color 0.18s ease, color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease !important;
        }

        #layout-menu .menu-inner .menu-item > .menu-link:hover .menu-icon,
        #layout-menu .menu-inner .menu-item > .menu-link:focus .menu-icon {
            background: #dbeafe !important;
            color: #2f80ed !important;
            transform: scale(1.04);
        }

        #layout-menu .menu-inner .menu-item.active > .menu-link,
        #layout-menu .menu-inner .menu-item.open > .menu-link,
        html:not(.layout-menu-collapsed) .bg-menu-theme .menu-inner .menu-item.open > .menu-link {
            background: #eaf4ff !important;
            color: #2368c8 !important;
            box-shadow: none !important;
        }

        #layout-menu .menu-inner .menu-item.active > .menu-link .menu-icon,
        #layout-menu .menu-inner .menu-item.open > .menu-link .menu-icon {
            background: linear-gradient(135deg, #2f80ed 0%, #2368c8 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 10px 20px rgba(47, 128, 237, 0.24) !important;
        }

        #layout-menu .menu-inner .menu-item.active > .menu-link div,
        #layout-menu .menu-inner .menu-item.open > .menu-link div {
            color: #2368c8 !important;
            font-weight: 550 !important;
        }

        #layout-menu .menu-sub .menu-item > .menu-link {
            border-radius: 999px !important;
        }

        #layout-menu .menu-sub .menu-item.active > .menu-link {
            background: #f8fbff !important;
            color: #2368c8 !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .menu-inner > .menu-item > .menu-link {
            width: 44px !important;
            height: 44px !important;
            min-height: 44px !important;
            border-radius: 999px !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .menu-link .menu-icon {
            width: 34px !important;
            height: 34px !important;
            min-width: 34px !important;
        }

        @media (max-width: 767.98px) {
            .layout-navbar.navbar-detached {
                height: 70px !important;
                min-height: 70px !important;
                padding: 10px 14px !important;
            }

            .layout-navbar.navbar-detached::before {
                left: 14px;
                right: 14px;
            }

            #custom-sidebar-toggle,
            .dropdown-user .nav-link {
                width: 48px !important;
                height: 48px !important;
            }

            .dropdown-user .avatar,
            .dropdown-user .avatar img {
                width: 38px !important;
                height: 38px !important;
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
            background-color: #eaf4ff;
            color: #2368c8;
            border-color: rgba(47, 128, 237, 0.18);
        }
        .dt-page-btn.active {
            background: linear-gradient(135deg, #2f80ed, #2368c8);
            color: #ffffff;
            border-color: #2f80ed;
            font-weight: 600;
            box-shadow: 0 10px 22px rgba(47, 128, 237, 0.22);
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
            background: linear-gradient(135deg, #2f80ed, #2368c8) !important;
            border-color: #2f80ed !important;
            color: #ffffff !important;
            border-radius: 0.5rem;
            font-weight: 500;
            box-shadow: 0 10px 22px rgba(47, 128, 237, 0.18);
        }
        .page-item .page-link:hover {
            background-color: #eaf4ff;
            color: #2368c8;
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

        /* Final polish: calmer topbar and softer sidebar shell */
        html,
        body,
        .layout-wrapper,
        .layout-container,
        .layout-page,
        .content-wrapper {
            background: #f9fafb !important;
        }

        .layout-navbar.navbar-detached {
            position: sticky !important;
            top: 0 !important;
            height: 66px !important;
            min-height: 66px !important;
            margin: 0 !important;
            padding: 10px 26px !important;
            background: #f9fafb !important;
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            overflow: visible !important;
        }

        .layout-navbar.navbar-detached::before {
            display: none !important;
            content: none !important;
        }

        #layout-navbar .navbar-nav.align-items-xl-center,
        #layout-navbar .navbar-nav-right {
            min-height: 46px !important;
        }

        #custom-sidebar-toggle,
        .dropdown-user .nav-link {
            width: 46px !important;
            height: 46px !important;
            border-radius: 999px !important;
            background: #ffffff !important;
            border: 1px solid rgba(226, 232, 240, 0.95) !important;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.07) !important;
            cursor: pointer !important;
            user-select: none !important;
            -webkit-user-select: none !important;
            -webkit-user-drag: none !important;
            touch-action: manipulation !important;
        }

        #custom-sidebar-toggle {
            color: #334155 !important;
        }

        #custom-sidebar-toggle i {
            font-size: 1.32rem !important;
            line-height: 1 !important;
        }

        #custom-sidebar-toggle:hover,
        .dropdown-user .nav-link:hover {
            background: #eef6ff !important;
            border-color: rgba(47, 128, 237, 0.22) !important;
            box-shadow: 0 14px 28px rgba(47, 128, 237, 0.14) !important;
            transform: translateY(-1px) !important;
        }

        #custom-sidebar-toggle:hover {
            color: #2f80ed !important;
        }

        .dropdown-user .avatar,
        .dropdown-user .avatar img {
            width: 38px !important;
            height: 38px !important;
            border-radius: 999px !important;
        }

        .dropdown-user .avatar img {
            border: 2px solid #ffffff !important;
            box-shadow: 0 5px 14px rgba(15, 23, 42, 0.10) !important;
            -webkit-user-drag: none !important;
        }

        .dropdown-user .avatar::after {
            right: -1px !important;
            bottom: 2px !important;
            width: 10px !important;
            height: 10px !important;
            border: 2px solid #ffffff !important;
        }

        #layout-menu {
            border-right: 1px solid rgba(226, 232, 240, 0.9) !important;
            border-radius: 0 26px 26px 0 !important;
            box-shadow: 10px 0 30px rgba(15, 23, 42, 0.045) !important;
            overflow-x: hidden !important;
        }

        #layout-menu .app-brand {
            border-radius: 0 26px 0 0 !important;
        }

        #layout-menu .menu-inner .menu-item > .menu-link {
            width: calc(100% - 44px) !important;
            min-height: 42px !important;
            margin: 2px 24px 2px 20px !important;
            padding: 0 9px !important;
            border-radius: 999px !important;
            font-weight: 430 !important;
        }

        #layout-menu .menu-link .menu-icon {
            width: 30px !important;
            height: 30px !important;
            min-width: 30px !important;
            border-radius: 999px !important;
            background: transparent !important;
            color: #475569 !important;
        }

        #layout-menu .menu-inner .menu-item > .menu-link:hover {
            background: #f1f7ff !important;
            color: #2368c8 !important;
        }

        #layout-menu .menu-inner .menu-item > .menu-link:hover .menu-icon {
            background: #dbeafe !important;
            color: #2f80ed !important;
        }

        #layout-menu .menu-inner .menu-item.active > .menu-link,
        #layout-menu .menu-inner .menu-item.open > .menu-link,
        html:not(.layout-menu-collapsed) .bg-menu-theme .menu-inner .menu-item.open > .menu-link {
            background: #eaf4ff !important;
            color: #2368c8 !important;
            box-shadow: none !important;
        }

        #layout-menu .menu-inner .menu-item.active > .menu-link .menu-icon,
        #layout-menu .menu-inner .menu-item.open > .menu-link .menu-icon {
            background: linear-gradient(135deg, #2f80ed 0%, #2368c8 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 8px 18px rgba(47, 128, 237, 0.22) !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) {
            border-radius: 0 22px 22px 0 !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .menu-inner > .menu-item > .menu-link {
            width: 42px !important;
            height: 42px !important;
            min-height: 42px !important;
            margin: 2px auto !important;
            border-radius: 999px !important;
        }

        html.sidebar-collapsed #layout-menu:not(:hover) .menu-link .menu-icon {
            width: 32px !important;
            height: 32px !important;
            min-width: 32px !important;
        }

        @media (max-width: 767.98px) {
            .layout-navbar.navbar-detached {
                height: 62px !important;
                min-height: 62px !important;
                padding: 8px 14px !important;
            }

            #custom-sidebar-toggle,
            .dropdown-user .nav-link {
                width: 44px !important;
                height: 44px !important;
            }

            .dropdown-user .avatar,
            .dropdown-user .avatar img {
                width: 36px !important;
                height: 36px !important;
            }
        }

        /* Requested topbar refresh + collapsed sidebar fix */
        .layout-navbar.navbar-detached {
            height: 72px !important;
            min-height: 72px !important;
            padding: 12px 26px !important;
            background: transparent !important;
            border: 0 !important;
            border-bottom: 0 !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        #custom-sidebar-toggle {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        #custom-sidebar-toggle,
        .dropdown-user .nav-link {
            width: 48px !important;
            height: 48px !important;
            background: #ffffff !important;
            border: 1px solid rgba(226, 232, 240, 0.96) !important;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.08) !important;
        }

        .dropdown-user .topbar-user-chip.nav-link {
            width: auto !important;
            min-width: 260px !important;
            max-width: 360px !important;
            height: 52px !important;
            padding: 0.38rem 0.95rem 0.38rem 0.42rem !important;
            border-radius: 999px !important;
            background: #ffffff !important;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.08) !important;
        }

        .dropdown-user .topbar-user-chip.nav-link:hover {
            background: #ffffff !important;
            border-color: rgba(47, 128, 237, 0.24) !important;
            box-shadow: 0 18px 36px rgba(47, 128, 237, 0.16) !important;
        }

        #custom-sidebar-toggle:hover,
        .dropdown-user .nav-link:hover {
            background: #ffffff !important;
            border-color: rgba(47, 128, 237, 0.24) !important;
            box-shadow: 0 18px 36px rgba(47, 128, 237, 0.16) !important;
        }

        .dropdown-user .avatar,
        .dropdown-user .avatar img {
            width: 36px !important;
            height: 36px !important;
        }

        html.sidebar-collapsed #layout-menu,
        html.sidebar-collapsed #layout-menu:hover {
            width: 86px !important;
            max-width: 86px !important;
            border-radius: 0 24px 24px 0 !important;
            box-shadow: 10px 0 28px rgba(15, 23, 42, 0.05) !important;
        }

        html.sidebar-collapsed .layout-page {
            padding-left: 86px !important;
        }

        html.sidebar-collapsed #layout-menu .app-brand,
        html.sidebar-collapsed #layout-menu:hover .app-brand {
            height: 76px !important;
            min-height: 76px !important;
            padding: 0 !important;
            justify-content: center !important;
            border-radius: 0 24px 0 0 !important;
        }

        html.sidebar-collapsed #layout-menu .app-brand-link,
        html.sidebar-collapsed #layout-menu:hover .app-brand-link {
            justify-content: center !important;
            width: 100% !important;
        }

        html.sidebar-collapsed #layout-menu .app-brand-logo img,
        html.sidebar-collapsed #layout-menu:hover .app-brand-logo img {
            width: 48px !important;
            max-width: 48px !important;
        }

        html.sidebar-collapsed #layout-menu .menu-header,
        html.sidebar-collapsed #layout-menu:hover .menu-header,
        html.sidebar-collapsed #layout-menu .menu-link div,
        html.sidebar-collapsed #layout-menu:hover .menu-link div,
        html.sidebar-collapsed #layout-menu .menu-sub,
        html.sidebar-collapsed #layout-menu:hover .menu-sub,
        html.sidebar-collapsed #layout-menu .menu-toggle::after,
        html.sidebar-collapsed #layout-menu:hover .menu-toggle::after {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }

        html.sidebar-collapsed #layout-menu .menu-inner,
        html.sidebar-collapsed #layout-menu:hover .menu-inner {
            padding: 10px 0 18px !important;
        }

        html.sidebar-collapsed #layout-menu .menu-inner > .menu-item,
        html.sidebar-collapsed #layout-menu:hover .menu-inner > .menu-item {
            width: 86px !important;
            height: 48px !important;
            margin: 2px 0 8px !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        html.sidebar-collapsed #layout-menu .menu-inner > .menu-item > .menu-link,
        html.sidebar-collapsed #layout-menu:hover .menu-inner > .menu-item > .menu-link {
            width: 44px !important;
            height: 44px !important;
            min-height: 44px !important;
            margin: 0 auto !important;
            padding: 0 !important;
            border-radius: 999px !important;
            background: transparent !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: none !important;
        }

        html.sidebar-collapsed #layout-menu .menu-link .menu-icon,
        html.sidebar-collapsed #layout-menu:hover .menu-link .menu-icon {
            width: 34px !important;
            height: 34px !important;
            min-width: 34px !important;
            margin: 0 !important;
            border-radius: 999px !important;
            background: transparent !important;
            color: #64748b !important;
            font-size: 1.08rem !important;
        }

        html.sidebar-collapsed #layout-menu .menu-inner .menu-item.active > .menu-link,
        html.sidebar-collapsed #layout-menu .menu-inner .menu-item.open > .menu-link,
        html.sidebar-collapsed #layout-menu:hover .menu-inner .menu-item.active > .menu-link,
        html.sidebar-collapsed #layout-menu:hover .menu-inner .menu-item.open > .menu-link {
            background: #eaf4ff !important;
        }

        html.sidebar-collapsed #layout-menu .menu-inner .menu-item.active > .menu-link .menu-icon,
        html.sidebar-collapsed #layout-menu .menu-inner .menu-item.open > .menu-link .menu-icon,
        html.sidebar-collapsed #layout-menu:hover .menu-inner .menu-item.active > .menu-link .menu-icon,
        html.sidebar-collapsed #layout-menu:hover .menu-inner .menu-item.open > .menu-link .menu-icon {
            background: linear-gradient(135deg, #2f80ed 0%, #2368c8 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 8px 18px rgba(47, 128, 237, 0.22) !important;
        }

        @media (max-width: 767.98px) {
            .layout-navbar.navbar-detached {
                height: 66px !important;
                min-height: 66px !important;
                padding: 9px 14px !important;
                background: transparent !important;
                border: 0 !important;
                box-shadow: none !important;
            }

            #custom-sidebar-toggle,
            .dropdown-user .nav-link {
                width: 44px !important;
                height: 44px !important;
            }
        }

        /* Professional APS topbar search */
        .layout-navbar.navbar-detached {
            height: 82px !important;
            min-height: 82px !important;
            padding: 12px 26px !important;
            background: transparent !important;
            border: 0 !important;
            box-shadow: none !important;
            overflow: visible !important;
        }

        .aps-topbar {
            display: grid;
            grid-template-columns: auto minmax(130px, 190px) minmax(240px, 560px) 1fr;
            align-items: center;
            gap: 0.9rem;
            width: 100%;
            min-width: 0;
        }

        .topbar-date {
            min-width: 0;
            line-height: 1.15;
        }

        .topbar-date span {
            display: block;
            color: #94a3b8;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .topbar-date strong {
            display: block;
            color: #334155;
            font-size: 0.88rem;
            font-weight: 650;
            white-space: nowrap;
        }

        .topbar-search-trigger {
            width: 100%;
            min-width: 0;
            height: 50px;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0 1.1rem;
            border: 1px solid #e6edf5;
            border-radius: 999px;
            background: #eef2f8;
            color: #64748b;
            font-size: 0.88rem;
            font-weight: 500;
            text-align: left;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
            transition: border-color 0.18s ease, background-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        .topbar-search-trigger i {
            color: #475569;
            font-size: 1.24rem;
        }

        .topbar-search-trigger:hover,
        .topbar-search-trigger:focus {
            border-color: rgba(47, 128, 237, 0.22);
            background: #ffffff;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
        }

        .topbar-search-trigger kbd {
            margin-left: auto;
            padding: 0.18rem 0.45rem;
            border: 1px solid #dbe5f0;
            border-radius: 999px;
            background: #ffffff;
            color: #94a3b8;
            font-size: 0.68rem;
            font-weight: 650;
            box-shadow: none;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.7rem;
            min-width: 0;
        }

        .topbar-right .navbar-nav,
        .topbar-right .dropdown-user {
            min-width: 0;
        }

        .topbar-user-chip {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 0;
            padding: 0.38rem 0.8rem 0.38rem 0.42rem;
            border: 1px solid #e6edf5;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.055);
            cursor: pointer;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        .topbar-user-chip:hover,
        .topbar-user-chip:focus {
            border-color: rgba(47, 128, 237, 0.22);
            box-shadow: 0 18px 36px rgba(47, 128, 237, 0.14);
            transform: translateY(-1px);
        }

        .topbar-user-mini-avatar {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            object-fit: cover;
            border: 2px solid #ffffff;
            box-shadow: 0 6px 14px rgba(15, 23, 42, 0.1);
            flex: 0 0 auto;
        }

        .topbar-user-text {
            min-width: 0;
            line-height: 1.12;
        }

        .topbar-user-text strong {
            display: block;
            max-width: 190px;
            color: #1f2937;
            font-size: 0.86rem;
            font-weight: 680;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .topbar-user-text span {
            display: block;
            max-width: 190px;
            color: #64748b;
            font-size: 0.74rem;
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .topbar-lang-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            height: 44px;
            padding: 0 0.85rem;
            border-radius: 999px;
            border: 1px solid #e6edf5;
            background: #eef2f8;
            color: #64748b;
            font-size: 0.76rem;
            font-weight: 700;
        }

        .topbar-lang-pill i {
            color: #f59e0b;
            font-size: 1.15rem;
        }

        .topbar-lang-pill .active {
            color: #2f80ed;
        }

        .topbar-lang-pill .divider {
            width: 1px;
            height: 18px;
            background: #cbd5e1;
        }

        #custom-sidebar-toggle,
        .dropdown-user .nav-link {
            width: 48px !important;
            height: 48px !important;
            background: #ffffff !important;
            border: 1px solid rgba(226, 232, 240, 0.96) !important;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.08) !important;
        }

        .aps-menu-search {
            position: fixed;
            inset: 0;
            z-index: 2000;
            display: none;
            align-items: flex-start;
            justify-content: center;
            padding: 6vh 1rem 1rem;
            background: rgba(15, 23, 42, 0.28);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .aps-menu-search.is-open {
            display: flex;
        }

        html.aps-search-open {
            overflow: hidden;
        }

        .aps-menu-search-panel {
            width: min(760px, 100%);
            max-height: min(720px, 86vh);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, 0.98);
            border-radius: 24px;
            background: #ffffff;
            box-shadow: 0 30px 90px rgba(15, 23, 42, 0.22);
        }

        .aps-menu-search-head {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 1rem;
            border-bottom: 1px solid #eef2f7;
        }

        .aps-menu-search-icon {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #eaf4ff;
            color: #2f80ed;
            flex: 0 0 auto;
            font-size: 1.25rem;
        }

        .aps-menu-search-input {
            width: 100%;
            min-width: 0;
            border: 0;
            outline: 0;
            color: #1f2937;
            font-size: 1rem;
            font-weight: 550;
            background: transparent;
        }

        .aps-menu-search-input::placeholder {
            color: #94a3b8;
            font-weight: 500;
        }

        .aps-menu-search-close {
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 999px;
            background: #f1f5f9;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
        }

        .aps-menu-search-body {
            padding: 0.75rem;
            overflow: auto;
        }

        .aps-menu-search-group {
            margin-bottom: 0.85rem;
        }

        .aps-menu-search-group-title {
            padding: 0.45rem 0.65rem;
            color: #94a3b8;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .aps-menu-search-item {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.72rem;
            border-radius: 16px;
            color: #334155;
            text-decoration: none;
            transition: background-color 0.16s ease, transform 0.16s ease;
        }

        .aps-menu-search-item:hover,
        .aps-menu-search-item:focus {
            background: #f1f7ff;
            color: #2368c8;
            transform: translateY(-1px);
        }

        .aps-menu-search-item-icon {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #eaf4ff;
            color: #2f80ed;
            flex: 0 0 auto;
            font-size: 1.12rem;
        }

        .aps-menu-search-item strong {
            display: block;
            color: inherit;
            font-size: 0.9rem;
            font-weight: 650;
            line-height: 1.2;
        }

        .aps-menu-search-item span {
            display: block;
            margin-top: 0.1rem;
            color: #94a3b8;
            font-size: 0.74rem;
            font-weight: 500;
        }

        .aps-menu-search-empty {
            display: none;
            padding: 2.2rem 1rem;
            color: #94a3b8;
            text-align: center;
            font-size: 0.9rem;
        }

        .aps-menu-search-empty.is-visible {
            display: block;
        }

        .aps-menu-search-foot {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-top: 1px solid #eef2f7;
            color: #94a3b8;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .aps-menu-search-foot kbd {
            padding: 0.12rem 0.42rem;
            border: 1px solid #dbe5f0;
            border-radius: 8px;
            background: #f8fafc;
            color: #64748b;
            box-shadow: none;
        }

        @media (max-width: 1199.98px) {
            .aps-topbar {
                grid-template-columns: auto minmax(180px, 1fr) auto;
            }

            .topbar-date,
            .topbar-lang-pill {
                display: none !important;
            }

            .topbar-user-chip {
                width: 48px !important;
                min-width: 48px !important;
                max-width: 48px !important;
                height: 48px !important;
                padding: 0 !important;
                justify-content: center;
            }

            .topbar-user-chip .topbar-user-text {
                display: none;
            }
        }

        @media (max-width: 767.98px) {
            .layout-navbar.navbar-detached {
                height: 70px !important;
                min-height: 70px !important;
                padding: 10px 14px !important;
            }

            .aps-topbar {
                gap: 0.6rem;
            }

            .topbar-search-trigger {
                height: 44px;
                padding: 0 0.9rem;
            }

            .topbar-search-trigger span {
                max-width: 86px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .topbar-search-trigger kbd {
                display: none;
            }

            .topbar-user-chip {
                width: 44px !important;
                min-width: 44px !important;
                max-width: 44px !important;
                height: 44px !important;
            }

            .topbar-user-mini-avatar {
                width: 36px;
                height: 36px;
            }

            .aps-menu-search {
                padding: 0.75rem;
            }

            .aps-menu-search-panel {
                max-height: calc(100vh - 1.5rem);
                border-radius: 20px;
            }

            .aps-menu-search-foot {
                display: none;
            }
        }

        /* Final topbar capsule + working theme switch */
        .layout-navbar.navbar-detached {
            height: 100px !important;
            min-height: 100px !important;
            padding: 14px 26px !important;
            background: transparent !important;
            border: 0 !important;
            box-shadow: none !important;
        }

        .aps-topbar {
            grid-template-columns: auto minmax(128px, 190px) minmax(240px, 1fr) auto !important;
            min-height: 72px !important;
            padding: 0.62rem 0.72rem !important;
            border: 1px solid rgba(226, 232, 240, 0.96) !important;
            border-radius: 999px !important;
            background: rgba(255, 255, 255, 0.96) !important;
            box-shadow: 0 22px 56px rgba(15, 23, 42, 0.08) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        .topbar-search-trigger {
            height: 48px !important;
            box-shadow: none !important;
        }

        .topbar-theme-switch {
            display: inline-flex;
            align-items: center;
            gap: 0.22rem;
            height: 48px;
            padding: 0.24rem;
            border: 1px solid #e6edf5;
            border-radius: 999px;
            background: #eef2f8;
            flex: 0 0 auto;
        }

        .topbar-theme-option {
            height: 38px;
            min-width: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            padding: 0 0.68rem;
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: #64748b;
            font-size: 0.74rem;
            font-weight: 700;
            transition: background-color 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
        }

        .topbar-theme-option i {
            font-size: 1.05rem;
        }

        .topbar-theme-option.is-active {
            background: #ffffff;
            color: #2f80ed;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
        }

        .dropdown-user .topbar-user-chip.nav-link {
            height: 48px !important;
        }

        html.aps-dark,
        html.aps-dark body,
        html.aps-dark .layout-wrapper,
        html.aps-dark .layout-container,
        html.aps-dark .layout-page,
        html.aps-dark .content-wrapper {
            background: #0f172a !important;
            color: #dbe7f6 !important;
        }

        html.aps-dark .aps-topbar,
        html.aps-dark #layout-menu,
        html.aps-dark .card,
        html.aps-dark .profile-card,
        html.aps-dark .modal-content,
        html.aps-dark .swal2-popup {
            background: #111c31 !important;
            border-color: #24324a !important;
            color: #dbe7f6 !important;
            box-shadow: 0 22px 56px rgba(0, 0, 0, 0.26) !important;
        }

        html.aps-dark #layout-menu .app-brand {
            background: #111c31 !important;
        }

        html.aps-dark .text-dark,
        html.aps-dark .card-title,
        html.aps-dark h1,
        html.aps-dark h2,
        html.aps-dark h3,
        html.aps-dark h4,
        html.aps-dark h5,
        html.aps-dark h6,
        html.aps-dark .topbar-date strong,
        html.aps-dark .topbar-user-text strong,
        html.aps-dark #layout-menu .menu-inner .menu-item > .menu-link {
            color: #eaf1fb !important;
        }

        html.aps-dark .text-muted,
        html.aps-dark .topbar-date span,
        html.aps-dark .topbar-user-text span,
        html.aps-dark .menu-header,
        html.aps-dark .tile-label,
        html.aps-dark .info-label,
        html.aps-dark .small,
        html.aps-dark .text-secondary {
            color: #94a3b8 !important;
        }

        html.aps-dark .topbar-search-trigger,
        html.aps-dark .topbar-theme-switch,
        html.aps-dark #custom-sidebar-toggle,
        html.aps-dark .dropdown-user .topbar-user-chip.nav-link,
        html.aps-dark .dropdown-menu,
        html.aps-dark .aps-menu-search-panel,
        html.aps-dark .info-tile,
        html.aps-dark .profile-info-item {
            background: #17233a !important;
            border-color: #2a3a55 !important;
            color: #dbe7f6 !important;
        }

        html.aps-dark .topbar-search-trigger:hover,
        html.aps-dark .topbar-search-trigger:focus,
        html.aps-dark .dropdown-user .topbar-user-chip.nav-link:hover,
        html.aps-dark #custom-sidebar-toggle:hover,
        html.aps-dark .aps-menu-search-item:hover,
        html.aps-dark .profile-info-item:hover,
        html.aps-dark .info-tile:hover {
            background: #1d2b45 !important;
            border-color: rgba(47, 128, 237, 0.45) !important;
        }

        html.aps-dark .topbar-theme-option {
            color: #94a3b8;
        }

        html.aps-dark .topbar-theme-option.is-active,
        html.aps-dark .topbar-search-trigger kbd,
        html.aps-dark .aps-menu-search-foot kbd {
            background: #22304a !important;
            color: #7db6ff !important;
            border-color: #344966 !important;
        }

        html.aps-dark .topbar-search-trigger i,
        html.aps-dark #custom-sidebar-toggle i {
            color: #cbd5e1 !important;
        }

        html.aps-dark #layout-menu .menu-link .menu-icon {
            background: transparent !important;
            color: #9fb1c7 !important;
        }

        html.aps-dark #layout-menu .menu-inner .menu-item > .menu-link:hover,
        html.aps-dark #layout-menu .menu-inner .menu-item.active > .menu-link,
        html.aps-dark #layout-menu .menu-inner .menu-item.open > .menu-link {
            background: rgba(47, 128, 237, 0.16) !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .aps-menu-search {
            background: rgba(2, 6, 23, 0.66) !important;
        }

        html.aps-dark .aps-menu-search-head,
        html.aps-dark .aps-menu-search-foot,
        html.aps-dark .dropdown-divider,
        html.aps-dark .table,
        html.aps-dark .table th,
        html.aps-dark .table td {
            border-color: #24324a !important;
        }

        html.aps-dark .aps-menu-search-input {
            color: #eaf1fb !important;
        }

        html.aps-dark .aps-menu-search-input::placeholder {
            color: #7d8fa8 !important;
        }

        html.aps-dark .bg-white,
        html.aps-dark .bg-navbar-theme,
        html.aps-dark .bg-footer-theme,
        html.aps-dark .form-control,
        html.aps-dark .form-select,
        html.aps-dark .flatpickr-input {
            background-color: #111c31 !important;
            border-color: #2a3a55 !important;
            color: #dbe7f6 !important;
        }

        @media (max-width: 1199.98px) {
            .topbar-theme-option span {
                display: none;
            }
        }

        @media (max-width: 767.98px) {
            .layout-navbar.navbar-detached {
                height: 78px !important;
                min-height: 78px !important;
                padding: 9px 10px !important;
            }

            .aps-topbar {
                min-height: 58px !important;
                gap: 0.46rem !important;
                padding: 0.42rem !important;
            }

            .topbar-theme-switch {
                height: 44px;
                padding: 0.2rem;
            }

            .topbar-theme-option {
                width: 34px;
                min-width: 34px;
                height: 34px;
                padding: 0;
            }
        }

        /* Fix search icon visibility, collapsed sidebar centering, and phone layout */
        .aps-menu-search-item .aps-menu-search-item-icon {
            width: 42px !important;
            height: 42px !important;
            min-width: 42px !important;
            margin: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 999px !important;
            background: #eaf4ff !important;
            color: #2f80ed !important;
            font-size: 1.12rem !important;
            line-height: 1 !important;
        }

        .aps-menu-search-item .aps-menu-search-item-icon i {
            display: block !important;
            color: currentColor !important;
            font-size: 1.12rem !important;
            line-height: 1 !important;
        }

        .aps-menu-search-item > span:not(.aps-menu-search-item-icon) {
            display: block;
            min-width: 0;
        }

        html.sidebar-collapsed #layout-menu,
        html.sidebar-collapsed #layout-menu:hover {
            width: 92px !important;
            max-width: 92px !important;
        }

        html.sidebar-collapsed .layout-page {
            padding-left: 92px !important;
        }

        html.sidebar-collapsed #layout-menu .app-brand,
        html.sidebar-collapsed #layout-menu:hover .app-brand {
            width: 92px !important;
            padding: 0 !important;
            justify-content: center !important;
        }

        html.sidebar-collapsed #layout-menu .menu-inner > .menu-item,
        html.sidebar-collapsed #layout-menu:hover .menu-inner > .menu-item {
            width: 92px !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin: 0 0 8px !important;
            padding: 0 !important;
        }

        html.sidebar-collapsed #layout-menu .menu-inner > .menu-item > .menu-link,
        html.sidebar-collapsed #layout-menu:hover .menu-inner > .menu-item > .menu-link {
            width: 46px !important;
            height: 46px !important;
            min-height: 46px !important;
            margin: 0 auto !important;
            padding: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 999px !important;
        }

        html.sidebar-collapsed #layout-menu .menu-link .menu-icon,
        html.sidebar-collapsed #layout-menu:hover .menu-link .menu-icon {
            width: 34px !important;
            height: 34px !important;
            min-width: 34px !important;
            margin: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        html.sidebar-collapsed #layout-menu .sidebar-time {
            display: none !important;
        }

        html.aps-dark .aps-menu-search-item .aps-menu-search-item-icon {
            background: rgba(47, 128, 237, 0.18) !important;
            color: #8fc2ff !important;
        }

        @media (max-width: 767.98px) {
            .aps-topbar {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                grid-template-columns: none !important;
                width: 100% !important;
                min-width: 0 !important;
            }

            .topbar-search-trigger {
                width: clamp(108px, 30vw, 150px) !important;
                min-width: 108px !important;
                max-width: 150px !important;
                height: 44px !important;
                padding: 0 0.82rem !important;
                justify-content: flex-start !important;
                flex: 0 1 clamp(108px, 30vw, 150px) !important;
                gap: 0.5rem !important;
                background: #f3f7fc !important;
            }

            .topbar-search-trigger kbd {
                display: none !important;
            }

            .topbar-search-trigger span {
                display: inline-block !important;
                max-width: 74px !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
                white-space: nowrap !important;
                font-size: 0.78rem !important;
            }

            .topbar-search-trigger i {
                font-size: 1.1rem !important;
                flex: 0 0 auto !important;
            }

            .topbar-right {
                flex: 0 0 auto !important;
                gap: 0.38rem !important;
            }

            .dropdown-user .topbar-user-chip.nav-link {
                width: 44px !important;
                min-width: 44px !important;
                max-width: 44px !important;
                height: 44px !important;
                padding: 0 !important;
                display: inline-flex !important;
                justify-content: center !important;
            }

            .dropdown-user .topbar-user-chip.nav-link .topbar-user-text {
                display: none !important;
            }
        }

        @media (max-width: 480px) {
            .layout-navbar.navbar-detached {
                padding: 8px 8px !important;
            }

            .aps-topbar {
                gap: 0.34rem !important;
                padding: 0.38rem !important;
            }

            #custom-sidebar-toggle,
            .topbar-user-chip {
                width: 40px !important;
                min-width: 40px !important;
                max-width: 40px !important;
                height: 40px !important;
            }

            .dropdown-user .topbar-user-chip.nav-link {
                width: 40px !important;
                min-width: 40px !important;
                max-width: 40px !important;
                height: 40px !important;
                flex-basis: 40px !important;
            }

            .topbar-search-trigger {
                width: clamp(92px, 28vw, 116px) !important;
                min-width: 92px !important;
                max-width: 116px !important;
                height: 40px !important;
                padding: 0 0.68rem !important;
                flex-basis: clamp(92px, 28vw, 116px) !important;
            }

            .topbar-search-trigger span {
                max-width: 48px !important;
                font-size: 0.74rem !important;
            }

            .topbar-theme-switch {
                height: 40px !important;
                flex: 0 0 auto !important;
            }

            .topbar-theme-option {
                width: 30px !important;
                min-width: 30px !important;
                height: 30px !important;
            }

            .topbar-user-mini-avatar {
                width: 32px !important;
                height: 32px !important;
            }
        }

        /* Lock collapsed sidebar so hover/non-hover never shifts */
        html.sidebar-collapsed #layout-menu,
        html.sidebar-collapsed #layout-menu:hover,
        html.sidebar-collapsed #layout-menu:not(:hover) {
            width: 92px !important;
            min-width: 92px !important;
            max-width: 92px !important;
            border-radius: 0 26px 26px 0 !important;
            transform: none !important;
            transition: width 0.28s cubic-bezier(0.22, 0.61, 0.36, 1),
                min-width 0.28s cubic-bezier(0.22, 0.61, 0.36, 1),
                max-width 0.28s cubic-bezier(0.22, 0.61, 0.36, 1),
                box-shadow 0.22s ease !important;
            box-shadow: 10px 0 28px rgba(15, 23, 42, 0.05) !important;
            will-change: width, min-width, max-width;
        }

        html.sidebar-collapsed .layout-page,
        html.sidebar-collapsed #layout-menu:hover + .layout-page {
            padding-left: 92px !important;
            transition: padding-left 0.28s cubic-bezier(0.22, 0.61, 0.36, 1) !important;
        }

        html.sidebar-collapsed #layout-menu .app-brand,
        html.sidebar-collapsed #layout-menu:hover .app-brand,
        html.sidebar-collapsed #layout-menu:not(:hover) .app-brand {
            width: 92px !important;
            min-width: 92px !important;
            max-width: 92px !important;
            height: 82px !important;
            min-height: 82px !important;
            padding: 0 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        html.sidebar-collapsed #layout-menu .app-brand-link,
        html.sidebar-collapsed #layout-menu:hover .app-brand-link,
        html.sidebar-collapsed #layout-menu:not(:hover) .app-brand-link,
        html.sidebar-collapsed #layout-menu .app-brand-logo,
        html.sidebar-collapsed #layout-menu:hover .app-brand-logo,
        html.sidebar-collapsed #layout-menu:not(:hover) .app-brand-logo {
            width: 92px !important;
            min-width: 92px !important;
            max-width: 92px !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin: 0 !important;
        }

        html.sidebar-collapsed #layout-menu .app-brand-logo img,
        html.sidebar-collapsed #layout-menu:hover .app-brand-logo img,
        html.sidebar-collapsed #layout-menu:not(:hover) .app-brand-logo img {
            width: 48px !important;
            max-width: 48px !important;
            margin: 0 !important;
        }

        html.sidebar-collapsed #layout-menu .menu-inner,
        html.sidebar-collapsed #layout-menu:hover .menu-inner,
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-inner {
            width: 92px !important;
            min-width: 92px !important;
            max-width: 92px !important;
            padding: 10px 0 18px !important;
            overflow-x: hidden !important;
        }

        html.sidebar-collapsed #layout-menu .menu-inner > .menu-item,
        html.sidebar-collapsed #layout-menu:hover .menu-inner > .menu-item,
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-inner > .menu-item {
            width: 92px !important;
            height: 50px !important;
            margin: 0 0 8px !important;
            padding: 0 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        html.sidebar-collapsed #layout-menu .menu-inner > .menu-item > .menu-link,
        html.sidebar-collapsed #layout-menu:hover .menu-inner > .menu-item > .menu-link,
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-inner > .menu-item > .menu-link {
            width: 46px !important;
            min-width: 46px !important;
            max-width: 46px !important;
            height: 46px !important;
            min-height: 46px !important;
            margin: 0 auto !important;
            padding: 0 !important;
            display: inline-flex !important;
            justify-content: center !important;
            align-items: center !important;
            border-radius: 999px !important;
            gap: 0 !important;
            transition: background-color 0.18s ease, color 0.18s ease, box-shadow 0.18s ease !important;
        }

        html.sidebar-collapsed #layout-menu .menu-link .menu-icon,
        html.sidebar-collapsed #layout-menu:hover .menu-link .menu-icon,
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-link .menu-icon {
            width: 34px !important;
            min-width: 34px !important;
            max-width: 34px !important;
            height: 34px !important;
            margin: 0 !important;
            display: inline-flex !important;
            justify-content: center !important;
            align-items: center !important;
            font-size: 1.08rem !important;
        }

        html.sidebar-collapsed #layout-menu .menu-link div,
        html.sidebar-collapsed #layout-menu:hover .menu-link div,
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-link div,
        html.sidebar-collapsed #layout-menu .menu-header,
        html.sidebar-collapsed #layout-menu:hover .menu-header,
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-header,
        html.sidebar-collapsed #layout-menu .menu-sub,
        html.sidebar-collapsed #layout-menu:hover .menu-sub,
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-sub,
        html.sidebar-collapsed #layout-menu .menu-toggle::after,
        html.sidebar-collapsed #layout-menu:hover .menu-toggle::after,
        html.sidebar-collapsed #layout-menu:not(:hover) .menu-toggle::after,
        html.sidebar-collapsed #layout-menu .sidebar-time,
        html.sidebar-collapsed #layout-menu:hover .sidebar-time,
        html.sidebar-collapsed #layout-menu:not(:hover) .sidebar-time {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }

        @media (min-width: 1200px) {
            html.sidebar-collapsed #layout-menu:hover,
            html.sidebar-collapsed.sidebar-peeking #layout-menu {
                width: var(--sidebar-width, 252px) !important;
                min-width: var(--sidebar-width, 252px) !important;
                max-width: var(--sidebar-width, 252px) !important;
                border-radius: 0 26px 26px 0 !important;
                transition: width 0.3s cubic-bezier(0.22, 0.61, 0.36, 1) 0.08s,
                    min-width 0.3s cubic-bezier(0.22, 0.61, 0.36, 1) 0.08s,
                    max-width 0.3s cubic-bezier(0.22, 0.61, 0.36, 1) 0.08s,
                    box-shadow 0.22s ease !important;
                box-shadow: 10px 0 30px rgba(15, 23, 42, 0.045) !important;
                z-index: 1060 !important;
            }

            html.sidebar-collapsed #layout-menu:hover + .layout-page,
            html.sidebar-collapsed.sidebar-peeking .layout-page {
                padding-left: var(--sidebar-width, 252px) !important;
            }

            html.sidebar-collapsed #layout-menu:hover .app-brand,
            html.sidebar-collapsed #layout-menu:hover .app-brand-link,
            html.sidebar-collapsed #layout-menu:hover .app-brand-logo,
            html.sidebar-collapsed #layout-menu:hover .menu-inner,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .app-brand,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .app-brand-link,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .app-brand-logo,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner {
                width: var(--sidebar-width, 252px) !important;
                min-width: var(--sidebar-width, 252px) !important;
                max-width: var(--sidebar-width, 252px) !important;
            }

            html.sidebar-collapsed #layout-menu:hover .app-brand,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .app-brand {
                height: 80px !important;
                min-height: 80px !important;
                justify-content: flex-start !important;
                padding: 0 18px !important;
            }

            html.sidebar-collapsed #layout-menu:hover .app-brand-link,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .app-brand-link {
                justify-content: flex-start !important;
            }

            html.sidebar-collapsed #layout-menu:hover .app-brand-logo,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .app-brand-logo {
                width: auto !important;
                min-width: 0 !important;
                max-width: none !important;
                justify-content: flex-start !important;
            }

            html.sidebar-collapsed #layout-menu:hover .app-brand-logo img,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .app-brand-logo img {
                width: 78px !important;
                max-width: 78px !important;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-inner,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner {
                padding: 12px 0 20px !important;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-inner > .menu-item,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner > .menu-item {
                width: 100% !important;
                min-width: 0 !important;
                max-width: none !important;
                height: auto !important;
                margin: 1px 0 !important;
                padding: 0 !important;
                display: block !important;
                justify-content: initial !important;
                align-items: initial !important;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-inner > .menu-item > .menu-link,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner > .menu-item > .menu-link {
                width: calc(100% - 44px) !important;
                min-width: 0 !important;
                max-width: none !important;
                height: auto !important;
                min-height: 42px !important;
                margin: 2px 24px 2px 20px !important;
                padding: 0 9px !important;
                border-radius: 999px !important;
                box-sizing: border-box !important;
                display: flex !important;
                align-items: center !important;
                justify-content: flex-start !important;
                gap: 10px !important;
                text-align: left !important;
                white-space: nowrap !important;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-inner .menu-item.active > .menu-link,
            html.sidebar-collapsed #layout-menu:hover .menu-inner .menu-item.open > .menu-link,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner .menu-item.active > .menu-link,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner .menu-item.open > .menu-link {
                background: #eaf4ff !important;
                color: #2368c8 !important;
                box-shadow: none !important;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-inner .menu-item.active > .menu-link .menu-icon,
            html.sidebar-collapsed #layout-menu:hover .menu-inner .menu-item.open > .menu-link .menu-icon,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner .menu-item.active > .menu-link .menu-icon,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner .menu-item.open > .menu-link .menu-icon {
                background: linear-gradient(135deg, #2f80ed 0%, #2368c8 100%) !important;
                color: #ffffff !important;
                box-shadow: 0 8px 18px rgba(47, 128, 237, 0.22) !important;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-inner .menu-item.active > .menu-link div,
            html.sidebar-collapsed #layout-menu:hover .menu-inner .menu-item.open > .menu-link div,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner .menu-item.active > .menu-link div,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner .menu-item.open > .menu-link div {
                color: #2368c8 !important;
                font-weight: 550 !important;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-link .menu-icon,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-link .menu-icon {
                width: 30px !important;
                min-width: 30px !important;
                max-width: 30px !important;
                height: 30px !important;
                margin: 0 !important;
                border-radius: 999px !important;
                background: transparent !important;
                box-shadow: none !important;
                font-size: 1rem !important;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-link div,
            html.sidebar-collapsed #layout-menu:hover .menu-header,
            html.sidebar-collapsed #layout-menu:hover .menu-toggle::after,
            html.sidebar-collapsed #layout-menu:hover .sidebar-time,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-link div,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-header,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-toggle::after,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .sidebar-time {
                display: block !important;
                opacity: 1 !important;
                visibility: visible !important;
                animation: sidebarPeekContentIn 0.18s ease 0.1s both;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-link div,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-link div {
                flex: 1 !important;
                min-width: 0 !important;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-toggle::after,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-toggle::after {
                display: inline-block !important;
                margin-left: auto !important;
                color: #9ca3af !important;
                opacity: 0.9 !important;
                visibility: visible !important;
                position: static !important;
                flex: 0 0 auto !important;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-sub,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-sub {
                margin: 4px 0 6px !important;
                padding: 0 !important;
                background: transparent !important;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-sub .menu-item > .menu-link,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-sub .menu-item > .menu-link {
                width: calc(100% - 82px) !important;
                min-height: 33px !important;
                margin: 1px 30px 1px 44px !important;
                padding: 0 12px !important;
                border-radius: 999px !important;
                font-size: 0.76rem !important;
                gap: 9px !important;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-inner > .menu-item.open > .menu-sub,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner > .menu-item.open > .menu-sub {
                display: block !important;
                opacity: 1 !important;
                visibility: visible !important;
                animation: sidebarPeekContentIn 0.18s ease 0.12s both;
            }

            html.sidebar-collapsed #layout-menu:hover .menu-inner > .menu-item:not(.open) > .menu-sub,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner > .menu-item:not(.open) > .menu-sub {
                display: none !important;
                opacity: 0 !important;
                visibility: hidden !important;
            }

            html.aps-dark.sidebar-collapsed #layout-menu:hover,
            html.aps-dark.sidebar-collapsed.sidebar-peeking #layout-menu {
                box-shadow: 0 22px 56px rgba(0, 0, 0, 0.26) !important;
            }

            html.aps-dark.sidebar-collapsed #layout-menu:hover .menu-inner .menu-item.active > .menu-link,
            html.aps-dark.sidebar-collapsed #layout-menu:hover .menu-inner .menu-item.open > .menu-link,
            html.aps-dark.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner .menu-item.active > .menu-link,
            html.aps-dark.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner .menu-item.open > .menu-link {
                background: rgba(47, 128, 237, 0.16) !important;
                color: #8fc2ff !important;
            }
        }

        @keyframes sidebarPeekContentIn {
            from {
                opacity: 0;
                transform: translateX(-8px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html.sidebar-collapsed #layout-menu {
                transition: none !important;
            }

            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-link div,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-header,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-toggle::after,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .sidebar-time,
            html.sidebar-collapsed.sidebar-peeking #layout-menu .menu-inner > .menu-item.open > .menu-sub {
                animation: none !important;
            }
        }

        /* Topbar final color tune: match the white sidebar */
        .aps-topbar {
            background: #ffffff !important;
            border-color: rgba(226, 232, 240, 0.9) !important;
            box-shadow: 0 18px 44px rgba(15, 23, 42, 0.055) !important;
        }

        .topbar-search-trigger,
        .topbar-theme-switch {
            background: #f8fafc !important;
            border-color: #e8eef6 !important;
        }

        .topbar-search-trigger:hover,
        .topbar-search-trigger:focus {
            background: #ffffff !important;
            border-color: rgba(47, 128, 237, 0.22) !important;
        }

        .topbar-theme-option.is-active,
        .dropdown-user .topbar-user-chip.nav-link,
        #custom-sidebar-toggle {
            background: #ffffff !important;
        }

        .dropdown-user .topbar-user-chip.nav-link {
            border-color: #e8eef6 !important;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.055) !important;
        }

        /* Force pure white topbar surface, no translucent tint */
        .layout-navbar.navbar-detached,
        .layout-navbar.navbar-detached.bg-navbar-theme,
        #layout-navbar {
            background: transparent !important;
            background-color: transparent !important;
            box-shadow: none !important;
            border: 0 !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        .layout-navbar.navbar-detached::before,
        .layout-navbar.navbar-detached::after,
        #layout-navbar::before,
        #layout-navbar::after {
            display: none !important;
            content: none !important;
            background: transparent !important;
        }

        .aps-topbar,
        html:not(.aps-dark) .aps-topbar {
            background: #fff !important;
            background-color: #fff !important;
            background-image: none !important;
            border-color: #e6edf5 !important;
            box-shadow: 0 18px 44px rgba(15, 23, 42, 0.045) !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        html:not(.aps-dark) .topbar-search-trigger,
        html:not(.aps-dark) .topbar-theme-switch {
            background: #f9fafb !important;
            background-color: #f9fafb !important;
            background-image: none !important;
        }

        /* Absolute white only for the topbar wrapper card */
        html:not(.aps-dark) #layout-navbar .aps-topbar {
            background: #ffffff !important;
            background-color: #ffffff !important;
            background-image: none !important;
            border-color: #ffffff !important;
            outline: 3px solid #ffffff !important;
            box-shadow: 0 0 0 1px #ffffff, 0 8px 22px rgba(15, 23, 42, 0.024) !important;
            background-clip: border-box !important;
            opacity: 1 !important;
            filter: none !important;
        }

        html:not(.aps-dark) #layout-navbar .topbar-search-trigger,
        html:not(.aps-dark) #layout-navbar .topbar-theme-switch {
            background: #f9fafb !important;
            background-color: #f9fafb !important;
            background-image: none !important;
        }

        html:not(.aps-dark) #layout-navbar .topbar-theme-option.is-active,
        html:not(.aps-dark) #layout-navbar .topbar-user-chip,
        html:not(.aps-dark) #layout-navbar #custom-sidebar-toggle,
        html:not(.aps-dark) #layout-navbar .topbar-search-trigger kbd {
            background: #ffffff !important;
            background-color: #ffffff !important;
            background-image: none !important;
        }

        html:not(.aps-dark) #layout-navbar .topbar-search-trigger,
        html:not(.aps-dark) #layout-navbar .topbar-theme-switch,
        html:not(.aps-dark) #layout-navbar .topbar-user-chip,
        html:not(.aps-dark) #layout-navbar #custom-sidebar-toggle {
            border-color: #eef2f7 !important;
        }

        /* Topbar size and subtle inactive controls */
        .layout-navbar.navbar-detached {
            height: 86px !important;
            min-height: 86px !important;
            padding: 10px 24px !important;
        }

        #layout-navbar .aps-topbar {
            min-height: 62px !important;
            padding: 0.42rem 0.55rem !important;
        }

        #layout-navbar .topbar-search-trigger {
            height: 42px !important;
            padding: 0 0.95rem !important;
        }

        html:not(.aps-dark) #layout-navbar .topbar-search-trigger,
        html:not(.aps-dark) #layout-navbar .topbar-theme-switch {
            background: #f5f7fb !important;
            background-color: #f5f7fb !important;
        }

        #layout-navbar .topbar-theme-switch {
            height: 42px !important;
            padding: 0.18rem !important;
        }

        #layout-navbar .topbar-theme-option {
            height: 34px !important;
            min-width: 34px !important;
            padding: 0 0.58rem !important;
        }

        html:not(.aps-dark) #layout-navbar .topbar-theme-option:not(.is-active) {
            background: transparent !important;
            color: #64748b !important;
        }

        #layout-navbar #custom-sidebar-toggle,
        #layout-navbar .dropdown-user .topbar-user-chip.nav-link {
            height: 42px !important;
        }

        #layout-navbar #custom-sidebar-toggle {
            width: 42px !important;
        }

        #layout-navbar .topbar-user-mini-avatar {
            width: 34px !important;
            height: 34px !important;
        }

        @media (max-width: 767.98px) {
            .layout-navbar.navbar-detached {
                height: 70px !important;
                min-height: 70px !important;
                padding: 8px 10px !important;
            }

            #layout-navbar .aps-topbar {
                min-height: 54px !important;
                padding: 0.34rem !important;
                outline-width: 2px !important;
            }

            #layout-navbar .topbar-search-trigger,
            #layout-navbar #custom-sidebar-toggle,
            #layout-navbar .dropdown-user .topbar-user-chip.nav-link {
                height: 38px !important;
            }

            #layout-navbar #custom-sidebar-toggle,
            #layout-navbar .dropdown-user .topbar-user-chip.nav-link {
                width: 38px !important;
                min-width: 38px !important;
                max-width: 38px !important;
            }

            #layout-navbar .topbar-user-mini-avatar {
                width: 30px !important;
                height: 30px !important;
            }

            #layout-navbar .topbar-theme-switch {
                height: 38px !important;
            }

            #layout-navbar .topbar-theme-option {
                width: 29px !important;
                min-width: 29px !important;
                height: 29px !important;
                padding: 0 !important;
            }
        }

        /* Dark mode surface polish for cards, datatables, forms, and popups */
        html.aps-dark body,
        html.aps-dark .content-wrapper,
        html.aps-dark .container-xxl,
        html.aps-dark .container-p-y {
            background-color: #0b1220 !important;
        }

        html.aps-dark .card:not(.stat-card),
        html.aps-dark .modern-card,
        html.aps-dark .table-responsive,
        html.aps-dark .modal-content,
        html.aps-dark .swal2-popup {
            background: #111c31 !important;
            border-color: #24324a !important;
            color: #dbe7f6 !important;
            box-shadow: 0 18px 48px rgba(0, 0, 0, 0.24) !important;
        }

        html.aps-dark .card-header:not(.chart-header),
        html.aps-dark .modal-header,
        html.aps-dark .modal-footer,
        html.aps-dark .dt-pagination-wrapper {
            background: #111c31 !important;
            border-color: #24324a !important;
        }

        html.aps-dark .card-body,
        html.aps-dark .modal-body {
            color: #dbe7f6 !important;
        }

        html.aps-dark .table,
        html.aps-dark table {
            --bs-table-bg: #111c31 !important;
            --bs-table-color: #dbe7f6 !important;
            --bs-table-striped-bg: #142037 !important;
            --bs-table-striped-color: #d7e2f1 !important;
            --bs-table-hover-bg: #172942 !important;
            --bs-table-hover-color: #eef5ff !important;
            --bs-table-border-color: #24324a !important;
            color: #dbe7f6 !important;
            background: #111c31 !important;
        }

        html.aps-dark .table thead,
        html.aps-dark .table th,
        html.aps-dark .table-custom thead th {
            background: #17233a !important;
            color: #95a6bd !important;
            border-color: #263653 !important;
        }

        html.aps-dark .table tbody tr,
        html.aps-dark .table tbody td,
        html.aps-dark .table-custom tbody td {
            background: #111c31 !important;
            color: #d7e2f1 !important;
            border-color: #24324a !important;
            box-shadow: none !important;
        }

        html.aps-dark .table tbody tr:hover td,
        html.aps-dark .table-hover tbody tr:hover td,
        html.aps-dark .clickable-row:hover {
            background: #172942 !important;
            color: #eef5ff !important;
            box-shadow: inset 0 0 0 9999px rgba(23, 41, 66, 0.94) !important;
        }

        html.aps-dark .table > :not(caption) > * > *,
        html.aps-dark .table-bordered > :not(caption) > * > * {
            border-color: #24324a !important;
        }

        html.aps-dark .table-striped > tbody > tr:nth-of-type(odd) > *,
        html.aps-dark .table-striped tbody tr:nth-of-type(odd) td,
        html.aps-dark .table-striped tbody tr:nth-of-type(odd) th,
        html.aps-dark .table-striped tbody tr:nth-of-type(odd) {
            background: #142037 !important;
            color: #d7e2f1 !important;
            box-shadow: inset 0 0 0 9999px rgba(20, 32, 55, 0.94) !important;
        }

        html.aps-dark .table-hover > tbody > tr:hover > *,
        html.aps-dark .table-striped > tbody > tr:hover > * {
            background: #172942 !important;
            color: #eef5ff !important;
            box-shadow: inset 0 0 0 9999px rgba(23, 41, 66, 0.94) !important;
        }

        html.aps-dark .row-critical td {
            background: rgba(239, 68, 68, 0.14) !important;
        }

        html.aps-dark .row-warning td {
            background: rgba(245, 158, 11, 0.12) !important;
        }

        html.aps-dark .dt-toolbar .dt-search .form-control,
        html.aps-dark .form-control,
        html.aps-dark .form-select,
        html.aps-dark .input-group-text,
        html.aps-dark .flatpickr-input,
        html.aps-dark textarea,
        html.aps-dark select {
            background-color: #101a2c !important;
            border-color: #2a3a55 !important;
            color: #e6edf7 !important;
        }

        html.aps-dark .form-control::placeholder,
        html.aps-dark textarea::placeholder {
            color: #72849e !important;
        }

        html.aps-dark .form-control:focus,
        html.aps-dark .form-select:focus {
            background-color: #111f35 !important;
            border-color: rgba(47, 128, 237, 0.62) !important;
            box-shadow: 0 0 0 4px rgba(47, 128, 237, 0.14) !important;
        }

        html.aps-dark .form-label,
        html.aps-dark label,
        html.aps-dark .dt-pagination-info,
        html.aps-dark .dt-pagination-perpage,
        html.aps-dark .page-item.disabled .page-link {
            color: #8fa1b8 !important;
        }

        html.aps-dark .dt-page-btn,
        html.aps-dark .page-item .page-link,
        html.aps-dark .dt-pagination-perpage select {
            background: #101a2c !important;
            border-color: #2a3a55 !important;
            color: #c7d4e6 !important;
        }

        html.aps-dark .dt-page-btn:hover:not(.disabled):not(.active),
        html.aps-dark .page-item .page-link:hover {
            background: #1b2b45 !important;
            color: #ffffff !important;
            border-color: rgba(47, 128, 237, 0.42) !important;
        }

        html.aps-dark .dt-page-btn.active,
        html.aps-dark .page-item.active .page-link {
            background: linear-gradient(135deg, #2f80ed, #2368c8) !important;
            border-color: #2f80ed !important;
            color: #ffffff !important;
            box-shadow: 0 10px 22px rgba(47, 128, 237, 0.22) !important;
        }

        html.aps-dark .btn-outline-secondary {
            background: #101a2c !important;
            border-color: #2a3a55 !important;
            color: #c7d4e6 !important;
        }

        html.aps-dark .btn-outline-secondary:hover {
            background: #1b2b45 !important;
            border-color: rgba(47, 128, 237, 0.45) !important;
            color: #ffffff !important;
        }

        html.aps-dark .action-btn {
            background: rgba(47, 128, 237, 0.16) !important;
            border-color: rgba(47, 128, 237, 0.28) !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .action-btn:hover {
            background: #2f80ed !important;
            color: #ffffff !important;
        }

        html.aps-dark .action-btn[title*="Edit"],
        html.aps-dark .action-btn.action-edit {
            background: rgba(245, 158, 11, 0.15) !important;
            border-color: rgba(245, 158, 11, 0.28) !important;
            color: #fbbf24 !important;
        }

        html.aps-dark .action-btn[title*="Edit"]:hover,
        html.aps-dark .action-btn.action-edit:hover {
            background: #f59e0b !important;
            color: #ffffff !important;
        }

        html.aps-dark .action-btn[title*="Delete"],
        html.aps-dark .action-btn[title*="Hapus"],
        html.aps-dark .action-btn[title*="Blacklist"],
        html.aps-dark .action-btn.action-delete,
        html.aps-dark .table .action-btn.bg-danger {
            background: rgba(239, 68, 68, 0.15) !important;
            border-color: rgba(239, 68, 68, 0.28) !important;
            color: #fb7185 !important;
        }

        html.aps-dark .action-btn[title*="Delete"]:hover,
        html.aps-dark .action-btn[title*="Hapus"]:hover,
        html.aps-dark .action-btn[title*="Blacklist"]:hover,
        html.aps-dark .action-btn.action-delete:hover,
        html.aps-dark .table .action-btn.bg-danger:hover {
            background: #ef4444 !important;
            color: #ffffff !important;
        }

        html.aps-dark .badge.bg-primary,
        html.aps-dark .bg-label-primary,
        html.aps-dark .table .badge.bg-primary,
        html.aps-dark .table .bg-primary {
            background-color: rgba(47, 128, 237, 0.18) !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .badge.bg-success,
        html.aps-dark .bg-label-success,
        html.aps-dark .table .badge.bg-success,
        html.aps-dark .table .bg-success {
            background-color: rgba(16, 185, 129, 0.16) !important;
            color: #6ee7b7 !important;
        }

        html.aps-dark .badge.bg-warning,
        html.aps-dark .bg-label-warning,
        html.aps-dark .table .badge.bg-warning,
        html.aps-dark .table .bg-warning {
            background-color: rgba(245, 158, 11, 0.16) !important;
            color: #fbbf24 !important;
        }

        html.aps-dark .badge.bg-danger,
        html.aps-dark .bg-label-danger,
        html.aps-dark .table .badge.bg-danger,
        html.aps-dark .table .bg-danger {
            background-color: rgba(239, 68, 68, 0.16) !important;
            color: #fb7185 !important;
        }

        html.aps-dark .badge.bg-info,
        html.aps-dark .bg-label-info,
        html.aps-dark .table .badge.bg-info,
        html.aps-dark .table .bg-info {
            background-color: rgba(56, 189, 248, 0.16) !important;
            color: #7dd3fc !important;
        }

        html.aps-dark .badge.bg-secondary,
        html.aps-dark .badge.bg-dark,
        html.aps-dark .bg-label-dark,
        html.aps-dark .table .badge.bg-secondary,
        html.aps-dark .table .badge.bg-dark {
            background-color: rgba(148, 163, 184, 0.16) !important;
            color: #cbd5e1 !important;
        }

        html.aps-dark .status-approved { background-color: rgba(16, 185, 129, 0.16) !important; color: #6ee7b7 !important; }
        html.aps-dark .status-rejected { background-color: rgba(239, 68, 68, 0.16) !important; color: #fb7185 !important; }
        html.aps-dark .status-pending { background-color: rgba(245, 158, 11, 0.16) !important; color: #fbbf24 !important; }
        html.aps-dark .status-canceled { background-color: rgba(148, 163, 184, 0.16) !important; color: #cbd5e1 !important; }

        html.aps-dark .nav-tabs {
            border-color: #24324a !important;
        }

        html.aps-dark .nav-tabs .nav-link {
            color: #8fa1b8 !important;
        }

        html.aps-dark .nav-tabs .nav-link:hover {
            color: #dbeafe !important;
            border-bottom-color: rgba(47, 128, 237, 0.45) !important;
        }

        html.aps-dark .nav-tabs .nav-link.active {
            color: #8fc2ff !important;
            border-bottom-color: #2f80ed !important;
            background: transparent !important;
        }

        html.aps-dark .dropdown-menu {
            background: #111c31 !important;
            border-color: #24324a !important;
            box-shadow: 0 24px 56px rgba(0, 0, 0, 0.35) !important;
        }

        html.aps-dark .dropdown-item {
            color: #dbe7f6 !important;
        }

        html.aps-dark .dropdown-item:hover,
        html.aps-dark .dropdown-item:focus {
            background: #172942 !important;
            color: #ffffff !important;
        }

        html.aps-dark .list-group-item,
        html.aps-dark .empty-state,
        html.aps-dark .alert {
            background: #111c31 !important;
            border-color: #24324a !important;
            color: #dbe7f6 !important;
        }

        html.aps-dark .swal2-title {
            color: #eaf1fb !important;
        }

        html.aps-dark .swal2-html-container,
        html.aps-dark .swal2-content {
            color: #aebcd0 !important;
        }

        html.aps-dark .apexcharts-canvas,
        html.aps-dark .apexcharts-svg,
        html.aps-dark .apexcharts-inner,
        html.aps-dark .apexcharts-graphical {
            background: transparent !important;
        }

        html.aps-dark .apexcharts-text,
        html.aps-dark .apexcharts-legend-text,
        html.aps-dark .apexcharts-title-text,
        html.aps-dark .apexcharts-subtitle-text {
            fill: #aebcd0 !important;
            color: #aebcd0 !important;
        }

        html.aps-dark .apexcharts-gridline,
        html.aps-dark .apexcharts-xaxis-tick,
        html.aps-dark .apexcharts-xaxis line,
        html.aps-dark .apexcharts-yaxis line {
            stroke: #24324a !important;
        }

        html.aps-dark .apexcharts-tooltip,
        html.aps-dark .apexcharts-tooltip-title {
            background: #101a2c !important;
            border-color: #2a3a55 !important;
            color: #eaf1fb !important;
        }

        html.aps-dark .navbar-nav .dropdown-menu.profile-dropdown-card,
        html.aps-dark .profile-dropdown-card {
            background: #111c31 !important;
            border-color: #263653 !important;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.38) !important;
        }

        html.aps-dark .profile-dropdown-header {
            background:
                radial-gradient(circle at 100% 0%, rgba(47, 128, 237, 0.16), transparent 34%),
                linear-gradient(135deg, #0f1a2d 0%, #132039 100%) !important;
            border: 1px solid #253650 !important;
        }

        html.aps-dark .profile-dropdown-avatar {
            background: #17233a !important;
            box-shadow: 0 16px 34px rgba(0, 0, 0, 0.22) !important;
        }

        html.aps-dark .profile-dropdown-status {
            border-color: #111c31 !important;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.16) !important;
        }

        html.aps-dark .profile-dropdown-name,
        html.aps-dark .navbar-nav .dropdown-item .fw-semibold {
            color: #edf5ff !important;
        }

        html.aps-dark .profile-dropdown-meta,
        html.aps-dark .navbar-nav .dropdown-item .text-muted {
            color: #9fb0c8 !important;
        }

        html.aps-dark .profile-role-badge {
            background: rgba(47, 128, 237, 0.16) !important;
            color: #8fc2ff !important;
            border: 1px solid rgba(47, 128, 237, 0.24) !important;
        }

        html.aps-dark .navbar-nav .dropdown-item {
            color: #dbe7f6 !important;
        }

        html.aps-dark .navbar-nav .dropdown-item:hover {
            background: #172942 !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .navbar-nav .dropdown-item i {
            background: rgba(47, 128, 237, 0.16) !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .navbar-nav .dropdown-item.profile-logout-item {
            color: #fb7185 !important;
        }

        html.aps-dark .navbar-nav .dropdown-item.profile-logout-item i {
            background: rgba(239, 68, 68, 0.14) !important;
            color: #fb7185 !important;
        }

        html.aps-dark .navbar-nav .dropdown-item.profile-logout-item:hover {
            background: rgba(239, 68, 68, 0.12) !important;
            color: #fecdd3 !important;
        }

        html.aps-dark .form-card,
        html.aps-dark .calendar-container,
        html.aps-dark .month-navigation,
        html.aps-dark .filter-card,
        html.aps-dark .page-card,
        html.aps-dark .section-card,
        html.aps-dark .data-card,
        html.aps-dark .detail-card,
        html.aps-dark .station-form-card,
        html.aps-dark .bg-light {
            background: #111c31 !important;
            background-color: #111c31 !important;
            border-color: #263653 !important;
            color: #dbe7f6 !important;
            box-shadow: 0 18px 48px rgba(0, 0, 0, 0.22) !important;
        }

        html.aps-dark .form-body,
        html.aps-dark .calendar-body,
        html.aps-dark .station-form-card .card-body {
            background: transparent !important;
            color: #dbe7f6 !important;
        }

        html.aps-dark .stat-card:not(.stat-card-primary):not(.stat-card-success):not(.stat-card-info) {
            background: #111c31 !important;
            border-color: #263653 !important;
            color: #dbe7f6 !important;
            box-shadow: 0 18px 48px rgba(0, 0, 0, 0.22) !important;
        }

        html.aps-dark .stat-number,
        html.aps-dark .month-title,
        html.aps-dark .date-number,
        html.aps-dark .card-text,
        html.aps-dark .form-card h1,
        html.aps-dark .form-card h2,
        html.aps-dark .form-card h3,
        html.aps-dark .form-card h4,
        html.aps-dark .form-card h5,
        html.aps-dark .form-card h6 {
            color: #edf5ff !important;
        }

        html.aps-dark .stat-label,
        html.aps-dark .form-hint,
        html.aps-dark .no-schedule,
        html.aps-dark .shift-time {
            color: #9fb0c8 !important;
        }

        html.aps-dark .day-name,
        html.aps-dark .calendar-day,
        html.aps-dark .calendar-day.inactive,
        html.aps-dark .station-map-preview,
        html.aps-dark .station-map-chip,
        html.aps-dark .time-badge,
        html.aps-dark .manpower-badge,
        html.aps-dark .date-badge,
        html.aps-dark .duration-badge,
        html.aps-dark .filter-select,
        html.aps-dark .nav-btn {
            background: #0f1a2d !important;
            background-color: #0f1a2d !important;
            border-color: #253650 !important;
            color: #dbe7f6 !important;
        }

        html.aps-dark .calendar-day:hover,
        html.aps-dark .nav-btn:hover {
            background: #172942 !important;
            border-color: rgba(47, 128, 237, 0.42) !important;
        }

        html.aps-dark .calendar-day.has-schedule,
        html.aps-dark .today {
            background: rgba(47, 128, 237, 0.14) !important;
            border-color: rgba(47, 128, 237, 0.32) !important;
        }

        html.aps-dark .shift-id {
            background: rgba(16, 185, 129, 0.16) !important;
            color: #6ee7b7 !important;
        }

        html.aps-dark .station-form-card .input-group-text,
        html.aps-dark .station-map-empty i {
            background: rgba(47, 128, 237, 0.16) !important;
            border-color: rgba(47, 128, 237, 0.24) !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .station-map-empty,
        html.aps-dark .form-text,
        html.aps-dark .help-block,
        html.aps-dark small {
            color: #9fb0c8 !important;
        }

        html.aps-dark .border,
        html.aps-dark .border-top,
        html.aps-dark .border-end,
        html.aps-dark .border-bottom,
        html.aps-dark .border-start {
            border-color: #263653 !important;
        }

        html.aps-dark .content-wrapper [style*="background:#fff"],
        html.aps-dark .content-wrapper [style*="background: #fff"],
        html.aps-dark .content-wrapper [style*="background:#ffffff"],
        html.aps-dark .content-wrapper [style*="background: #ffffff"],
        html.aps-dark .content-wrapper [style*="background-color:#fff"],
        html.aps-dark .content-wrapper [style*="background-color: #fff"],
        html.aps-dark .content-wrapper [style*="background-color:#ffffff"],
        html.aps-dark .content-wrapper [style*="background-color: #ffffff"] {
            background: #111c31 !important;
            background-color: #111c31 !important;
            border-color: #263653 !important;
            color: #dbe7f6 !important;
        }

        html.aps-dark .profile-page-header,
        html.aps-dark .profile-page .profile-card,
        html.aps-dark .profile-updated,
        html.aps-dark .profile-page .profile-card .nav-tabs,
        html.aps-dark .attendance-card,
        html.aps-dark .attendance-header,
        html.aps-dark .attendance-info-container,
        html.aps-dark .info-section {
            background: #111c31 !important;
            background-color: #111c31 !important;
            border-color: #263653 !important;
            color: #dbe7f6 !important;
            box-shadow: 0 18px 48px rgba(0, 0, 0, 0.22) !important;
        }

        html.aps-dark .profile-page .profile-card .nav-link,
        html.aps-dark .profile-page .profile-page-title .text-muted {
            color: #9fb0c8 !important;
        }

        html.aps-dark .profile-page .profile-card .nav-link {
            background: transparent !important;
            border-color: transparent !important;
        }

        html.aps-dark .profile-page-title,
        html.aps-dark .profile-summary-name,
        html.aps-dark .profile-page .profile-card .nav-link.active,
        html.aps-dark .tile-value,
        html.aps-dark .attendance-card h1,
        html.aps-dark .attendance-card h2,
        html.aps-dark .attendance-card h3,
        html.aps-dark .attendance-card h4,
        html.aps-dark .attendance-card h5,
        html.aps-dark .attendance-card h6,
        html.aps-dark .info-section h1,
        html.aps-dark .info-section h2,
        html.aps-dark .info-section h3,
        html.aps-dark .info-section h4,
        html.aps-dark .info-section h5,
        html.aps-dark .info-section h6 {
            color: #edf5ff !important;
        }

        html.aps-dark .profile-page-badges .bg-label-secondary,
        html.aps-dark .profile-meta-badges .bg-label-info {
            background: rgba(148, 163, 184, 0.16) !important;
            color: #cbd5e1 !important;
        }

        html.aps-dark .profile-page .profile-card .nav-link.active,
        html.aps-dark .profile-page .info-tile,
        html.aps-dark .profile-page .profile-info-item,
        html.aps-dark .attendance-info-container {
            background: #0f1a2d !important;
            border-color: #253650 !important;
        }

        html.aps-dark .profile-page .info-tile:hover,
        html.aps-dark .profile-page .profile-info-item:hover {
            background: #172942 !important;
            border-color: rgba(47, 128, 237, 0.42) !important;
            box-shadow: 0 16px 34px rgba(47, 128, 237, 0.1) !important;
        }

        html.aps-dark .profile-page .info-icon-wrapper,
        html.aps-dark .profile-page .tile-icon-wrapper,
        html.aps-dark .attendance-header .bg-label-primary {
            background: rgba(47, 128, 237, 0.16) !important;
            color: #8fc2ff !important;
            border-color: rgba(47, 128, 237, 0.24) !important;
        }

        html.aps-dark .profile-photo-container {
            border-color: #17233a !important;
            box-shadow: 0 18px 34px rgba(0, 0, 0, 0.25) !important;
        }

        html.aps-dark .attendance-info-container .info-label,
        html.aps-dark .attendance-card .text-muted,
        html.aps-dark .info-section .text-muted {
            color: #9fb0c8 !important;
        }

        html.aps-dark .attendance-info-container .info-value {
            color: #edf5ff !important;
        }

        html.aps-dark .note,
        html.aps-dark .alert-warning {
            background: rgba(245, 158, 11, 0.12) !important;
            border-color: rgba(245, 158, 11, 0.28) !important;
            color: #fcd38a !important;
        }

        html.aps-dark .select2-container--default .select2-selection--single,
        html.aps-dark .select2-container--default .select2-selection--multiple,
        html.aps-dark .select2-container .select2-selection,
        html.aps-dark .select2-container--bootstrap-5 .select2-selection,
        html.aps-dark .select2-container--bootstrap-5 .select2-selection--single,
        html.aps-dark .select2-container--bootstrap-5 .select2-selection--multiple,
        html.aps-dark .select2-dropdown,
        html.aps-dark .select2-search__field {
            background: #101a2c !important;
            background-color: #101a2c !important;
            border-color: #2a3a55 !important;
            color: #e6edf7 !important;
        }

        html.aps-dark .select2-container--default .select2-selection--single .select2-selection__rendered,
        html.aps-dark .select2-container--default .select2-selection--multiple .select2-selection__choice,
        html.aps-dark .select2-container--default .select2-selection__placeholder,
        html.aps-dark .select2-container .select2-selection__rendered,
        html.aps-dark .select2-container .select2-selection__placeholder,
        html.aps-dark .select2-container--bootstrap-5 .select2-selection__rendered,
        html.aps-dark .select2-container--bootstrap-5 .select2-selection__placeholder {
            color: #dbe7f6 !important;
        }

        html.aps-dark .select2-container--default .select2-selection--single .select2-selection__clear,
        html.aps-dark .select2-container--default .select2-selection--single .select2-selection__arrow b,
        html.aps-dark .select2-container .select2-selection__clear,
        html.aps-dark .select2-container .select2-selection__arrow,
        html.aps-dark .select2-container .select2-selection__arrow b,
        html.aps-dark .select2-container--bootstrap-5 .select2-selection__clear,
        html.aps-dark .select2-container--bootstrap-5 .select2-selection__arrow,
        html.aps-dark .select2-container--bootstrap-5 .select2-selection__arrow b {
            border-color: #9fb0c8 transparent transparent transparent !important;
            color: #9fb0c8 !important;
        }

        html.aps-dark .select2-container--default .select2-results__option {
            background: #111c31 !important;
            color: #dbe7f6 !important;
        }

        html.aps-dark .select2-container--default .select2-results__option--highlighted[aria-selected],
        html.aps-dark .select2-container--default .select2-results__option--selected {
            background: #172942 !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .accordion,
        html.aps-dark .accordion-item,
        html.aps-dark .accordion-header,
        html.aps-dark .accordion-body {
            background: #111c31 !important;
            border-color: #263653 !important;
            color: #dbe7f6 !important;
        }

        html.aps-dark .accordion-button,
        html.aps-dark .accordion-button.collapsed {
            background: #111c31 !important;
            background-color: #111c31 !important;
            border-color: #263653 !important;
            color: #dbe7f6 !important;
            box-shadow: none !important;
        }

        html.aps-dark .accordion-button:not(.collapsed),
        html.aps-dark .accordion-button:hover {
            background: #172942 !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .accordion-button::after {
            filter: invert(1) grayscale(1);
            opacity: 0.8;
        }

        html.aps-dark .aps-menu-search-icon,
        html.aps-dark .aps-menu-search-close {
            background: #17233a !important;
            background-color: #17233a !important;
            border-color: #2a3a55 !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .aps-menu-search-close:hover {
            background: #1d2b45 !important;
            color: #ffffff !important;
        }

        /* Refined command palette */
        .aps-menu-search {
            padding: clamp(0.75rem, 5vh, 3rem) clamp(0.75rem, 3vw, 2rem) 1rem !important;
            background: rgba(15, 23, 42, 0.34) !important;
            backdrop-filter: blur(12px) saturate(1.08) !important;
            -webkit-backdrop-filter: blur(12px) saturate(1.08) !important;
        }

        .aps-menu-search-panel {
            width: min(920px, calc(100vw - 2rem)) !important;
            max-height: min(760px, calc(100vh - 2rem)) !important;
            border-radius: 26px !important;
            background: #ffffff !important;
            border-color: rgba(226, 232, 240, 0.96) !important;
            box-shadow: 0 34px 90px rgba(15, 23, 42, 0.24) !important;
        }

        .aps-menu-search-head {
            padding: 0.85rem 0.95rem !important;
            gap: 0.8rem !important;
            background: #fbfdff !important;
            border-bottom-color: #e8eef6 !important;
        }

        .aps-menu-search-icon,
        .aps-menu-search-close {
            width: 42px !important;
            min-width: 42px !important;
            height: 42px !important;
            border: 1px solid #e5edf8 !important;
            box-shadow: 0 10px 20px rgba(47, 128, 237, 0.08) !important;
        }

        .aps-menu-search-close {
            transition: background-color 0.16s ease, color 0.16s ease, transform 0.16s ease !important;
        }

        .aps-menu-search-close:hover {
            background: #eaf4ff !important;
            color: #2f80ed !important;
            transform: scale(1.03);
        }

        .aps-menu-search-input {
            font-size: 0.98rem !important;
            color: #233044 !important;
            letter-spacing: 0 !important;
        }

        .aps-menu-search-input::placeholder {
            color: #8a9ab2 !important;
        }

        .aps-menu-search-body {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.82rem;
            padding: 0.95rem !important;
            background: #ffffff !important;
            overscroll-behavior: contain;
        }

        .aps-menu-search-group {
            min-width: 0;
            margin: 0 !important;
            padding: 0.36rem !important;
            border: 1px solid #edf2f8;
            border-radius: 18px;
            background: #fbfdff;
        }

        .aps-menu-search-group-title {
            padding: 0.42rem 0.5rem 0.48rem !important;
            color: #8392a8 !important;
            font-size: 0.68rem !important;
            letter-spacing: 0.04em !important;
        }

        .aps-menu-search-item {
            min-height: 62px;
            padding: 0.58rem 0.6rem !important;
            gap: 0.74rem !important;
            border: 1px solid transparent;
            border-radius: 14px !important;
            color: #253247 !important;
            background: transparent;
            transform: none !important;
            transition: background-color 0.16s ease, border-color 0.16s ease, box-shadow 0.16s ease, color 0.16s ease !important;
        }

        .aps-menu-search-item:hover,
        .aps-menu-search-item:focus {
            background: #f1f7ff !important;
            border-color: rgba(47, 128, 237, 0.16);
            box-shadow: 0 12px 24px rgba(47, 128, 237, 0.10);
            color: #2368c8 !important;
            outline: none;
        }

        .aps-menu-search-item .aps-menu-search-item-icon {
            width: 40px !important;
            min-width: 40px !important;
            height: 40px !important;
            background: #eaf4ff !important;
            color: #2f80ed !important;
            box-shadow: inset 0 0 0 1px rgba(47, 128, 237, 0.06);
        }

        .aps-menu-search-copy {
            display: block !important;
            min-width: 0;
            flex: 1 1 auto;
            color: inherit !important;
        }

        .aps-menu-search-copy strong {
            display: block;
            color: #243044 !important;
            font-size: 0.88rem !important;
            font-weight: 700 !important;
            line-height: 1.2 !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .aps-menu-search-copy span {
            display: block;
            margin-top: 0.16rem !important;
            color: #7c8ca4 !important;
            font-size: 0.73rem !important;
            font-weight: 550 !important;
            line-height: 1.25 !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .aps-menu-search-item:hover .aps-menu-search-copy strong,
        .aps-menu-search-item:focus .aps-menu-search-copy strong {
            color: #2368c8 !important;
        }

        .aps-menu-search-item:hover .aps-menu-search-copy span,
        .aps-menu-search-item:focus .aps-menu-search-copy span {
            color: #5f7fa9 !important;
        }

        .aps-menu-search-arrow {
            width: 28px;
            min-width: 28px;
            height: 28px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            color: #9aa8bb;
            background: transparent;
            opacity: 0;
            transform: translateX(-3px);
            transition: opacity 0.16s ease, transform 0.16s ease, background-color 0.16s ease, color 0.16s ease;
        }

        .aps-menu-search-item:hover .aps-menu-search-arrow,
        .aps-menu-search-item:focus .aps-menu-search-arrow {
            opacity: 1;
            transform: translateX(0);
            color: #2f80ed;
            background: #ffffff;
        }

        .aps-menu-search-foot {
            padding: 0.7rem 1rem !important;
            background: #fbfdff !important;
            border-top-color: #e8eef6 !important;
        }

        .aps-menu-search-empty {
            grid-column: 1 / -1;
            min-height: 220px;
            display: none;
            align-items: center;
            justify-content: center;
            border: 1px dashed #dbe7f4;
            border-radius: 18px;
            background: #fbfdff;
        }

        .aps-menu-search-empty.is-visible {
            display: flex !important;
        }

        html.aps-dark .aps-menu-search-panel,
        html.aps-dark .aps-menu-search-head,
        html.aps-dark .aps-menu-search-foot {
            background: #111c31 !important;
            border-color: #24324a !important;
        }

        html.aps-dark .aps-menu-search-body {
            background: #111c31 !important;
        }

        html.aps-dark .aps-menu-search-group {
            background: #121f34 !important;
            border-color: #263653 !important;
        }

        html.aps-dark .aps-menu-search-item {
            color: #dbe7f6 !important;
        }

        html.aps-dark .aps-menu-search-item:hover,
        html.aps-dark .aps-menu-search-item:focus {
            background: #172942 !important;
            border-color: rgba(143, 194, 255, 0.22) !important;
            box-shadow: none !important;
            color: #8fc2ff !important;
        }

        html.aps-dark .aps-menu-search-copy strong {
            color: #eaf1fb !important;
        }

        html.aps-dark .aps-menu-search-copy span {
            color: #9fb1c7 !important;
        }

        html.aps-dark .aps-menu-search-item:hover .aps-menu-search-copy strong,
        html.aps-dark .aps-menu-search-item:focus .aps-menu-search-copy strong {
            color: #8fc2ff !important;
        }

        html.aps-dark .aps-menu-search-arrow {
            color: #7e91aa;
        }

        html.aps-dark .aps-menu-search-item:hover .aps-menu-search-arrow,
        html.aps-dark .aps-menu-search-item:focus .aps-menu-search-arrow {
            background: #22304a;
            color: #8fc2ff;
        }

        html.aps-dark .aps-menu-search-empty {
            background: #121f34;
            border-color: #263653;
        }

        @media (max-width: 991.98px) {
            .aps-menu-search {
                padding: 1rem !important;
            }

            .aps-menu-search-panel {
                width: min(620px, calc(100vw - 2rem)) !important;
                max-height: min(680px, calc(100vh - 2rem)) !important;
            }

            .aps-menu-search-body {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 575.98px) {
            .aps-menu-search {
                align-items: flex-start !important;
                padding: 0.85rem 0.72rem !important;
            }

            .aps-menu-search-panel {
                width: min(100%, calc(100vw - 1.44rem)) !important;
                max-height: calc(100vh - 1.7rem) !important;
                min-height: 0 !important;
                border: 1px solid rgba(226, 232, 240, 0.96) !important;
                border-radius: 22px !important;
            }

            .aps-menu-search-head {
                padding: 0.78rem 0.8rem !important;
            }

            .aps-menu-search-icon,
            .aps-menu-search-close {
                width: 38px !important;
                min-width: 38px !important;
                height: 38px !important;
            }

            .aps-menu-search-input {
                font-size: 0.9rem !important;
            }

            .aps-menu-search-body {
                display: block !important;
                padding: 0.72rem !important;
            }

            .aps-menu-search-group {
                margin-bottom: 0.72rem !important;
                padding: 0.3rem !important;
                border-radius: 16px;
            }

            .aps-menu-search-item {
                min-height: 58px;
                padding: 0.54rem !important;
            }

            .aps-menu-search-copy strong,
            .aps-menu-search-copy span {
                white-space: normal;
            }

            .aps-menu-search-arrow {
                display: none !important;
            }

            .aps-menu-search-foot {
                display: none !important;
            }
        }

        /* Mid-width topbar guard: keep profile as a clean circle when space is tight */
        @media (max-width: 1440px) {
            #layout-navbar .aps-topbar {
                grid-template-columns: auto minmax(120px, 170px) minmax(210px, 1fr) auto !important;
                gap: 0.62rem !important;
            }

            #layout-navbar .dropdown-user .topbar-user-chip.nav-link {
                width: 42px !important;
                min-width: 42px !important;
                max-width: 42px !important;
                height: 42px !important;
                padding: 0 !important;
                justify-content: center !important;
                overflow: hidden !important;
                flex: 0 0 42px !important;
            }

            #layout-navbar .dropdown-user .topbar-user-chip.nav-link .topbar-user-text {
                display: none !important;
            }

            #layout-navbar .dropdown-user .topbar-user-mini-avatar {
                width: 34px !important;
                min-width: 34px !important;
                height: 34px !important;
            }
        }

        @media (max-width: 1040px) {
            #layout-navbar .topbar-date {
                display: none !important;
            }

            #layout-navbar .aps-topbar {
                grid-template-columns: auto minmax(160px, 1fr) auto !important;
            }
        }

        @media (max-width: 575.98px) {
            #layout-navbar .aps-topbar {
                display: grid !important;
                grid-template-columns: 40px 1fr auto auto !important;
                gap: 0.36rem !important;
            }

            #layout-navbar .topbar-search-trigger {
                width: 100% !important;
                min-width: 0 !important;
                max-width: none !important;
                flex: 1 1 auto !important;
            }
        }

    </style>

    <!-- 4. State Management (Anti-Refresh/Flicker) -->
    <script>
        // Eksekusi LANGSUNG sebelum body dirender
        (function() {
            const theme = localStorage.getItem('apsTheme') || 'light';
            document.documentElement.classList.toggle('aps-dark', theme === 'dark');
            document.documentElement.setAttribute('data-aps-theme', theme);

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
                @php
                    $currentUser = Auth::user();
                    $canManageSchedule = in_array($currentUser->role, [
                        'Admin',
                        'Ass Leader Bge',
                        'Ass Leader Apron',
                        'Head Of Airport Service',
                        'SPV',
                        'Bge',
                        'Apron',
                    ]);
                    $canViewAdminAttendance = in_array($currentUser->role, ['Admin', 'CHIEF']);
                    $canApproveOvertime = in_array($currentUser->role, ['Admin', 'LEADER', 'CHIEF', 'ASS LEADER']);
                    $canManageTraining = in_array($currentUser->role, ['Admin', 'HSE', 'Head Of Airport Service']);
                    $canManageLeave = in_array($currentUser->role, ['Admin', 'Head Of Airport Service']);
                    $topbarMenuLinks = [
                        ['label' => 'Dashboard', 'category' => 'Menu', 'hint' => 'Overview operasional dan statistik', 'icon' => 'ti-layout-dashboard', 'url' => route('home')],
                        ['label' => 'Profile', 'category' => 'Menu', 'hint' => 'Data akun dan biodata staff', 'icon' => 'ti-user-circle', 'url' => route('users.profile', $currentUser->id)],
                        ['label' => 'Jadwal Hari Ini', 'category' => 'Schedule', 'hint' => 'Lihat jadwal aktif hari ini', 'icon' => 'ti-calendar-check', 'url' => route('schedule.now')],
                        ['label' => 'Data Schedule', 'category' => 'Schedule', 'hint' => 'Kalender dan data jadwal bulanan', 'icon' => 'ti-calendar', 'url' => route('schedule.index')],
                    ];

                    if ($canManageSchedule) {
                        $topbarMenuLinks[] = ['label' => 'Create / Update Schedule', 'category' => 'Schedule', 'hint' => 'Kelola pembuatan jadwal staff', 'icon' => 'ti-calendar-plus', 'url' => route('schedule.view')];
                    }

                    $topbarMenuLinks[] = ['label' => 'Shift', 'category' => 'Menu', 'hint' => 'Data shift kerja', 'icon' => 'ti-clock', 'url' => route('shift.index')];
                    $topbarMenuLinks[] = ['label' => 'Absensi Hari Ini', 'category' => 'Attendance', 'hint' => 'Monitoring absensi staff', 'icon' => 'ti-stopwatch', 'url' => route('attendance.index')];

                    if ($canViewAdminAttendance) {
                        $topbarMenuLinks[] = ['label' => 'Laporan Absensi', 'category' => 'Attendance', 'hint' => 'Rekap dan export absensi', 'icon' => 'ti-file-text', 'url' => route('attendance.reports')];
                    }

                    $topbarMenuLinks[] = ['label' => 'Lembur Saya', 'category' => 'Attendance', 'hint' => 'Pengajuan dan status lembur', 'icon' => 'ti-hourglass', 'url' => route('overtime.index')];

                    if ($canApproveOvertime) {
                        $topbarMenuLinks[] = ['label' => 'Approval Lembur', 'category' => 'Attendance', 'hint' => 'Validasi pengajuan lembur', 'icon' => 'ti-circle-check', 'url' => route('overtime.approval')];
                    }

                    if ($currentUser->role === 'Admin') {
                        $topbarMenuLinks[] = ['label' => 'Laporan Lembur', 'category' => 'Attendance', 'hint' => 'Rekap lembur operasional', 'icon' => 'ti-chart-line', 'url' => route('overtime.report')];
                        $topbarMenuLinks[] = ['label' => 'Manajemen Station', 'category' => 'Administrator', 'hint' => 'Kelola status dan koordinat station', 'icon' => 'ti-building-store', 'url' => route('stations.index')];
                        $topbarMenuLinks[] = ['label' => 'Monitor Station', 'category' => 'Administrator', 'hint' => 'Pantau staff tiap station', 'icon' => 'ti-device-desktop', 'url' => route('staff.index')];
                        $topbarMenuLinks[] = ['label' => 'Blacklist', 'category' => 'Administrator', 'hint' => 'Data staff blacklist', 'icon' => 'ti-user-x', 'url' => route('blacklist.index')];
                        $topbarMenuLinks[] = ['label' => 'Kontrak', 'category' => 'Administrator', 'hint' => 'Masa kontrak staff', 'icon' => 'ti-file-text', 'url' => route('users.kontrak')];
                        $topbarMenuLinks[] = ['label' => 'PAS Bandara', 'category' => 'Administrator', 'hint' => 'Masa aktif PAS bandara', 'icon' => 'ti-id', 'url' => route('users.pas')];
                        $topbarMenuLinks[] = ['label' => 'TIM Bandara', 'category' => 'Administrator', 'hint' => 'Data TIM bandara', 'icon' => 'ti-badge', 'url' => route('users.tim')];
                    }

                    $topbarMenuLinks[] = ['label' => 'Dokumen', 'category' => 'General', 'hint' => 'Dokumen dan surat', 'icon' => 'ti-file-text', 'url' => route('document')];

                    if ($canManageTraining) {
                        $topbarMenuLinks[] = ['label' => 'Manajemen Training', 'category' => 'Training', 'hint' => 'Kelola data sertifikat', 'icon' => 'ti-book', 'url' => route('admin.training.certificates.index')];
                        $topbarMenuLinks[] = ['label' => 'Tambah Sertifikat', 'category' => 'Training', 'hint' => 'Input sertifikat baru', 'icon' => 'ti-circle-plus', 'url' => route('admin.training.certificates.create')];
                    } else {
                        $topbarMenuLinks[] = ['label' => 'Sertifikat Saya', 'category' => 'Training', 'hint' => 'Lihat sertifikat pribadi', 'icon' => 'ti-certificate', 'url' => route('my.certificates')];
                    }

                    $topbarMenuLinks[] = ['label' => 'Pengajuan Leave', 'category' => 'Apply Leave', 'hint' => 'Ajukan izin atau cuti', 'icon' => 'ti-send', 'url' => route('leaves.pengajuan')];

                    if ($canManageLeave) {
                        $topbarMenuLinks[] = ['label' => 'Approval Leave', 'category' => 'Apply Leave', 'hint' => 'Review pengajuan leave', 'icon' => 'ti-circle-check', 'url' => route('leaves.index')];
                        $topbarMenuLinks[] = ['label' => 'Laporan Leave', 'category' => 'Apply Leave', 'hint' => 'Rekap leave staff', 'icon' => 'ti-file-text', 'url' => route('leaves.laporan')];
                    }

                    $topbarMenuLinks[] = ['label' => 'FAQ', 'category' => 'Support', 'hint' => 'Pertanyaan umum sistem', 'icon' => 'ti-help-circle', 'url' => route('faq')];
                    $topbarMenuLinks[] = ['label' => 'Kebijakan Privasi', 'category' => 'Support', 'hint' => 'Informasi privasi aplikasi', 'icon' => 'ti-shield-check', 'url' => route('kebijakan')];
                    $topbarMenuGroups = collect($topbarMenuLinks)->groupBy('category');
                @endphp
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="aps-topbar">
                        <div class="navbar-nav align-items-xl-center">
                            <a class="nav-item nav-link px-0" href="javascript:void(0)"
                                id="custom-sidebar-toggle" aria-label="Toggle sidebar" draggable="false">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </div>

                        <div class="topbar-date">
                            <span>Today</span>
                            <strong id="topbarToday">{{ now()->format('D, M d, Y') }}</strong>
                        </div>

                        <button class="topbar-search-trigger" type="button" id="topbarSearchTrigger"
                            aria-haspopup="dialog" aria-controls="apsMenuSearch">
                            <i class="ti ti-search"></i>
                            <span>Search menu ...</span>
                            <kbd>Ctrl K</kbd>
                        </button>

                        <div class="topbar-right">
                            <div class="topbar-theme-switch" id="apsThemeSwitch" role="group"
                                aria-label="Pilih tema tampilan">
                                <button class="topbar-theme-option" type="button" data-theme-option="light"
                                    aria-label="Light mode">
                                    <i class="ti ti-sun"></i>
                                    <span>Light</span>
                                </button>
                                <button class="topbar-theme-option" type="button" data-theme-option="dark"
                                    aria-label="Dark mode">
                                    <i class="ti ti-moon"></i>
                                    <span>Dark</span>
                                </button>
                            </div>
                            <ul class="navbar-nav flex-row align-items-center">
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="topbar-user-chip nav-link dropdown-toggle hide-arrow"
                                        href="javascript:void(0);" data-bs-toggle="dropdown" draggable="false">
                                        @if (!empty($currentUser->profile_picture))
                                            <img class="topbar-user-mini-avatar"
                                                src="{{ asset('storage/photo/' . $currentUser->profile_picture) }}"
                                                alt="Profile"
                                                onerror="this.onerror=null; this.src='{{ asset('storage/photo/user.jpg') }}';"
                                                draggable="false">
                                        @else
                                            <img class="topbar-user-mini-avatar"
                                                src="{{ asset('storage/photo/user.jpg') }}" alt="Profile"
                                                draggable="false">
                                        @endif
                                        <div class="topbar-user-text">
                                            <strong>{{ $currentUser->fullname }}</strong>
                                            <span>{{ $currentUser->id }} &mdash; {{ $currentUser->role }}@if (!empty($currentUser->station)) ({{ $currentUser->station }}) @endif</span>
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
                    </div>
                </nav>
                <div class="aps-menu-search" id="apsMenuSearch" role="dialog" aria-modal="true"
                    aria-labelledby="apsMenuSearchTitle">
                    <div class="aps-menu-search-panel">
                        <h2 class="visually-hidden" id="apsMenuSearchTitle">Pencarian Menu</h2>
                        <div class="aps-menu-search-head">
                            <span class="aps-menu-search-icon"><i class="ti ti-search"></i></span>
                            <input class="aps-menu-search-input" id="apsMenuSearchInput" type="search"
                                placeholder="Cari menu, fitur, atau halaman..." autocomplete="off">
                            <button class="aps-menu-search-close" type="button" id="apsMenuSearchClose"
                                aria-label="Tutup pencarian">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                        <div class="aps-menu-search-body">
                            <div class="aps-menu-search-empty" id="apsMenuSearchEmpty">
                                Menu tidak ditemukan. Coba kata kunci lain.
                            </div>
                            @foreach ($topbarMenuGroups as $category => $items)
                                <div class="aps-menu-search-group" data-search-group>
                                    <div class="aps-menu-search-group-title">{{ $category }}</div>
                                    @foreach ($items as $item)
                                        <a class="aps-menu-search-item" href="{{ $item['url'] }}"
                                            data-search-item
                                            data-keywords="{{ \Illuminate\Support\Str::lower($item['label'] . ' ' . $item['category'] . ' ' . $item['hint']) }}">
                                            <span class="aps-menu-search-item-icon">
                                                <i class="ti {{ $item['icon'] }}"></i>
                                            </span>
                                            <span class="aps-menu-search-copy">
                                                <strong>{{ $item['label'] }}</strong>
                                                <span>{{ $item['hint'] }}</span>
                                            </span>
                                            <span class="aps-menu-search-arrow" aria-hidden="true">
                                                <i class="ti ti-chevron-right"></i>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <div class="aps-menu-search-foot">
                            <span><kbd>Ctrl</kbd> + <kbd>K</kbd> buka pencarian</span>
                            <span><kbd>Esc</kbd> tutup</span>
                        </div>
                    </div>
                </div>
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

            const topbarDate = document.getElementById('topbarToday');
            if (topbarDate) {
                topbarDate.textContent = now.toLocaleDateString('en-US', {
                    weekday: 'short',
                    month: 'short',
                    day: '2-digit',
                    year: 'numeric'
                });
            }
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
    <script>
        (function() {
            function applyTheme(theme) {
                const nextTheme = theme === 'dark' ? 'dark' : 'light';
                document.documentElement.classList.toggle('aps-dark', nextTheme === 'dark');
                document.documentElement.setAttribute('data-aps-theme', nextTheme);
                localStorage.setItem('apsTheme', nextTheme);

                document.querySelectorAll('[data-theme-option]').forEach(function(button) {
                    const isActive = button.getAttribute('data-theme-option') === nextTheme;
                    button.classList.toggle('is-active', isActive);
                    button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                });

                window.dispatchEvent(new CustomEvent('aps:theme-changed', {
                    detail: {
                        theme: nextTheme
                    }
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const storedTheme = localStorage.getItem('apsTheme') || 'light';
                applyTheme(storedTheme);

                document.querySelectorAll('[data-theme-option]').forEach(function(button) {
                    button.addEventListener('click', function() {
                        applyTheme(button.getAttribute('data-theme-option'));
                    });
                });
            });
        })();
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
            const layoutMenu = document.getElementById('layout-menu');
            const htmlTag = document.documentElement;
            let sidebarPeekTimer = null;

            function isDesktopSidebar() {
                return window.innerWidth >= 1200;
            }

            function closeSidebarPeek() {
                window.clearTimeout(sidebarPeekTimer);
                sidebarPeekTimer = null;
                htmlTag.classList.remove('sidebar-peeking');
            }

            function scheduleSidebarPeek() {
                if (!isDesktopSidebar() || !htmlTag.classList.contains('sidebar-collapsed')) {
                    return;
                }

                window.clearTimeout(sidebarPeekTimer);
                sidebarPeekTimer = window.setTimeout(function() {
                    if (isDesktopSidebar() && htmlTag.classList.contains('sidebar-collapsed')) {
                        htmlTag.classList.add('sidebar-peeking');
                    }
                }, 130);
            }

            function toggleSidebar() {
                const isMobile = window.innerWidth < 1200;
                closeSidebarPeek();

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
            if (layoutMenu) {
                layoutMenu.addEventListener('pointerenter', scheduleSidebarPeek);
                layoutMenu.addEventListener('pointerleave', closeSidebarPeek);
                layoutMenu.addEventListener('mouseenter', scheduleSidebarPeek);
                layoutMenu.addEventListener('mouseleave', closeSidebarPeek);
                layoutMenu.addEventListener('focusin', scheduleSidebarPeek);
                layoutMenu.addEventListener('focusout', function(event) {
                    if (!layoutMenu.contains(event.relatedTarget)) {
                        closeSidebarPeek();
                    }
                });
            }

            document.querySelectorAll('#custom-sidebar-toggle, .dropdown-user .nav-link, .dropdown-user img')
                .forEach((element) => {
                    element.setAttribute('draggable', 'false');
                    element.addEventListener('dragstart', (event) => event.preventDefault());
                });

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
                closeSidebarPeek();

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
            function initTopbarSearch() {
                const trigger = document.getElementById('topbarSearchTrigger');
                const modal = document.getElementById('apsMenuSearch');
                const input = document.getElementById('apsMenuSearchInput');
                const closeBtn = document.getElementById('apsMenuSearchClose');
                const empty = document.getElementById('apsMenuSearchEmpty');
                if (!trigger || !modal || !input) return;

                const items = Array.from(modal.querySelectorAll('[data-search-item]'));
                const groups = Array.from(modal.querySelectorAll('[data-search-group]'));

                function filterItems() {
                    const query = input.value.trim().toLowerCase();
                    let visibleCount = 0;

                    items.forEach(function(item) {
                        const keywords = item.getAttribute('data-keywords') || '';
                        const isVisible = !query || keywords.includes(query);
                        item.style.display = isVisible ? '' : 'none';
                        if (isVisible) visibleCount += 1;
                    });

                    groups.forEach(function(group) {
                        const hasVisible = Array.from(group.querySelectorAll('[data-search-item]'))
                            .some(function(item) {
                                return item.style.display !== 'none';
                            });
                        group.style.display = hasVisible ? '' : 'none';
                    });

                    if (empty) empty.classList.toggle('is-visible', visibleCount === 0);
                }

                function openSearch() {
                    modal.classList.add('is-open');
                    document.documentElement.classList.add('aps-search-open');
                    input.value = '';
                    filterItems();
                    window.setTimeout(function() {
                        input.focus();
                    }, 40);
                }

                function closeSearch() {
                    modal.classList.remove('is-open');
                    document.documentElement.classList.remove('aps-search-open');
                }

                trigger.addEventListener('click', openSearch);
                if (closeBtn) closeBtn.addEventListener('click', closeSearch);
                input.addEventListener('input', filterItems);

                modal.addEventListener('click', function(event) {
                    if (event.target === modal) closeSearch();
                    if (event.target.closest('[data-search-item]')) closeSearch();
                });

                document.addEventListener('keydown', function(event) {
                    const key = event.key.toLowerCase();
                    if ((event.ctrlKey || event.metaKey) && key === 'k') {
                        event.preventDefault();
                        openSearch();
                    }

                    if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                        event.preventDefault();
                        closeSearch();
                    }
                });

                window.apsCloseMenuSearch = closeSearch;
            }

            document.addEventListener('DOMContentLoaded', initTopbarSearch);
        })();
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
                const link = event.target.closest('#layout-menu a.menu-link, .aps-menu-search-item');
                if (!shouldHandleLink(event, link)) return;
                event.preventDefault();
                // Auto-close sidebar on mobile when menu link clicked
                if (window.innerWidth < 1200) {
                    document.documentElement.classList.remove('sidebar-mobile-open');
                }
                if (typeof window.apsCloseMenuSearch === 'function') {
                    window.apsCloseMenuSearch();
                }
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
