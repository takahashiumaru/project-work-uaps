<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->enum('gender', ['Male', 'Female']);
            $table->string('job_title')->nullable();
            $table->string('role');
            $table->string('station');
            $table->string('cluster')->nullable();
            $table->string('unit')->nullable();
            $table->string('sub_unit')->nullable();
            $table->string('status')->nullable();
            $table->string('manager')->nullable();
            $table->string('senior_manager')->nullable();
            $table->boolean('is_qantas')->default(false);
            $table->date('join_date');
            $table->string('salary')->default('0');
            $table->date('contract_start')->nullable();
            $table->date('contract_end')->nullable();
            $table->string('phone')->nullable();
            $table->string('pendidikan')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('domisili')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_nik')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('npwp')->nullable();
            $table->string('no_pas')->nullable();
            $table->date('pas_registered')->nullable();
            $table->date('pas_expired')->nullable();
            $table->string('bpjs_kesehatan')->nullable();
            $table->string('bpjs_tk')->nullable();
            $table->string('tim_number')->nullable();
            $table->date('tim_registered')->nullable();
            $table->date('tim_expired')->nullable();
            $table->string('profile_picture')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
