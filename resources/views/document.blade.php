@extends('layout.admin')

@section('styles')
    <style>
        .form-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #2c3e50;
            border-left: 5px solid #3498db;
            padding-left: 10px;
            text-align: left;
        }

        .form-card {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            max-width: 700px;
        }

        .requirement-list {
            list-style-type: none;
            padding-left: 0;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .requirement-list li {
            padding: 6px 0;
            font-size: 16px;
        }

        .note {
            margin-top: 10px;
            font-style: italic;
            color: #555;
            background-color: #fefae0;
            padding: 10px;
            border-left: 4px solid #f39c12;
            border-radius: 6px;
        }

        .btn-download {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-download:hover {
            background-color: #2980b9;
            color: white; /* Menambahkan ini agar warna teks tetap putih saat hover */
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Dokumen /</span> Cetak Dokumen
            </h4>

            <h2 class="form-title">📄 Formulir Perpanjangan Pas Bandara</h2>

            <div class="form-card">
                <p>Silakan unduh formulir resmi untuk keperluan <strong>perpanjangan Pas Bandara</strong> melalui tautan di bawah ini. Pastikan Anda telah menyiapkan semua dokumen berikut:</p>

                <ul class="requirement-list">
                    <li>📌 SKCK Asli</li>
                    <li>📷 Pas Foto Terbaru</li>
                    <li>📝 Surat Daftar Riwayat Hidup</li>
                    <li>📄 Surat Perjanjian Tugas Kerja</li>
                    <li>🔖 Surat Pengganti ID Card <em>(jika ada)</em></li>
                    <li>🖋️ Surat Pernyataan</li>
                </ul>

                <p class="note">
                    🛂 <em>Setelah semua persyaratan lengkap, serahkan dokumen kepada bagian <strong>HRD</strong>.</em>
                </p>

                <a href="{{ asset('storage/file/formulir_pas_bandara.pdf') }}" class="btn-download" download>
                    ⬇️ Unduh Formulir
                </a>
                {{-- @yield('konten') dihilangkan karena tidak relevan di sini --}}
            </div>

            <br>

            <h2 class="form-title">📄 Formulir Surat Pernyataan</h2>

            <div class="form-card">
                <p>Silakan unduh formulir resmi untuk keperluan <strong>Surat Pernyataan</strong></p>
                <a href="{{ asset('storage/file/SURAT_PERNYATAAN.pdf') }}" class="btn-download" download>
                    ⬇️ Unduh Formulir
                </a>
            </div>

            <br>

            <h2 class="form-title">📄 Surat Pernyataan ID Card Sementara</h2>

            <div class="form-card">
                <p>Klik tombol di bawah untuk mengunduh surat pernyataan ID card sementara yang telah diisi dengan data Anda:</p>
                <a href="{{ route('surat.generate') }}" class="btn-download" download>
                    ⬇️ Download Surat Pengganti ID Card
                </a>
            </div>
        </div>
    </div>
@endsection