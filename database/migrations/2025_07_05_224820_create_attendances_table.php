<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id(); // Kolom ID utama, auto-increment
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Kunci asing ke tabel users

            $table->dateTime('check_in_time')->nullable(); // Waktu check-in
            $table->dateTime('check_out_time')->nullable(); // Waktu check-out

            // Opsional: Kolom untuk mencatat tanggal saat absensi
            $table->string('check_in_photo')->nullable();
            $table->string('check_out_photo')->nullable();

            // Opsional: Kolom untuk mencatat lokasi (latitude dan longitude)
            $table->string('check_in_latitude')->nullable();
            $table->string('check_in_longitude')->nullable();
            $table->string('check_out_latitude')->nullable();
            $table->string('check_out_longitude')->nullable();

            // Opsional: Kolom untuk mencatat IP Address saat absensi
            $table->string('check_in_ip')->nullable();
            $table->string('check_out_ip')->nullable();

            // Opsional: Kolom untuk catatan tambahan
            $table->text('check_in_notes')->nullable();
            $table->text('check_out_notes')->nullable();

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
