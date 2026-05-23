@php
    $isCheckOut = $type === 'out';
    $actionTitle = $isCheckOut ? 'Clock Out' : 'Clock In';
    $actionSub = $isCheckOut ? 'Akhiri shift dengan verifikasi wajah dan GPS.' : 'Mulai shift dengan verifikasi wajah dan GPS.';
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $actionTitle }} - Attendance</title>
    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        :root {
            --cam-blue: #2f80ed;
            --cam-blue-dark: #2368c8;
            --cam-green: #5cc7b2;
            --cam-bg: #f9fafb;
            --cam-surface: #ffffff;
            --cam-card: rgba(255, 255, 255, 0.88);
            --cam-text: #1f2937;
            --cam-muted: #7b8aa0;
            --cam-border: #e6edf5;
            --cam-shadow: 0 24px 70px rgba(15, 23, 42, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
            margin: 0;
            background: var(--cam-bg);
            color: var(--cam-text);
            font-family: Inter, "Public Sans", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            overflow: hidden;
        }

        body.aps-camera-dark {
            --cam-bg: #0b1220;
            --cam-surface: #111c31;
            --cam-card: rgba(17, 28, 49, 0.82);
            --cam-text: #eaf1fb;
            --cam-muted: #94a3b8;
            --cam-border: #24324a;
            --cam-shadow: 0 26px 80px rgba(0, 0, 0, 0.32);
        }

        .camera-page {
            position: relative;
            width: 100vw;
            height: 100dvh;
            min-height: 620px;
            padding: clamp(1rem, 2vw, 1.35rem);
            display: grid;
            grid-template-rows: auto minmax(0, 1fr) auto;
            gap: 1rem;
            background:
                radial-gradient(circle at 12% 8%, rgba(47, 128, 237, 0.12), transparent 27%),
                radial-gradient(circle at 90% 92%, rgba(92, 199, 178, 0.12), transparent 25%),
                var(--cam-bg);
        }

        .camera-topbar,
        .camera-bottom-card {
            z-index: 5;
            border: 1px solid var(--cam-border);
            border-radius: 999px;
            background: var(--cam-card);
            box-shadow: var(--cam-shadow);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .camera-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.55rem;
        }

        .camera-back,
        .camera-mini-action {
            width: 46px;
            height: 46px;
            border: 0;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--cam-text);
            background: var(--cam-surface);
            text-decoration: none;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
        }

        .camera-back i,
        .camera-mini-action i {
            font-size: 1.35rem;
        }

        .camera-title {
            min-width: 0;
            flex: 1;
        }

        .camera-title small,
        .camera-title strong {
            display: block;
        }

        .camera-title small {
            color: var(--cam-muted);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .camera-title strong {
            color: var(--cam-text);
            font-size: clamp(0.96rem, 2vw, 1.08rem);
            font-weight: 780;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .camera-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            height: 40px;
            padding: 0 0.85rem;
            border-radius: 999px;
            background: rgba(47, 128, 237, 0.11);
            color: var(--cam-blue);
            font-size: 0.78rem;
            font-weight: 750;
            white-space: nowrap;
        }

        .camera-stage {
            position: relative;
            min-height: 0;
            border: 1px solid var(--cam-border);
            border-radius: 32px;
            overflow: hidden;
            background: #030712;
            box-shadow: var(--cam-shadow);
            isolation: isolate;
        }

        #video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
            background: #030712;
        }

        .camera-stage::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(to bottom, rgba(2, 6, 23, 0.54), transparent 24%, transparent 70%, rgba(2, 6, 23, 0.62)),
                radial-gradient(circle at 50% 45%, transparent 0 145px, rgba(2, 6, 23, 0.08) 146px 100%);
            z-index: 1;
        }

        .face-guide {
            position: absolute;
            z-index: 2;
            left: 50%;
            top: 46%;
            width: min(34vw, 260px);
            aspect-ratio: 0.78;
            transform: translate(-50%, -50%);
            border: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 46% 46% 42% 42%;
            box-shadow:
                0 0 0 9999px rgba(2, 6, 23, 0.1),
                0 0 38px rgba(47, 128, 237, 0.26);
            opacity: 0.88;
        }

        .camera-hint {
            position: absolute;
            z-index: 3;
            left: 50%;
            bottom: 1.1rem;
            transform: translateX(-50%);
            width: min(520px, calc(100% - 2rem));
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            padding: 0.72rem 1rem;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.68);
            color: #ffffff;
            font-size: 0.84rem;
            font-weight: 650;
            text-align: center;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .camera-loader {
            position: absolute;
            inset: 0;
            z-index: 4;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background:
                radial-gradient(circle at 50% 38%, rgba(47, 128, 237, 0.16), transparent 28%),
                #030712;
            color: #eaf1fb;
            text-align: center;
            transition: opacity 0.24s ease, visibility 0.24s ease;
        }

        .camera-loader.is-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .loader-card {
            width: min(380px, 100%);
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 26px;
            background: rgba(17, 28, 49, 0.78);
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.34);
        }

        .loader-icon {
            width: 64px;
            height: 64px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            border-radius: 999px;
            background: rgba(47, 128, 237, 0.18);
            color: #8fc2ff;
            font-size: 1.9rem;
        }

        .loader-card strong,
        .loader-card span {
            display: block;
        }

        .loader-card strong {
            font-size: 1.08rem;
            font-weight: 780;
        }

        .loader-card span {
            margin-top: 0.35rem;
            color: #94a3b8;
            font-size: 0.84rem;
            line-height: 1.55;
        }

        .camera-bottom-card {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: 0.9rem;
            padding: 0.62rem;
            border-radius: 28px;
        }

        .camera-meta {
            min-width: 0;
            padding-left: 0.45rem;
        }

        .camera-meta strong,
        .camera-meta span {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .camera-meta strong {
            color: var(--cam-text);
            font-size: 0.95rem;
            font-weight: 780;
        }

        .camera-meta span {
            color: var(--cam-muted);
            font-size: 0.78rem;
            font-weight: 600;
        }

        .camera-submit {
            min-width: 148px;
            height: 54px;
            border: 0;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.52rem;
            background: linear-gradient(135deg, var(--cam-blue), var(--cam-blue-dark));
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 780;
            box-shadow: 0 16px 32px rgba(47, 128, 237, 0.28);
            cursor: pointer;
            transition: transform 0.18s ease, box-shadow 0.18s ease, opacity 0.18s ease;
        }

        .camera-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 20px 38px rgba(47, 128, 237, 0.34);
        }

        .camera-submit:disabled {
            opacity: 0.62;
            cursor: not-allowed;
            transform: none;
        }

        .d-none {
            display: none !important;
        }

        @media (max-width: 767.98px) {
            html,
            body {
                overflow: auto;
            }

            .camera-page {
                min-height: 100dvh;
                height: 100dvh;
                padding: 0.75rem;
                grid-template-rows: auto minmax(0, 1fr) auto;
                gap: 0.72rem;
            }

            .camera-topbar {
                border-radius: 24px;
            }

            .camera-status-pill {
                display: none;
            }

            .camera-stage {
                border-radius: 28px;
            }

            .face-guide {
                width: min(58vw, 230px);
            }

            .camera-hint {
                bottom: 0.85rem;
                width: calc(100% - 1.5rem);
                border-radius: 18px;
                font-size: 0.78rem;
            }

            .camera-bottom-card {
                grid-template-columns: 1fr;
                border-radius: 24px;
                padding: 0.65rem;
            }

            .camera-meta {
                text-align: center;
                padding: 0.15rem 0.25rem 0;
            }

            .camera-submit {
                width: 100%;
                min-width: 0;
                height: 52px;
            }
        }
    </style>
