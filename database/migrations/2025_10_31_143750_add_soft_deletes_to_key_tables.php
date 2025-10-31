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
        // Add soft deletes to users table
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to doctors table
        Schema::table('doctors', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to patients table
        Schema::table('patients', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to blogs table
        Schema::table('blogs', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
