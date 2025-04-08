<?php

namespace Database\Seeders;

use App\Models\Symptom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $symptom_list = [
            ['en' => 'None', 'ar' => 'لا شيء', 'fr' => 'Aucun'],
            ['en' => 'Persistent sadness or low mood', 'ar' => 'حزن مستمر أو مزاج منخفض', 'fr' => 'Tristesse persistante ou humeur basse'],
            ['en' => 'Anxiety or excessive worry', 'ar' => 'قلق أو قلق مفرط', 'fr' => 'Anxiété ou inquiétude excessive'],
            ['en' => 'Panic attacks', 'ar' => 'نوبات الهلع', 'fr' => 'Attaques de panique'],
            ['en' => 'Hallucinations or delusions', 'ar' => 'هلوسة أو أوهام', 'fr' => 'Hallucinations ou délires'],
            ['en' => 'Suicidal thoughts', 'ar' => 'أفكار انتحارية', 'fr' => 'Pensées suicidaires'],
            ['en' => 'Other', 'ar' => 'أخرى', 'fr' => 'Autre'],
        ];

        foreach ($symptom_list as $symptom){
            Symptom::create([
                "name" => $symptom
            ]);
        }
    }
}
