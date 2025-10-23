<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get test users (idempotent)
        User::firstOrCreate(
            ['email' => 'admin@samaa.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@samaa.com'],
            [
                'name' => 'SAMAA User',
                'password' => Hash::make('samaa123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
