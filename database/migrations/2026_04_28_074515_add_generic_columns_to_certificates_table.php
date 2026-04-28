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
        Schema::table('certificates', function (Blueprint $table) {
            if (!Schema::hasColumn('certificates', 'certificate_name')) {
                $table->string('certificate_name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('certificates', 'start_date')) {
                $table->date('start_date')->nullable()->after('certificate_name');
            }
            if (!Schema::hasColumn('certificates', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('certificates', 'certificate_file')) {
                $table->string('certificate_file')->nullable()->after('end_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['certificate_name', 'start_date', 'end_date', 'certificate_file']);
        });
    }
};
