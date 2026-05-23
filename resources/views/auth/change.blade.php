<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('template/assets/') }}/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Ganti Password</title>
    <meta name="description" content="" />
    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
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
                <h1>Buat password baru dengan tampilan yang tetap bersih.</h1>
                <p>Gunakan password yang aman agar akses dashboard APS tetap terlindungi di setiap station.</p>
                <div class="aps-auth-hero-stats">
                    <div class="aps-auth-stat"><strong>2x</strong><span>Confirm</span></div>
                    <div class="aps-auth-stat"><strong>Safe</strong><span>Password</span></div>
                    <div class="aps-auth-stat"><strong>APS</strong><span>Account</span></div>
                </div>
            </div>
        </aside>

        <main class="aps-auth-form-side">
            <div class="aps-auth-theme" aria-label="Theme switcher">
                <button type="button" class="auth-theme-btn" data-auth-theme="light" aria-label="Light mode"><i class="bx bx-sun"></i></button>
                <button type="button" class="auth-theme-btn" data-auth-theme="dark" aria-label="Dark mode"><i class="bx bx-moon"></i></button>
            </div>

            <section class="aps-auth-card">
                <img class="aps-auth-mobile-brand" src="{{ asset('storage/aps_mini.png') }}" alt="APS">
                <div class="aps-auth-card-brand">
                    <img src="{{ asset('storage/aps_mini.png') }}" alt="APS">
                    <span>SIAPS</span>
                </div>
                <h4>Ganti Password</h4>
                <p>Silakan masukkan password baru Anda.</p>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="/forgot-password/change">
                    @csrf
                    <input type="hidden" name="id" value="{{ old('id', $id ?? request()->query('id')) }}">

                    <div class="mb-3">
                        <label for="password" class="aps-auth-label">Password Baru</label>
                        <div class="aps-auth-input">
                            <i class="bx bx-lock-alt"></i>
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="Masukkan password baru" required autofocus>
                            <button type="button" class="btn-toggle-password" data-toggle-password="password" aria-label="Toggle password visibility">
                                <i class="bx bx-show"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="aps-auth-label">Konfirmasi Password Baru</label>
                        <div class="aps-auth-input">
                            <i class="bx bx-shield-quarter"></i>
                            <input type="password" id="password_confirmation" class="form-control"
                                name="password_confirmation" placeholder="Ulangi password baru" required>
                            <button type="button" class="btn-toggle-password" data-toggle-password="password_confirmation" aria-label="Toggle password visibility">
                                <i class="bx bx-show"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary d-grid w-100">Simpan Password</button>
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

            document.querySelectorAll('[data-toggle-password]').forEach((btn) => {
                btn.addEventListener('click', function() {
                    const input = document.getElementById(this.dataset.togglePassword);
                    const icon = this.querySelector('i');
                    const isHidden = input.type === 'password';
                    input.type = isHidden ? 'text' : 'password';
                    icon.className = isHidden ? 'bx bx-hide' : 'bx bx-show';
                });
            });
        });
    </script>
</body>

</html>
