<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('template/') }}/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>PT. Angkasa Pratama Sejahtera</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/fonts/boxicons.css" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('template/') }}/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="{{ asset('template/') }}/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->
    
    <!-- Helpers -->
    <script src="{{ asset('template/') }}/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('template/') }}/assets/js/config.js"></script>

    @yield('styles')
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="{{ route('home') }}" class="app-brand-link">
              <span class="app-brand-logo demo">
              <img src="{{ asset('storage/aps.jpeg') }}" alt="Logo" width="75">
              </span>
              <!-- <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span> -->
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
             <!-- active -->
            <li class="menu-item">
              <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Home</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="{{ route('users.profile', Auth::user()->id) }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Analytics">Profile</div>
              </a>
            </li>

            <!-- Schedule Menu -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Schedule">Schedule</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('schedule.now') }}" class="menu-link">
                    <div data-i18n="Today">Jadwal Schedule Hari Ini</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{ route('schedule.index') }}" class="menu-link">
                    <div data-i18n="Data">Data Schedule</div>
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
<li class="menu-item">
                  {{-- <a href="{{ route('schedule.show') }}" class="menu-link">
                    <div data-i18n="Create">Create / Update Schedule</div>
                  </a> --}}
                </li>
@endif
              </ul>
            </li>

            <!-- Shift -->
            <li class="menu-item">
              <a href="{{ route('shift.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-time"></i>
                <div data-i18n="Shift">Shift</div>
              </a>
            </li>

            <!-- Attendance Menu -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-clipboard"></i>
                <div data-i18n="Attendance">Attendance</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('attendance.index') }}" class="menu-link">
                    <div data-i18n="Today">Absensi Hari Ini</div>
                  </a>
                </li>
                @if (in_array(Auth::user()->role, ['Admin', 'CHIEF']))
<li class="menu-item">
                  <a href="{{ route('attendance.reports') }}" class="menu-link">
                    <div data-i18n="Reports">Laporan Absensi</div>
                  </a>
                </li>
@endif
              </ul>
            </li>

            @if (in_array(Auth::user()->role, ['Admin']))
<!-- User Management Menu -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="User Management">User Management</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('users.kontrak') }}" class="menu-link">
                    <div data-i18n="Contract">Kontrak</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{ route('users.pas') }}" class="menu-link">
                    <div data-i18n="PAS">PAS Tahunan</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <div data-i18n="User List">Daftar User</div>
                  </a>
                  <ul class="menu-sub">
                    <li class="menu-item">
                      <a href="{{ route('users.apron') }}" class="menu-link">
                        <div data-i18n="Apron">Porter Apron</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="{{ route('users.bge') }}" class="menu-link">
                        <div data-i18n="BGE">Porter BGE</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="{{ route('users.office') }}" class="menu-link">
                        <div data-i18n="Office">Office</div>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
@endif

            <!-- Document -->
            <li class="menu-item">
              <a href="{{ route('document') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Document">Dokumen</div>
              </a>
            </li>

            <!-- Training Menu -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-certification"></i>
                <div data-i18n="Training">Training</div>
              </a>
              <ul class="menu-sub">
                @if (in_array(Auth::user()->role, ['Admin', 'CHIEF']))
<li class="menu-item">
                  <a href="{{ route('training.index') }}" class="menu-link">
                    <div data-i18n="Management">Manajemen Training</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{ route('training.create') }}" class="menu-link">
                    <div data-i18n="Add">Tambah Sertifikat</div>
                  </a>
                </li>
@else
<li class="menu-item">
                  <a href="{{ route('my.certificates') }}" class="menu-link">
                    <div data-i18n="My Certificates">Sertifikat Training Saya</div>
                  </a>
                </li>
@endif
              </ul>
            </li>

            <!-- Apply Leave Menu -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div data-i18n="Apply Leave">Apply Leave</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('leaves.pengajuan') }}" class="menu-link">
                    <div data-i18n="Submission">Pengajuan Leave</div>
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
                    <div data-i18n="Report">Laporan Leave</div>
                  </a>
                </li>
@endif
              </ul>
            </li>

            <!-- Current Date & Time -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-time-five"></i>
                <div>
                  <span data-i18n="Current Time" id="tanggalSekarang">Loading...</span>
                </div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <!-- <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div> -->
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      @if (!empty(Auth::user()->profile_picture))
                      <img src="{{ asset('storage/photo/' . Auth::user()->profile_picture) }}" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;"/>
                      @else
                      <img src="{{ asset('template/') }}/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                      @endif
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="{{ route('users.profile', Auth::user()->id) }}">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              @if (!empty(Auth::user()->profile_picture))
                              <img src="{{ asset('storage/photo/' . Auth::user()->profile_picture) }}" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;"/>
                              @else
                              <img src="{{ asset('template/') }}/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                              @endif
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{ Auth::user()->fullname }}</span>
                            <small class="text-muted">{{ Auth::user()->role }}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              @yield('content')
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                      document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️
                  <!-- by <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a> -->
                </div>
                <!-- <div>
                  <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>
                  <a
                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >
                  <a
                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div> -->
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('template/') }}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('template/') }}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('template/') }}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('template/') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{ asset('template/') }}/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('template/') }}/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('template/') }}/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{ asset('template/') }}/assets/js/dashboards-analytics.js"></script>

    <!-- Date & Time Script -->
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
            document.getElementById('tanggalSekarang').textContent = formattedDate;
        }

        // Update immediately
        updateDateTime();

        // Update every second
        setInterval(updateDateTime, 1000);
    </script>

    @yield('scripts')
  </body>
</html>
