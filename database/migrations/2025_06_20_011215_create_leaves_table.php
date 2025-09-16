<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_leaves_table.php
public function up()
{
    Schema::create('leaves', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('leave_type');
        $table->date('start_date');
        $table->date('end_date');
        $table->text('reason')->nullable();
        $table->string('status')->default('pending'); // pending, approved, rejected
        $table->string('document')->nullable(); // surat sakit (jika ada)
        $table->timestamps();
    });
}

};
