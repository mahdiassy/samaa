<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Check if an index exists on a table
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
        return count($indexes) > 0;
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Patients table indexes
        Schema::table('patients', function (Blueprint $table) {
            if (!$this->indexExists('patients', 'patients_user_id_index')) {
                $table->index('user_id');
            }
            if (!$this->indexExists('patients', 'patients_country_id_index')) {
                $table->index('country_id');
            }
            if (!$this->indexExists('patients', 'patients_language_id_index')) {
                $table->index('language_id');
            }
            if (!$this->indexExists('patients', 'patients_first_name_last_name_index')) {
                $table->index(['first_name', 'last_name']);
            }
        });

        // Doctors table indexes
        Schema::table('doctors', function (Blueprint $table) {
            if (!$this->indexExists('doctors', 'doctors_user_id_index')) {
                $table->index('user_id');
            }
            if (!$this->indexExists('doctors', 'doctors_first_name_last_name_index')) {
                $table->index(['first_name', 'last_name']);
            }
        });

        // Bookings table indexes
        Schema::table('bookings', function (Blueprint $table) {
            if (!$this->indexExists('bookings', 'bookings_patient_id_index')) {
                $table->index('patient_id');
            }
            if (!$this->indexExists('bookings', 'bookings_available_id_index')) {
                $table->index('available_id');
            }
            if (!$this->indexExists('bookings', 'bookings_status_index')) {
                $table->index('status');
            }
            if (!$this->indexExists('bookings', 'bookings_patient_id_status_index')) {
                $table->index(['patient_id', 'status']);
            }
            if (!$this->indexExists('bookings', 'bookings_created_at_index')) {
                $table->index('created_at');
            }
        });

        // Availabilities table indexes
        Schema::table('availabilities', function (Blueprint $table) {
            if (!$this->indexExists('availabilities', 'availabilities_doctor_id_index')) {
                $table->index('doctor_id');
            }
            if (!$this->indexExists('availabilities', 'availabilities_time_index')) {
                $table->index('time');
            }
            if (!$this->indexExists('availabilities', 'availabilities_doctor_id_time_index')) {
                $table->index(['doctor_id', 'time']);
            }
        });

        // Therapies table indexes
        Schema::table('therapies', function (Blueprint $table) {
            if (!$this->indexExists('therapies', 'therapies_user_id_index')) {
                $table->index('user_id');
            }
            if (!$this->indexExists('therapies', 'therapies_album_id_index')) {
                $table->index('album_id');
            }
            if (!$this->indexExists('therapies', 'therapies_name_index')) {
                $table->index('name');
            }
        });

        // Blogs table indexes
        Schema::table('blogs', function (Blueprint $table) {
            if (!$this->indexExists('blogs', 'blogs_user_id_index')) {
                $table->index('user_id');
            }
            if (!$this->indexExists('blogs', 'blogs_created_at_index')) {
                $table->index('created_at');
            }
        });

        // Feedbacks table indexes
        Schema::table('feedbacks', function (Blueprint $table) {
            if (!$this->indexExists('feedbacks', 'feedbacks_date_index')) {
                $table->index('date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['country_id']);
            $table->dropIndex(['language_id']);
            $table->dropIndex(['first_name', 'last_name']);
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['first_name', 'last_name']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['patient_id']);
            $table->dropIndex(['available_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['patient_id', 'status']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('availabilities', function (Blueprint $table) {
            $table->dropIndex(['doctor_id']);
            $table->dropIndex(['time']);
            $table->dropIndex(['doctor_id', 'time']);
        });

        Schema::table('therapies', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['album_id']);
            $table->dropIndex(['name']);
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });
    }
};
