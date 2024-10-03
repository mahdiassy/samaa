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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->references('id')->on('patients')->cascadeOnDelete();
            //$table->foreignId('available_id')->references('id')->on('availabilities')->cascadeOnDelete();
            $table->foreignId('available_id')
                ->constrained('availabilities')
                ->cascadeOnDelete();
            $table->string('status');
            $table->string('reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
