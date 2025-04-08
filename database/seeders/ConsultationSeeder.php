<?php

namespace Database\Seeders;

use App\Models\Consultation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consultation_list = [
            [
                'en' => 'No, never',
                'ar' => 'لا، أبدًا',
                'fr' => 'Non, jamais'
            ],
            [
                'en' => 'Yes, currently receiving therapy',
                'ar' => 'نعم، أتلقى العلاج حاليًا',
                'fr' => 'Oui, je suis actuellement en thérapie'
            ],
            [
                'en' => 'Yes, in the past but not currently',
                'ar' => 'نعم، في السابق ولكن ليس حاليًا',
                'fr' => 'Oui, dans le passé mais pas actuellement'
            ],
        ];

        foreach ($consultation_list as $consultation){
            Consultation::create([
                "name" => $consultation
            ]);
        }
    }
}
