<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Seeder;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diseases_list = [
            1 => [
                ['name' => 'None'],
            ],
            2 => [
                ['name' => 'Hypertension'],
                ['name' => 'Cardiac Failure'],
                ['name' => 'Heart Attacks'],
            ],
            3 => [
                ['name' => 'Glomerulonephritis'],
                ['name' => 'Hemodialysis'],
                ['name' => 'Nephrolithiasis'],
            ],
        ];

        foreach ($diseases_list as $therapeutic_area_id => $diseases) {
            foreach ($diseases as $disease) {
                Disease::create([
                    'name' => $disease['name'],
                    'therapeutic_area_id' => $therapeutic_area_id,
                ]);
            }
        }
    }
}
