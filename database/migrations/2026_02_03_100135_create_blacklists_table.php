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
    Schema::create('blacklists', function (Blueprint $table) {
        $table->id();
        $table->string('nik', 20)->unique(); // Kunci utamanya NIK (KTP)
        $table->string('fullname');
        $table->text('reason'); // Contoh: "Mencuri Kabel Tembaga"
        $table->string('station'); // Kejadian di station mana
        $table->string('banned_by'); // Siapa admin yang mem-banned
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blacklists');
    }
};
