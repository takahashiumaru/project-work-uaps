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
        Schema::create('flight_details', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED
            $table->unsignedBigInteger('flight_id')->notNullable();
            $table->unsignedBigInteger('schedule_id')->notNullable();

            $table->primary('id');

            $table->foreign('flight_id')->references('id')->on('flights');
            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_details');
    }
};
