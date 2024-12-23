<?php

namespace Database\Seeders;

use App\Models\Therapeutic_area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TherapeuticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $therapeutic_list = array(
            "None",
            "Cardiovascular",
            "Nephrology"
        );

        foreach ($therapeutic_list as $therapeutic){
            Therapeutic_area::create([
                "name" => $therapeutic
            ]);
        }
    }
}
