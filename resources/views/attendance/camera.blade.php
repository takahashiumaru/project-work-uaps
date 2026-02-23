<style>
    body,
    html {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
        background: black;
    }

    #video {
        width: 100vw;
        height: 100vh;
        object-fit: cover;
    }

    .btn-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 123, 255, 0.85);
        color: white;
        font-size: 18px;
        font-weight: bold;
        border: none;
        backdrop-filter: blur(5px);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    }

    .btn-circle:hover {
        background: rgba(0, 123, 255, 1);
    }

    .btn-back {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 10;
        font-size: 24px;
    }

    .btn-action {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
    }
</style>

<div class="position-relative">

    <video id="video" autoplay playsinline></video>
    <canvas id="canvas" class="d-none"></canvas>

    <a href="{{ route('attendance.index') }}" class="btn-circle btn-back">
        ←
    </a>

    <form id="attendanceForm"
        method="POST"
        action="{{ route('attendance.process') }}"
        class="btn-action">
        @csrf

        <input type="hidden" name="photo" id="photoInput">
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <input type="hidden" name="type" value="{{ $type }}">

        <button type="submit" id="btnSubmit" class="btn-circle">
            {{ strtoupper($type) }}
        </button>
    </form>

</div>

{{-- SweetAlert CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Flash Message --}}
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Absensi',
        text: "{{ session('error') }}",
        confirmButtonColor: '#d33'
    });
</script>
@endif

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        confirmButtonColor: '#3085d6'
    });
</script>
@endif


<script>
    document.addEventListener("DOMContentLoaded", function() {

        const video = document.getElementById("video");
        const canvas = document.getElementById("canvas");
        const btnSubmit = document.getElementById("btnSubmit");
        const photoInput = document.getElementById("photoInput");

        // Aktifkan kamera depan
        navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: "user",
                width: {
                    ideal: 1280
                },
                height: {
                    ideal: 720
                }
            }
        }).then(stream => {
            video.srcObject = stream;
        }).catch(err => {
            Swal.fire("Error", "Tidak bisa membuka kamera", "error");
        });

        btnSubmit.addEventListener("click", function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Mengambil lokasi...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            navigator.geolocation.getCurrentPosition(function(position) {

                // Ambil foto
                const context = canvas.getContext("2d");
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                photoInput.value = canvas.toDataURL("image/png");

                document.getElementById("latitude").value = position.coords.latitude;
                document.getElementById("longitude").value = position.coords.longitude;

                document.getElementById("attendanceForm").submit();

            }, function(error) {
                Swal.fire("Error", "Tidak bisa mengambil lokasi GPS!", "error");
            });
        });

    });
</script>
