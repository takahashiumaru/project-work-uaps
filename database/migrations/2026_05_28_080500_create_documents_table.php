<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');
            $table->text('deskripsi_dokumen')->nullable();
            $table->string('nama_file');
            $table->string('file_path');
            $table->string('ukuran_file', 50)->nullable();
            $table->string('role_akses_dokumen', 50)->default('all')->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });

        $now = now();

        DB::table('documents')->insert([
            [
                'nama_dokumen' => 'Formulir Perpanjangan Pas Bandara',
                'deskripsi_dokumen' => 'Dokumen resmi untuk keperluan perpanjangan Pas Bandara, termasuk persyaratan SKCK dan foto.',
                'nama_file' => 'formulir_pas_bandara.pdf',
                'file_path' => 'file/formulir_pas_bandara.pdf',
                'ukuran_file' => '1.2 MB',
                'role_akses_dokumen' => 'all',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_dokumen' => 'Laporan Keuangan Q1 2026',
                'deskripsi_dokumen' => 'Rekapitulasi pengeluaran dan pemasukan operasional bandara kuartal pertama.',
                'nama_file' => 'laporan_keuangan_q1_2026.pdf',
                'file_path' => 'file/laporan_keuangan_q1_2026.pdf',
                'ukuran_file' => '4.5 MB',
                'role_akses_dokumen' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_dokumen' => 'SOP Penanganan Keadaan Darurat',
                'deskripsi_dokumen' => 'Standar operasional prosedur untuk penanganan insiden dan keadaan darurat di area stasiun.',
                'nama_file' => 'sop_penanganan_keadaan_darurat.pdf',
                'file_path' => 'file/sop_penanganan_keadaan_darurat.pdf',
                'ukuran_file' => '2.8 MB',
                'role_akses_dokumen' => 'manager',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_dokumen' => 'Formulir Surat Pernyataan',
                'deskripsi_dokumen' => 'Surat pernyataan resmi untuk kelengkapan administrasi kepegawaian.',
                'nama_file' => 'SURAT_PERNYATAAN.pdf',
                'file_path' => 'file/SURAT_PERNYATAAN.pdf',
                'ukuran_file' => '800 KB',
                'role_akses_dokumen' => 'all',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_dokumen' => 'Jadwal Shift Bulanan - Juni 2026',
                'deskripsi_dokumen' => 'Daftar jadwal dinas dan rotasi shift karyawan untuk bulan depan.',
                'nama_file' => 'jadwal_shift_bulanan_juni_2026.pdf',
                'file_path' => 'file/jadwal_shift_bulanan_juni_2026.pdf',
                'ukuran_file' => '1.5 MB',
                'role_akses_dokumen' => 'staff-admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_dokumen' => 'Kebijakan Privasi Perusahaan',
                'deskripsi_dokumen' => 'Dokumen pembaruan kebijakan privasi dan perlindungan data karyawan.',
                'nama_file' => 'kebijakan_privasi_perusahaan.pdf',
                'file_path' => 'file/kebijakan_privasi_perusahaan.pdf',
                'ukuran_file' => '3.1 MB',
                'role_akses_dokumen' => 'all',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_dokumen' => 'Data Rekap Absensi Tahunan',
                'deskripsi_dokumen' => 'Dokumen rekapitulasi kehadiran seluruh karyawan selama tahun berjalan.',
                'nama_file' => 'data_rekap_absensi_tahunan.pdf',
                'file_path' => 'file/data_rekap_absensi_tahunan.pdf',
                'ukuran_file' => '5.2 MB',
                'role_akses_dokumen' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_dokumen' => 'Evaluasi Kinerja Q1',
                'deskripsi_dokumen' => 'Hasil evaluasi KPI dan pencapaian target operasional departemen.',
                'nama_file' => 'evaluasi_kinerja_q1.pdf',
                'file_path' => 'file/evaluasi_kinerja_q1.pdf',
                'ukuran_file' => '2.4 MB',
                'role_akses_dokumen' => 'manager',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_dokumen' => 'Panduan Penggunaan Sistem AP3',
                'deskripsi_dokumen' => 'Buku saku manual penggunaan portal sistem informasi manajemen stasiun.',
                'nama_file' => 'panduan_penggunaan_sistem_ap3.pdf',
                'file_path' => 'file/panduan_penggunaan_sistem_ap3.pdf',
                'ukuran_file' => '8.7 MB',
                'role_akses_dokumen' => 'all',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
