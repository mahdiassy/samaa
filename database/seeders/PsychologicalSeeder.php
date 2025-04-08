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
        $psychologicals_list = [
            ['en' => 'None', 'ar' => 'لا شيء', 'fr' => 'Aucun'],
            ['en' => 'Depression', 'ar' => 'الاكتئاب', 'fr' => 'Dépression'],
            ['en' => 'Autism', 'ar' => 'التوحد', 'fr' => 'Autisme'],
            ['en' => 'Anxiety disorder', 'ar' => 'اضطراب القلق', 'fr' => 'Trouble anxieux'],
            ['en' => 'Bipolar disorder', 'ar' => 'الاضطراب الثنائي القطب', 'fr' => 'Trouble bipolaire'],
            ['en' => 'Schizophrenia or other psychotic disorders', 'ar' => 'الفصام أو الاضطرابات الذهانية الأخرى', 'fr' => 'Schizophrénie ou autres troubles psychotiques'],
            ['en' => 'Post-traumatic stress disorder (PTSD)', 'ar' => 'اضطراب ما بعد الصدمة (PTSD)', 'fr' => 'Trouble de stress post-traumatique (TSPT)'],
            ['en' => 'Obsessive-compulsive disorder (OCD)', 'ar' => 'اضطراب الوسواس القهري (OCD)', 'fr' => 'Trouble obsessionnel compulsif (TOC)'],
            ['en' => 'Attention deficit hyperactivity disorder (ADHD)', 'ar' => 'اضطراب فرط الحركة وتشتت الانتباه (ADHD)', 'fr' => 'Trouble du déficit de l’attention avec hyperactivité (TDAH)'],
            ['en' => 'Other', 'ar' => 'أخرى', 'fr' => 'Autre'],
        ];

        foreach ($psychologicals_list as $psychological){
            Psychological::create([
                "name" => $psychological
            ]);
        }
    }
}