</head>

<body>
    <script>
        (function() {
            document.body.classList.toggle('aps-camera-dark', (localStorage.getItem('apsTheme') || 'light') === 'dark');
        })();
    </script>

    <main class="camera-page">
        <header class="camera-topbar">
            <a href="{{ route('attendance.index') }}" class="camera-back" aria-label="Kembali">
                <i class="bx bx-arrow-back"></i>
            </a>
            <div class="camera-title">
                <small>Attendance Verification</small>
                <strong>{{ $actionTitle }} - {{ $user->fullname ?? 'Staff APS' }}</strong>
            </div>
            <div class="camera-status-pill" id="cameraStatus">
                <i class="bx bx-camera"></i>
                <span>Menyiapkan kamera</span>
            </div>
        </header>

        <section class="camera-stage" aria-label="Preview kamera">
            <video id="video" autoplay playsinline muted></video>
            <canvas id="canvas" class="d-none"></canvas>
            <div class="face-guide" aria-hidden="true"></div>
            <div class="camera-hint">
                <i class="bx bx-face"></i>
                <span>Posisikan wajah di tengah frame, lalu pastikan GPS aktif.</span>
            </div>
            <div class="camera-loader" id="cameraLoader">
                <div class="loader-card">
                    <div class="loader-icon"><i class="bx bx-camera"></i></div>
                    <strong id="loaderTitle">Membuka kamera</strong>
                    <span id="loaderText">Izinkan akses kamera agar sistem dapat mengambil foto verifikasi.</span>
                </div>
            </div>
        </section>

        <form id="attendanceForm" method="POST" action="{{ route('attendance.process') }}" class="camera-bottom-card">
            @csrf
            <input type="hidden" name="photo" id="photoInput">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="type" value="{{ $type }}">

            <div class="camera-meta">
                <strong>{{ $actionTitle }} Sekarang</strong>
                <span>{{ $actionSub }}</span>
            </div>
            <button type="submit" id="btnSubmit" class="camera-submit" disabled>
                <i class="bx {{ $isCheckOut ? 'bx-log-out' : 'bx-log-in' }}"></i>
                <span>{{ $actionTitle }}</span>
            </button>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal Absensi',
                text: "{{ session('error') }}",
                confirmButtonColor: '#2f80ed'
            });
        </script>
    @endif

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2f80ed'
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const btnSubmit = document.getElementById('btnSubmit');
            const photoInput = document.getElementById('photoInput');
            const loader = document.getElementById('cameraLoader');
            const loaderTitle = document.getElementById('loaderTitle');
            const loaderText = document.getElementById('loaderText');
            const cameraStatus = document.getElementById('cameraStatus');

            const setStatus = (icon, text) => {
                cameraStatus.innerHTML = `<i class="bx ${icon}"></i><span>${text}</span>`;
            };

            const setErrorState = (title, text) => {
                loader.classList.remove('is-hidden');
                loaderTitle.textContent = title;
                loaderText.textContent = text;
                setStatus('bx-error-circle', 'Kamera belum siap');
                btnSubmit.disabled = true;
            };

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                setErrorState('Browser belum mendukung kamera', 'Gunakan browser modern dan pastikan akses kamera tersedia.');
                return;
            }

            navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user',
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: false
            }).then((stream) => {
                video.srcObject = stream;
                video.onloadedmetadata = () => {
                    loader.classList.add('is-hidden');
                    btnSubmit.disabled = false;
                    setStatus('bx-check-circle', 'Kamera siap');
                };
            }).catch(() => {
                setErrorState('Tidak bisa membuka kamera', 'Periksa izin kamera di browser, lalu coba buka halaman ini kembali.');
                Swal.fire({
                    icon: 'error',
                    title: 'Kamera tidak tersedia',
                    text: 'Periksa izin kamera di browser, lalu coba buka halaman ini kembali.',
                    confirmButtonColor: '#2f80ed'
                });
            });

            btnSubmit.addEventListener('click', function(e) {
                e.preventDefault();

                if (!video.videoWidth || !video.videoHeight) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Kamera belum siap',
                        text: 'Tunggu preview kamera muncul sebelum melakukan absensi.',
                        confirmButtonColor: '#2f80ed'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Mengambil lokasi',
                    text: 'Mohon tunggu, sistem sedang memverifikasi GPS Anda.',
                    allowOutsideClick: false,
                    confirmButtonColor: '#2f80ed',
                    didOpen: () => Swal.showLoading()
                });

                const handleSuccess = (position) => {
                    const context = canvas.getContext('2d');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    photoInput.value = canvas.toDataURL('image/png');
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;

                    document.getElementById('attendanceForm').submit();
                };

                const handleFailure = (error) => {
                    let title = 'GPS tidak tersedia';
                    let message = 'Aktifkan izin lokasi agar absensi dapat diverifikasi.';

                    if (error.code === error.PERMISSION_DENIED) {
                        title = 'Izin Lokasi Ditolak';
                        message = 'Aktifkan izin lokasi di pengaturan browser untuk melakukan absensi.';
                    } else if (error.code === error.POSITION_UNAVAILABLE) {
                        title = 'Sinyal GPS Lemah';
                        message = 'Lokasi tidak dapat ditentukan. Pastikan GPS dan koneksi internet Anda aktif, atau coba di area yang lebih terbuka.';
                    } else if (error.code === error.TIMEOUT) {
                        title = 'Waktu Permintaan Habis';
                        message = 'Gagal mendapatkan lokasi tepat waktu. Silakan coba klik tombol Clock In lagi.';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: title,
                        text: message,
                        confirmButtonColor: '#2f80ed'
                    });
                };

                // Coba dapatkan lokasi dengan akurasi tinggi terlebih dahulu
                navigator.geolocation.getCurrentPosition(handleSuccess, function(error) {
                    // Jika izin lokasi ditolak oleh pengguna, langsung tampilkan error
                    if (error.code === error.PERMISSION_DENIED) {
                        handleFailure(error);
                    } else {
                        // Jika error berupa timeout atau posisi tidak tersedia, lakukan fallback dengan akurasi standar
                        navigator.geolocation.getCurrentPosition(handleSuccess, function(error2) {
                            handleFailure(error2);
                        }, {
                            enableHighAccuracy: false,
                            timeout: 10000,
                            maximumAge: 10000
                        });
                    }
                }, {
                    enableHighAccuracy: true,
                    timeout: 6000, // Timeout 6 detik untuk pencarian presisi tinggi
                    maximumAge: 0
                });
            });
        });
    </script>
</body>

</html>
