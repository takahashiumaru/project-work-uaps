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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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
    <style>
        body {
            background-color: #f8fafc !important; /* Warna yang lebih bersih dan konsisten */
            font-family: 'Public Sans', sans-serif !important;
        }

        .authentication-wrapper {
            background: #f8fafc !important; /* Hilangkan gradient yang membingungkan */
        }

        .authentication-inner {
            max-width: 400px !important; /* Dikecilkan agar lebih proporsional */
            width: 100%;
        }

        .card {
            border: none !important;
            border-radius: 20px !important; /* Sedikit dikurangi agar tidak terlalu bulat di box kecil */
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.07) !important;
            overflow: hidden;
            background: #ffffff !important;
        }

        .card-body {
            padding: 30px !important; /* Dikurangi dari 40px */
        }

        .app-brand img {
            margin-bottom: 15px;
            height: 65px !important; /* Dikecilkan sedikit */
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.05));
        }

        h4 {
            font-weight: 700 !important;
            color: #2c3e50 !important;
            letter-spacing: -0.5px;
        }

        p {
            color: #7f8c8d !important;
            font-size: 0.95rem;
        }

        .form-label {
            font-weight: 600 !important;
            color: #34495e !important;
            margin-bottom: 8px !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .form-control {
            border-radius: 12px !important;
            padding: 12px 16px !important;
            border: 1.5px solid #e0e6ed !important;
            transition: all 0.3s ease !important;
            background: #fff !important;
        }

        .form-control:focus {
            border-color: #4A7EBB !important;
            box-shadow: 0 0 0 4px rgba(74, 126, 187, 0.1) !important;
            background: #fff !important;
        }

        /* Password toggle wrapper */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 48px !important;
        }

        .btn-toggle-password {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            outline: none;
            box-shadow: none !important;
            cursor: pointer;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: #94a3b8;
            transition: color 0.2s ease, background 0.2s ease;
            padding: 0;
            z-index: 5;
        }

        .btn-toggle-password:hover {
            color: #4A7EBB;
            background: rgba(74, 126, 187, 0.08);
        }

        .btn-toggle-password:focus {
            outline: none;
            box-shadow: none !important;
        }

        .btn-toggle-password svg {
            width: 18px;
            height: 18px;
            transition: opacity 0.15s ease;
        }

        .btn-primary {
            background-color: #4A7EBB !important;
            border-color: #4A7EBB !important;
            border-radius: 12px !important;
            padding: 12px !important;
            font-weight: 700 !important;
            font-size: 1rem !important;
            letter-spacing: 0.5px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 8px 20px rgba(74, 126, 187, 0.2) !important;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #3A6DAA !important;
            border-color: #3A6DAA !important;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(74, 126, 187, 0.3) !important;
        }

        .alert {
            border-radius: 12px !important;
            border: none !important;
            font-weight: 500;
        }

        small a {
            color: #4A7EBB !important;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .authentication-inner {
                max-width: 90% !important;
                margin: 0 auto;
            }
            .card-body {
                padding: 25px 20px !important;
            }
            h4 {
                font-size: 1.25rem !important;
            }
        }
    </style>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="javascript:void(0);" class="app-brand-link gap-2">
                                {{-- Anda bisa mengganti logo SVG ini dengan elemen img Anda --}}
                                <img src="{{ asset('storage/aps_mini.png') }}" alt="Logo" height="65">
                            </a>
                        </div>
                        <h4 class="mb-2">Employee Login 👋</h4>
                        <p class="mb-4">Silakan masuk dengan NIP Anda.</p>

                        {{-- LOGIKA PENANGANAN ERROR UMUM (DARI login.blade.php ASLI) --}}
                        @if ($errors->any() || session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{-- Tampilkan error dari validasi Laravel --}}
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                @endif

                                {{-- Tampilkan error sesi (seperti jika login gagal) --}}
                                @if (session('error'))
                                    {{ session('error') }}
                                @endif
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- FORM DENGAN ROUTING DAN CSRF YANG DIHILANGKAN --}}
                        <form id="formAuthentication" class="mb-3" action="{{ route('actionlogin') }}"
                            method="POST">
                            @csrf

                            {{-- NIP FIELD (Menggantikan Email/Username) --}}
                            <div class="mb-3">
                                <label for="id" class="form-label">NIP</label>
                                <input type="text" class="form-control @error('id') is-invalid @enderror"
                                    id="id" name="id" placeholder="Masukkan NIP Anda" autofocus required
                                    pattern="[0-9]*" value="{{ old('id') }}" />
                                @error('id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="{{ route('forgot.password.form') }}">
                                        <small>Lupa Password?</small>
                                    </a>
                                </div>
                                <div class="password-wrapper">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Masukkan password Anda"
                                        aria-describedby="password" required />
                                    <button type="button" class="btn-toggle-password" id="togglePassword" aria-label="Toggle password visibility">
                                        <!-- Eye icon (show) -->
                                        <svg id="iconShow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <!-- Eye-off icon (hide) -->
                                        <svg id="iconHide" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>

                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                    <label class="form-check-label" for="remember-me"> Ingat Saya </label>
                  </div>
                </div> -->

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                            </div>
                        </form>

                        {{-- <p class="text-center">
                <span>New on our platform?</span>
                <a href="auth-register-basic.html">
                  <span>Create an account</span>
                </a>
              </p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('template/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('template/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('template/assets/js/main.js') }}"></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const iconShow = document.getElementById('iconShow');
            const iconHide = document.getElementById('iconHide');

            toggleBtn.addEventListener('click', function() {
                const isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                iconShow.style.display = isHidden ? 'none' : 'block';
                iconHide.style.display = isHidden ? 'block' : 'none';
                // Beri visual feedback animasi
                toggleBtn.style.color = isHidden ? '#4A7EBB' : '#94a3b8';
            });
        });
    </script>
</body>

</html>
