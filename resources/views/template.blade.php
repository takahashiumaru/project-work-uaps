<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pengganti ID Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
        }

        .kop-surat img {
            width: 350px;
            height: auto;
            display: block;
            margin: 0;
            padding-left: 45px;
        }

        .judul-surat {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
        }

        .isi-surat {
            margin-top: 20px;
        }

        .data-penandatangan,
        .data-karyawan {
            margin-left: 30px;
        }

        .data-penandatangan td,
        .data-karyawan td {
            padding: 4px 8px;
            vertical-align: top;
        }

        .tempat-tanggal {
            text-align: left;
            margin-top: 30px;
            margin-right: 50px;
        }

        .tanda-tangan {
            text-align: left;
            margin-right: 50px;
        }

        .nama-penandatangan {
            margin-top: 60px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <img src="{{ $base64 }}" alt="Kop Surat">
    </div>

    <div class="isi-surat">
        <h2 class="judul-surat">SURAT PENGGANTI ID CARD</h2>
        <p class="pembuka">Yang bertanda tangan di bawah ini:</p>

        <table class="data-penandatangan">
            <tr>
                <td>Nama</td>
                <td>: Tedy Santoso</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>: General Manager IT & GA</td>
            </tr>
            <tr>
                <td valign="top">Alamat Kantor</td>
                <td>
                    : Soekarno-Hatta International Airport<br>
                    &nbsp;&nbsp;Wisma Soewarna Lt 1<br>
                    &nbsp;&nbsp;Jakarta 19130, Indonesia
                </td>
            </tr>
        </table>

        <p class="pemberitahuan">Menerangkan bahwa:</p>

        <table class="data-karyawan">
            <tr>
                <td>Nama</td>
                <td>: {{ $nama_karyawan }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $nik_karyawan }}</td>
            </tr>
            <tr>
                <td>Posisi / Jabatan</td>
                <td>: {{ $posisi_karyawan }}</td>
            </tr>
            <tr>
                <td valign="top">Alamat</td>
                <td>
                    : {{ $alamat_karyawan }}
                </td>
            </tr>
        </table>

        <p>
            Bersangkutan adalah benar karyawan dan atau pihak ketiga dari instansi/perusahaan PT. Jasa Angkasa Semesta, Tbk dan saat ini masih aktif bekerja serta tidak pernah bermasalah di perusahaan tempat bekerja.<br><br>
            Yang bersangkutan sampai dengan surat ini belum mempunyai kartu pegawai / ID CARD karena masih dalam proses pembuatan.<br><br>
            Segala akibat dan tindakan penyalahgunaan Pass Bandara yang dilakukan oleh personil yang bersangkutan menjadi tanggung jawab karyawan tersebut dari instansi / perusahaan PT. Jasa Angkasa Semesta, Tbk.
        </p>

        <p class="penutup">Demikian surat pernyataan ini kami buat dengan sebenar-benarnya.</p>

        <div class="tempat-tanggal">
            Tangerang, {{ $tanggal_surat }}
        </div>

        <div class="tanda-tangan">
            <p>Yang membuat pernyataan,</p>
            <p><b>General Manager IT & GA</b></p>
            <p><b>PT. Jasa Angkasa Semesta, Tbk</b></p>
            <p class="nama-penandatangan">Tedy Santoso</p>
        </div>
    </div>
</body>

</html>
