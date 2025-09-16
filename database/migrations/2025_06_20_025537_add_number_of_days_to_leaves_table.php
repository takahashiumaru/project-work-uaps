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
    Schema::table('leaves', function (Blueprint $table) {
        $table->integer('number_of_days')->after('end_date')->nullable(); // Atau ->default(0);
    });
}

public function down()
{
    Schema::table('leaves', function (Blueprint $table) {
        $table->dropColumn('number_of_days');
    });
}
};
