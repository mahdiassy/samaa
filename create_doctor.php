<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

// Create doctor user
$user = User::firstOrCreate(
    ['email' => 'doctor@samaa.com'],
    [
        'name' => 'Dr. John Smith',
        'password' => Hash::make('doctor123'),
        'email_verified_at' => now(),
    ]
);

// Assign Doctor role
$user->assignRole('Doctor');

// Create doctor profile
$doctor = Doctor::firstOrCreate(
    ['user_id' => $user->id],
    [
        'first_name' => 'John',
        'last_name' => 'Smith',
    ]
);

echo "✓ Doctor account created successfully!\n";
echo "Email: doctor@samaa.com\n";
echo "Password: doctor123\n";
echo "Role: Doctor\n";
