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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->notNullable();
            $table->boolean('is_active')->default(true);
            $table->date('date')->notNullable();
            $table->string('shift_id', 10)->notNullable();
            $table->primary('id');
            $table->unique(['user_id', 'date']);
            $table->foreign('shift_id')->references('id')->on(table: 'shifts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
