<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('template/assets/') }}/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Employee Login</title>
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
                <h1>Operasional station lebih tenang dalam satu sistem.</h1>
                <p>Masuk untuk memantau schedule, kehadiran, flight, dan data staff APS dengan tampilan yang rapi di
                    desktop maupun mobile.</p>
                <div class="aps-auth-hero-stats">
                    <div class="aps-auth-stat">
                        <strong>332</strong>
                        <span>Total Staff</span>
                    </div>
                    <div class="aps-auth-stat">
                        <strong>24/7</strong>
                        <span>Monitoring</span>
                    </div>
                    <div class="aps-auth-stat">
                        <strong>APS</strong>
                        <span>Station Ops</span>
                    </div>
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
                <h4>Employee Login</h4>
                <p>Silakan masuk dengan NIP dan password Anda.</p>

                @if ($errors->any() || session('error') || session('success'))
                    <div class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }} alert-dismissible"
                        role="alert">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        @endif
                        @if (session('error'))
                            {{ session('error') }}
                        @endif
                        @if (session('success'))
                            {{ session('success') }}
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form id="formAuthentication" class="mb-0" action="{{ route('actionlogin') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="id" class="aps-auth-label">NIP</label>
                        <div class="aps-auth-input">
                            <i class="bx bx-id-card"></i>
                            <input type="text" class="form-control @error('id') is-invalid @enderror" id="id"
                                name="id" placeholder="Masukkan NIP Anda" autofocus required pattern="[0-9]*"
                                value="{{ old('id') }}" />
                        </div>
                        @error('id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="aps-auth-label-row">
                            <label class="aps-auth-label" for="password">Password</label>
                            <a class="aps-auth-link" href="{{ route('forgot.password.form') }}">Lupa Password?</a>
                        </div>
                        <div class="aps-auth-input">
                            <i class="bx bx-lock-alt"></i>
                            <input type="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Masukkan password Anda" aria-describedby="password" required />
                            <button type="button" class="btn-toggle-password" id="togglePassword"
                                aria-label="Toggle password visibility">
                                <i class="bx bx-show" id="iconShow"></i>
                                <i class="bx bx-hide" id="iconHide" style="display:none;"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                </form>
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

            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const iconShow = document.getElementById('iconShow');
            const iconHide = document.getElementById('iconHide');

            toggleBtn?.addEventListener('click', function() {
                const isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                iconShow.style.display = isHidden ? 'none' : 'inline-flex';
                iconHide.style.display = isHidden ? 'inline-flex' : 'none';
            });
        });
    </script>
</body>

</html>
