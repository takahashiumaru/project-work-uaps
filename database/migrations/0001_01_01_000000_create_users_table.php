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
            $table->string('role');
            $table->string('station');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->enum('gender', ['Male','Female']);
            $table->string('password');
            $table->date('join_date');
            $table->date('contract_start')->nullable();
            $table->date('contract_end')->nullable();
            $table->date('pas_registered')->nullable();
            $table->date('pas_expired')->nullable();
            $table->string('salary')->default('0');
            $table->string('profile_picture')->nullable();
            $table->boolean('is_qantas')->default(false);
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

