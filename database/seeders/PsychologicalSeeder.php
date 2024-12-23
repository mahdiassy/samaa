<?php

namespace Database\Seeders;

use App\Models\Psychological;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PsychologicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $psychologicals_list = array(
            "None",
            "Depression",
            "Sleep Disorder",
            "Autism",
            "Obsessive-Compulsive Disorder (OCD)"
        );

        foreach ($psychologicals_list as $psychological){
            Psychological::create([
                "name" => $psychological
            ]);
        }
    }
}
