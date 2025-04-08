<?php

namespace Database\Seeders;

use App\Models\Incident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incident_list = [
            [
                'en' => 'None',
                'ar' => 'لا شيء',
                'fr' => 'Aucun'
            ],
            [
                'en' => 'Loss of a loved one',
                'ar' => 'فقدان شخص عزيز',
                'fr' => 'Perte d’un être cher'
            ],
            [
                'en' => 'Relationship breakup or divorce',
                'ar' => 'انفصال أو طلاق',
                'fr' => 'Rupture ou divorce'
            ],
            [
                'en' => 'Job loss or financial difficulties',
                'ar' => 'فقدان العمل أو صعوبات مالية',
                'fr' => 'Perte d’emploi ou difficultés financières'
            ],
            [
                'en' => 'Childhood trauma',
                'ar' => 'صدمة في الطفولة',
                'fr' => 'Traumatisme de l’enfance'
            ],
            [
                'en' => 'Physical or emotional abuse',
                'ar' => 'إساءة جسدية أو عاطفية',
                'fr' => 'Abus physique ou émotionnel'
            ],
            [
                'en' => 'Other',
                'ar' => 'أخرى',
                'fr' => 'Autre'
            ],
        ];

        foreach ($incident_list as $incident){
            Incident::create([
                "name" => $incident
            ]);
        }
    }
}
