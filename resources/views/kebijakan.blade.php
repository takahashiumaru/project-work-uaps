@extends('layout.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Lainnya /</span> Kebijakan Privasi
    </h4>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-primary mb-4"><i class="fas fa-shield-alt me-2"></i> Kebijakan Privasi Aplikasi</h5>
            
            <p class="card-text mb-4">
                Kami sangat menjaga privasi dan keamanan data Anda. Segala informasi yang Anda berikan kepada sistem ini hanya akan digunakan untuk keperluan operasional <strong>PT. Angkasa Pratama Sejahtera</strong>.
            </p>
            
            <div class="mb-4">
                <h6>1. Pengumpulan Data</h6>
                <p class="text-muted mb-0">
                    Data yang dikumpulkan termasuk identitas diri, riwayat absensi, lokasi saat check-in, sertifikat training, dokumen cuti, dan log aktivitas dalam aplikasi.
                </p>
            </div>
            
            <div class="mb-4">
                <h6>2. Penggunaan Data</h6>
                <p class="text-muted mb-0">
                    Data akan digunakan sepenuhnya untuk:
                </p>
                <ul class="text-muted">
                    <li>Pengelolaan sumber daya manusia dan verifikasi identitas (PAS/TIM).</li>
                    <li>Pemantauan kehadiran dan penjadwalan kerja (Shift & Schedule).</li>
                    <li>Evaluasi kepatuhan, kompetensi (Training), dan administrasi perusahaan.</li>
                </ul>
            </div>

            <div class="mb-4">
                <h6>3. Keamanan Data</h6>
                <p class="text-muted mb-0">
                    Kami mengimplementasikan langkah-langkah keamanan untuk melindungi data Anda dari akses yang tidak sah. Data kredensial seperti password dienkripsi dengan standar keamanan modern.
                </p>
            </div>
            
            <div class="mb-0">
                <h6>4. Hak Pengguna</h6>
                <p class="text-muted mb-0">
                    Setiap staf berhak untuk melihat dan memperbarui informasi dasar pada menu Profil. Untuk perubahan data sensitif, harap hubungi Administrator atau pihak HR/HSE yang berwenang.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
