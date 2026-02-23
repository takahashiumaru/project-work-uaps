<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('overtimes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link ke Staff
        $table->date('date');           // Tanggal Lembur
        $table->integer('duration');    // Durasi (Jam)
        $table->string('title');        // Judul Kegiatan
        $table->text('description');    // Deskripsi Detail
        $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
        $table->string('approved_by')->nullable(); // Nama Leader yang ACC
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};
