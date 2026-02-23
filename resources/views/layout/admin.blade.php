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

    <link rel="stylesheet"
        href="{{ asset('template/') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/libs/apex-charts/apex-charts.css" />

    <script src="{{ asset('template/') }}/assets/vendor/js/helpers.js"></script>
    <script src="{{ asset('template/') }}/assets/js/config.js"></script>

    @yield('styles')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('home') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('storage/aps.jpeg') }}" alt="Logo" width="120">
                        </span>
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
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
                            <li class="menu-item">
                                <a href="{{ route('schedule.now') }}" class="menu-link">
                                    <div data-i18n="Jadwal Hari Ini">Jadwal Hari Ini</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('schedule.index') }}" class="menu-link">
                                    <div data-i18n="Data Schedule">Data Schedule</div>
                                </a>
                            </li>
                            @if (in_array(Auth::user()->role, ['Admin', 'Ass Leader Bge', 'Ass Leader Apron', 'Head Of Airport Service', 'SPV', 'Bge', 'Apron']))
                            <li class="menu-item">
                                <a href="{{ route('schedule.index') }}" class="menu-link">
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


                    <li class="menu-item {{ request()->is('attendance*') || request()->is('overtime*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons fas fa-clipboard-check"></i>
                            <div data-i18n="Attendance & Lembur">Attendance</div>
                        </a>

                        <ul class="menu-sub">


                            <li class="menu-item {{ request()->routeIs('attendance.index') ? 'active' : '' }}">
                                <a href="{{ route('attendance.index') }}" class="menu-link">
                                    <div data-i18n="Absensi Hari Ini">Absensi Hari Ini</div>
                                </a>
                            </li>

                            @if (in_array(Auth::user()->role, ['Admin', 'CHIEF']))
                            <li class="menu-item {{ request()->routeIs('attendance.reports') ? 'active' : '' }}">
                                <a href="{{ route('attendance.reports') }}" class="menu-link">
                                    <div data-i18n="Laporan Absensi">Laporan Absensi</div>
                                </a>
                            </li>
                            @endif


                            <li class="menu-item {{ request()->routeIs('overtime.index') || request()->routeIs('overtime.create') ? 'active' : '' }}">
                                <a href="{{ route('overtime.index') }}" class="menu-link">
                                    <div data-i18n="Lembur Saya">Lembur Saya</div>
                                </a>
                            </li>


                            @if(in_array(Auth::user()->role, ['Admin', 'LEADER', 'CHIEF', 'ASS LEADER']))
                            <li class="menu-item {{ request()->routeIs('overtime.approval') ? 'active' : '' }}">
                                <a href="{{ route('overtime.approval') }}" class="menu-link">
                                    <div data-i18n="Approval Lembur">Approval Lembur</div>
                                </a>
                            </li>
                            @endif

                            @if(Auth::user()->role == 'Admin')
                            <li class="menu-item {{ request()->routeIs('overtime.report') ? 'active' : '' }}">
                                <a href="{{ route('overtime.report') }}" class="menu-link">
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

                    <li class="menu-item {{ request()->is('users*') || request()->is('staff*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons fas fa-users"></i>
                            <div data-i18n="User Management">User</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('staff.index') }}" class="menu-link" style="color: #f1c40f !important; font-weight: bold;">
                                    <i class="fas fa-map-marked-alt me-2"></i>
                                    <div data-i18n="Monitor Station">Monitor Station</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('blacklist.index') }}" class="menu-link" style="color: #000000ff !important; font-weight: bold;">
                                    <i class="fas fa-address-book"></i>
                                    <div data-i18n="Blacklist"> Blacklist</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('users.kontrak') }}" class="menu-link">
                                    <div data-i18n="Kontrak">Kontrak</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('users.pas') }}" class="menu-link">
                                    <div data-i18n="PAS Tahunan">PAS Bandara</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('users.tim') ? 'active' : '' }}">
                                <a href="{{ route('users.tim') }}" class="menu-link">
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
                            <li class="menu-item">
                                <a href="{{ route('training.index') }}" class="menu-link">
                                    <div data-i18n="Manajemen">Manajemen Training</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('training.create') }}" class="menu-link">
                                    <div data-i18n="Tambah">Tambah Sertifikat</div>
                                </a>
                            </li>
                            @else
                            <li class="menu-item">
                                <a href="{{ route('my.certificates') }}" class="menu-link">
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
                            <li class="menu-item">
                                <a href="{{ route('leaves.pengajuan') }}" class="menu-link">
                                    <div data-i18n="Pengajuan">Pengajuan Leave</div>
                                </a>
                            </li>
                            @if (in_array(Auth::user()->role, ['Leader', 'Ass Leader', 'Admin', 'SPV']))
                            <li class="menu-item">
                                <a href="{{ route('leaves.index') }}" class="menu-link">
                                    <div data-i18n="Approval">Approval Leave</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('leaves.laporan') }}" class="menu-link">
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
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
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
                                        <a class="dropdown-item" href="{{ route('users.profile', Auth::user()->id) }}">
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
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                © <script>
                                    document.write(new Date().getFullYear());
                                </script>, made with ❤️
                            </div>
                        </div>
                    </footer>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
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
</body>

</html>
