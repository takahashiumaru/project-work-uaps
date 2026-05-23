<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('template/assets/') }}/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Lupa Password</title>
    <meta name="description" content="" />
    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/pages/page-auth.css') }}" />
    <script src="{{ asset('template/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('template/assets/js/config.js') }}"></script>
    @include('auth.partials.auth-style')
</head>

<body>
    <script>
        (function() {
            const theme = localStorage.getItem('apsTheme') || 'light';
            document.body.classList.toggle('aps-auth-dark', theme === 'dark');
        })();
    </script>

    <div class="aps-auth-shell">
        <aside class="aps-auth-hero">
            <div class="aps-auth-hero-content">
                <div class="aps-auth-brand-pill">
                    <img src="{{ asset('storage/aps_mini.png') }}" alt="APS">
                    <span>SIAPS</span>
                </div>
                <h1>Pulihkan akses akun dengan aman dan cepat.</h1>
                <p>Masukkan NIP, verifikasi OTP, lalu buat password baru agar Anda bisa kembali mengakses dashboard
                    SIAPS.</p>
                <div class="aps-auth-hero-stats">
                    <div class="aps-auth-stat"><strong>OTP</strong><span>Secure Flow</span></div>
                    <div class="aps-auth-stat"><strong>NIP</strong><span>Staff ID</span></div>
                    <div class="aps-auth-stat"><strong>APS</strong><span>Access</span></div>
                </div>
            </div>
        </aside>

        <main class="aps-auth-form-side">
            <div class="aps-auth-theme" aria-label="Theme switcher">
                <button type="button" class="auth-theme-btn" data-auth-theme="light" aria-label="Light mode"><i
                        class="bx bx-sun"></i></button>
                <button type="button" class="auth-theme-btn" data-auth-theme="dark" aria-label="Dark mode"><i
                        class="bx bx-moon"></i></button>
            </div>

            <section class="aps-auth-card">
                <img class="aps-auth-mobile-brand" src="{{ asset('storage/aps_mini.png') }}" alt="APS">
                <div class="aps-auth-card-brand">
                    <img src="{{ asset('storage/aps_mini.png') }}" alt="APS">
                    {{-- <span>SIAPS</span> --}}
                </div>
                <h4>{{ session('otp_sent') ? 'Verifikasi OTP' : 'Lupa Password' }}</h4>
                <p>{{ session('otp_sent') ? 'Masukkan kode OTP yang sudah dikirim ke email Anda.' : 'Masukkan NIP Anda untuk menerima OTP reset password melalui email.' }}
                </p>

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('otp_sent'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        OTP telah dikirim ke email Anda.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST"
                    action="{{ session('otp_sent') ? route('forgot.password.verify') : route('forgot.password.send') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="id" class="aps-auth-label">NIP</label>
                        <div class="aps-auth-input">
                            <i class="bx bx-id-card"></i>
                            <input type="text" class="form-control @error('id') is-invalid @enderror" name="id"
                                value="{{ old('id') }}" placeholder="Masukkan NIP Anda" required autofocus
                                {{ session('otp_sent') ? 'readonly' : '' }}>
                        </div>
                        @error('id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    @if (session('otp_sent'))
                        <div class="mb-3">
                            <label for="otp" class="aps-auth-label">OTP</label>
                            <div class="aps-auth-input">
                                <i class="bx bx-key"></i>
                                <input type="text" class="form-control @error('otp') is-invalid @enderror"
                                    name="otp" placeholder="Masukkan kode OTP" required>
                            </div>
                            @error('otp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-100">Verifikasi OTP</button>
                    @else
                        <button type="submit" class="btn btn-primary d-grid w-100">Kirim OTP</button>
                    @endif
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}"><small>&larr; Kembali ke Login</small></a>
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('template/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('template/assets/js/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const applyTheme = (theme) => {
                document.body.classList.toggle('aps-auth-dark', theme === 'dark');
                localStorage.setItem('apsTheme', theme);
                document.querySelectorAll('[data-auth-theme]').forEach((btn) => {
                    btn.classList.toggle('is-active', btn.dataset.authTheme === theme);
                });
            };

            applyTheme(localStorage.getItem('apsTheme') || 'light');
            document.querySelectorAll('[data-auth-theme]').forEach((btn) => {
                btn.addEventListener('click', () => applyTheme(btn.dataset.authTheme));
            });
        });
    </script>
</body>

</html>
