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
            [
                'en' => 'None',
                'ar' => 'لا شيء',
                'fr' => 'Aucun'
            ],
            [
                'en' => 'Hypertension',
                'ar' => 'ارتفاع ضغط الدم',
                'fr' => 'Hypertension'
            ],
            [
                'en' => 'Diabetes (Type 1 & Type 2)',
                'ar' => 'السكري (النوع الأول والثاني)',
                'fr' => 'Diabète (Type 1 & Type 2)'
            ],
            [
                'en' => 'Cardiovascular Disease',
                'ar' => 'أمراض القلب والأوعية الدموية',
                'fr' => 'Maladie cardiovasculaire'
            ],
            [
                'en' => 'Chronic Respiratory Diseases (Asthma, COPD)',
                'ar' => 'أمراض الجهاز التنفسي المزمنة (الربو، الانسداد الرئوي)',
                'fr' => 'Maladies respiratoires chroniques (asthme, BPCO)'
            ],
            [
                'en' => 'Arthritis (Osteoarthritis, Rheumatoid Arthritis)',
                'ar' => 'التهاب المفاصل (الفُصال العظمي، التهاب المفاصل الروماتويدي)',
                'fr' => 'Arthrite (arthrose, polyarthrite rhumatoïde)'
            ],
            [
                'en' => 'Chronic Kidney Disease (CKD)',
                'ar' => 'مرض الكلى المزمن',
                'fr' => 'Maladie rénale chronique (MRC)'
            ],
            [
                'en' => 'Cancer (Breast, Lung, Prostate, Colorectal, etc.)',
                'ar' => 'السرطان (الثدي، الرئة، البروستاتا، القولون، إلخ.)',
                'fr' => 'Cancer (sein, poumon, prostate, colorectal, etc.)'
            ],
            [
                'en' => 'Obesity',
                'ar' => 'السمنة',
                'fr' => 'Obésité'
            ],
            [
                'en' => 'Osteoporosis',
                'ar' => 'هشاشة العظام',
                'fr' => 'Ostéoporose'
            ],
            [
                'en' => 'Other',
                'ar' => 'أخرى',
                'fr' => 'Autre'
            ],
        ];

        foreach ($diseases_list as $disease) {
            Disease::create([
                'name' => $disease,
            ]);
        }
    }
}
