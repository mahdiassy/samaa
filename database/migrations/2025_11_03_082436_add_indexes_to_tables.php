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
        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            $table->index('email'); // Fast login lookups
        });

        // Patients table indexes
        Schema::table('patients', function (Blueprint $table) {
            $table->index('user_id'); // Foreign key lookup
            $table->index('country_id'); // Filter by country
            $table->index('language_id'); // Filter by language
            $table->index(['first_name', 'last_name']); // Name searches
        });

        // Doctors table indexes
        Schema::table('doctors', function (Blueprint $table) {
            $table->index('user_id'); // Foreign key lookup
            $table->index(['first_name', 'last_name']); // Name searches
        });

        // Bookings table indexes
        Schema::table('bookings', function (Blueprint $table) {
            $table->index('patient_id'); // Patient bookings
            $table->index('available_id'); // Availability lookups
            $table->index('status'); // Filter by status (pending/approved/rejected)
            $table->index(['patient_id', 'status']); // Composite: patient's bookings by status
            $table->index('created_at'); // Recent bookings
        });

        // Availabilities table indexes
        Schema::table('availabilities', function (Blueprint $table) {
            $table->index('doctor_id'); // Doctor's availability
            $table->index('time'); // Filter by time slot
            $table->index(['doctor_id', 'time']); // Composite: doctor's schedule
        });

        // Therapies table indexes
        Schema::table('therapies', function (Blueprint $table) {
            $table->index('user_id'); // Creator lookups
            $table->index('album_id'); // Album therapies
            $table->index('name'); // Search by name
        });

        // Blogs table indexes
        Schema::table('blogs', function (Blueprint $table) {
            $table->index('user_id'); // Author lookups
            $table->index('created_at'); // Recent posts
        });

        // Feedbacks table indexes
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->index('user_id'); // User feedbacks
            $table->index('date'); // Filter by date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Users
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
        });

        // Patients
        Schema::table('patients', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['country_id']);
            $table->dropIndex(['language_id']);
            $table->dropIndex(['first_name', 'last_name']);
        });

        // Doctors
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['first_name', 'last_name']);
        });

        // Bookings
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['patient_id']);
            $table->dropIndex(['available_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['patient_id', 'status']);
            $table->dropIndex(['created_at']);
        });

        // Availabilities
        Schema::table('availabilities', function (Blueprint $table) {
            $table->dropIndex(['doctor_id']);
            $table->dropIndex(['time']);
            $table->dropIndex(['doctor_id', 'time']);
        });

        // Therapies
        Schema::table('therapies', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['album_id']);
            $table->dropIndex(['name']);
        });

        // Blogs
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
        });

        // Feedbacks
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['date']);
        });
    }
};
