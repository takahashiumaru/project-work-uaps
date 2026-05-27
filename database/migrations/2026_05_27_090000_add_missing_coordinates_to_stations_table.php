<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            if (! Schema::hasColumn('stations', 'code')) {
                $table->string('code', 3)->nullable()->unique()->after('id');
            }

            if (! Schema::hasColumn('stations', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('is_active');
            }

            if (! Schema::hasColumn('stations', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            if (Schema::hasColumn('stations', 'longitude')) {
                $table->dropColumn('longitude');
            }

            if (Schema::hasColumn('stations', 'latitude')) {
                $table->dropColumn('latitude');
            }
        });
    }
};
