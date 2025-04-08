<?php

namespace Database\Seeders;

use App\Models\Nervous;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NervousSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nervous_list = [
            ['en' => 'None', 'ar' => 'لا شيء', 'fr' => 'Aucun'],
            ['en' => 'Epilepsy or seizures', 'ar' => 'الصرع أو النوبات', 'fr' => 'Épilepsie ou crises'],
            ['en' => 'Multiple sclerosis (MS)', 'ar' => 'التصلب المتعدد', 'fr' => 'Sclérose en plaques'],
            ['en' => 'Parkinson’s disease', 'ar' => 'مرض باركنسون', 'fr' => 'Maladie de Parkinson'],
            ['en' => 'Stroke', 'ar' => 'السكتة الدماغية', 'fr' => 'Accident vasculaire cérébral'],
            ['en' => 'Alzheimer’s or dementia', 'ar' => 'الزهايمر أو الخرف', 'fr' => 'Alzheimer ou démence'],
            ['en' => 'Tension Headaches', 'ar' => 'صداع التوتر', 'fr' => 'Maux de tête de tension'],
            ['en' => 'Migraine', 'ar' => 'الصداع النصفي', 'fr' => 'Migraine'],
            ['en' => 'Amyotrophic Lateral Sclerosis (ALS, Lou Gehrig’s Disease)', 'ar' => 'التصلب الجانبي الضموري', 'fr' => 'Sclérose latérale amyotrophique (SLA)'],
            ['en' => 'Peripheral Neuropathy', 'ar' => 'الاعتلال العصبي المحيطي', 'fr' => 'Neuropathie périphérique'],
            ['en' => 'Brain Tumors', 'ar' => 'أورام الدماغ', 'fr' => 'Tumeurs cérébrales'],
            ['en' => 'Insomnia', 'ar' => 'الأرق', 'fr' => 'Insomnie'],
            ['en' => 'Essential Tremor', 'ar' => 'الرعاش الأساسي', 'fr' => 'Tremblement essentiel'],
            ['en' => 'Other', 'ar' => 'أخرى', 'fr' => 'Autre'],
        ];

        foreach ($nervous_list as $nervous){
            Nervous::create([
                "name" => $nervous
            ]);
        }
    }
}
