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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('safety_management_system')->nullable();
            $table->string('human_factors')->nullable();
            $table->string('ramp_safety_airside_safety')->nullable();
            $table->string('dangerous_goods_regulations')->nullable();
            $table->string('aviation_security_awareness')->nullable();
            $table->string('airport_emergency_plan')->nullable();
            $table->string('ground_support_equipment_operation')->nullable();
            $table->string('basic_first_aid')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
