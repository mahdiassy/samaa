<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([

            CountriesSeeder::class,
            LanguageSeeder::class,
            TherapeuticSeeder::class,
            DiseaseSeeder::class,
            PsychologicalSeeder::class,
            AddictionSeeder::class,
            ConsultationSeeder::class,
            IncidentSeeder::class,
            NervousSeeder::class,
            SymptomSeeder::class,
            PermissionsSeeder::class,
            TherapySeeder::class,
            //BlogSeeder::class,
        ]);
    }
}
