<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
            // 1. CEK & BUAT KOLOM PAS (Jika Belum Ada)
            if (!Schema::hasColumn('users', 'no_pas')) {
                $table->string('no_pas', 50)->nullable()->after('email'); // Taruh setelah email biar aman
                $table->date('pas_registered')->nullable()->after('no_pas');
                $table->date('pas_expired')->nullable()->after('pas_registered');
            }

            // 2. CEK & BUAT KOLOM TIM (Jika Belum Ada)
            if (!Schema::hasColumn('users', 'tim_number')) {
                // Kita taruh di akhir atau setelah pas_expired (jika baru dibuat)
                $table->string('tim_number', 50)->nullable()->after('password'); 
            }
            
            if (!Schema::hasColumn('users', 'tim_expired')) {
                $table->date('tim_expired')->nullable()->after('tim_number');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $columns = ['no_pas', 'pas_registered', 'pas_expired', 'tim_number', 'tim_expired'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};