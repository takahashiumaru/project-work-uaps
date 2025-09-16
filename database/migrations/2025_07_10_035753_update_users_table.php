<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('job_title')->nullable()->after('role');
            $table->string('cluster')->nullable();
            $table->string('unit')->nullable();
            $table->string('sub_unit')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('manager')->nullable();
            $table->string('senior_manager')->nullable();
            $table->string('status')->nullable();
            $table->string('alamat')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('domisili')->nullable();
            $table->string('kota_domisili')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('bpjs_tk')->nullable();
            $table->string('bpjs_kesehatan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'job_title', 'cluster', 'unit', 'sub_unit',
                'tanggal_lahir', 'manager', 'senior_manager', 'status',
                'alamat', 'pendidikan', 'domisili', 'kota_domisili', 'no_hp',
                'bpjs_tk', 'bpjs_kesehatan'
            ]);
        });
    }
};
