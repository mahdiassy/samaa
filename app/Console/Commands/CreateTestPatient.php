<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Patient;
use App\Models\PatientDisease;
use App\Models\Therapeutic_area;
use App\Models\Addiction;
use App\Models\Consultation;
use Illuminate\Support\Facades\Hash;

class CreateTestPatient extends Command
{
    protected $signature = 'create:test-patient';
    protected $description = 'Create a test patient account for testing';

    public function handle()
    {
        $email = 'patient@test.com';

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error('Test patient already exists with email: ' . $email);
            $this->info('Email: patient@test.com');
            $this->info('Password: password123');
            return;
        }

        // Create User
        $user = new User();
        $user->name = 'Test Patient';
        $user->email = $email;
        $user->password = Hash::make('password123');
        $user->save();
        $user->assignRole('Patient');

        // Create Patient
        $patient = new Patient();
        $patient->user_id = $user->id;
        $patient->first_name = 'Test';
        $patient->last_name = 'Patient';
        $patient->birthday = '1990-01-01';
        $patient->phone = '+1234567890';
        $patient->address = null;
        $patient->country_id = 1; // Assuming ID 1 exists
        $patient->language_id = 1; // Assuming ID 1 exists
        $patient->gender = 'male';
        $patient->open_description = 'Test patient account for development';
        $patient->twitter = null;
        $patient->facebook = null;
        $patient->instagram = null;
        $patient->image = null;
        $patient->save();

        // Add therapeutic area (if exists)
        $therapeuticArea = Therapeutic_area::first();
        if ($therapeuticArea) {
            PatientDisease::create([
                'patient_id' => $patient->id,
                'diseasable_id' => $therapeuticArea->id,
                'diseasable_type' => get_class($therapeuticArea),
                'medications' => null,
            ]);
        }

        // Add addiction (if exists)
        $addiction = Addiction::first();
        if ($addiction) {
            PatientDisease::create([
                'patient_id' => $patient->id,
                'diseasable_id' => $addiction->id,
                'diseasable_type' => get_class($addiction),
                'medications' => null,
            ]);
        }

        // Add consultation (if exists)
        $consultation = Consultation::first();
        if ($consultation) {
            PatientDisease::create([
                'patient_id' => $patient->id,
                'diseasable_id' => $consultation->id,
                'diseasable_type' => get_class($consultation),
                'medications' => null,
            ]);
        }

        $this->info('✅ Test patient account created successfully!');
        $this->info('');
        $this->info('📧 Email: patient@test.com');
        $this->info('🔑 Password: password123');
        $this->info('');
        $this->info('You can now login at: ' . url('/login'));
    }
}
