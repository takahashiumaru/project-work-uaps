<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('template/assets/') }}/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>Ganti Password</title>
    <meta name="description" content="" />
    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/pages/page-auth.css') }}" />
    <script src="{{ asset('template/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('template/assets/js/config.js') }}"></script>
    <style>
        body {
            background-color: #f8fafc !important;
            font-family: 'Public Sans', sans-serif !important;
        }

        .authentication-wrapper {
            background: #f8fafc !important;
        }

        .authentication-inner {
            max-width: 400px !important;
            width: 100%;
        }

        .card {
            border: none !important;
            border-radius: 20px !important;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.07) !important;
            overflow: hidden;
            background: #ffffff !important;
        }

        .card-body {
            padding: 30px !important;
        }

        .app-brand img {
            margin-bottom: 15px;
            height: 65px !important;
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
                  <img src="{{ asset('storage/aps_mini.png') }}" alt="Logo" height="65">
                </a>
              </div>
              <h4 class="mb-2">Ganti Password</h4>
              <p class="mb-4">Silakan masukkan password baru Anda.</p>
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

                {{-- kirim id yang sudah didapat dari controller/showChangePasswordForm (?id=...) --}}
                <input type="hidden" name="id" value="{{ old('id', $id ?? request()->query('id')) }}">

                <div class="mb-3">
                  <label for="password" class="form-label">Password Baru</label>
                  <input type="password" class="form-control" name="password" required autofocus>
                </div>
                <div class="mb-3">
                  <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                  <input type="password" class="form-control" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary d-grid w-100">Simpan Password</button>
              </form>
              <div class="text-center mt-3">
                <a href="{{ route('login') }}"><small>&larr; Kembali ke Login</small></a>
              </div>
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
  </body>
</html>