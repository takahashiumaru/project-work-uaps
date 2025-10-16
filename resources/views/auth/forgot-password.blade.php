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
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>Lupa Password</title>
    <meta name="description" content="" />
    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/pages/page-auth.css') }}" />
    <script src="{{ asset('template/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('template/assets/js/config.js') }}"></script>
  </head>
  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <div class="card">
            <div class="card-body">
              <div class="app-brand justify-content-center">
                <a href="javascript:void(0);" class="app-brand-link gap-2">
                  <img src="{{ asset('storage/aps.jpeg') }}" alt="Logo" height="80">
                </a>
              </div>
              <h4 class="mb-2">Lupa Password 🔒</h4>
              <p class="mb-4">Masukkan NIP Anda untuk menerima OTP reset password melalui email.</p>
              @if(session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
              @if(session('otp_sent'))
                <div class="alert alert-success alert-dismissible" role="alert">
                  OTP telah dikirim ke email Anda.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
              <form method="POST" action="{{ session('otp_sent') ? route('forgot.password.verify') : route('forgot.password.send') }}">
                @csrf
                <div class="mb-3">
                    <label for="id" class="form-label">NIP</label>
                    <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ old('id') }}" required autofocus {{ session('otp_sent') ? 'readonly' : '' }}>
                    @error('id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @if(session('otp_sent'))
                    <div class="mb-3">
                    <label for="otp" class="form-label">OTP</label>
                    <input type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" required>
                    @error('otp')
                        <div class="invalid-feedback">{{ $message }}</div>
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