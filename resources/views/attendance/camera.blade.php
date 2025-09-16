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
        /* biru transparan */
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
        font-weight: normal;
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
    {{-- Video Kamera Full Screen --}}
    <video id="video" autoplay playsinline></video>
    <canvas id="canvas" class="d-none"></canvas>

    {{-- Tombol Back --}}
    <a href="{{ route('attendance.index') }}" class="btn-circle btn-back">
        ←
    </a>

    {{-- Form Absensi --}}
    <form id="attendanceForm" method="POST" action="{{ route('attendance.process') }}" class="btn-action">
        @csrf
        <input type="hidden" name="photo" id="photoInput">
        <input type="hidden" name="type" value="{{ $type }}">
        <button type="submit" id="btnSubmit" class="btn-circle">
            {{ strtoupper($type) }}
        </button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const video = document.getElementById("video");
        const canvas = document.getElementById("canvas");
        const btnSubmit = document.getElementById("btnSubmit");
        const photoInput = document.getElementById("photoInput");

        // Buka kamera (gunakan kamera depan di HP)
        navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: "user", // kamera depan
                    width: {
                        ideal: 1280
                    },
                    height: {
                        ideal: 720
                    },
                    brightness: {
                        ideal: 150
                    },
                    contrast: {
                        ideal: 150
                    },
                    exposureMode: "continuous"
                }
            })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => alert("Tidak bisa membuka kamera: " + err));


        // Ambil gambar saat tombol ditekan
        btnSubmit.addEventListener("click", function(e) {
            e.preventDefault();
            const context = canvas.getContext("2d");

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const dataURL = canvas.toDataURL("image/png");
            photoInput.value = dataURL;

            document.getElementById("attendanceForm").submit();
        });
    });
</script>
