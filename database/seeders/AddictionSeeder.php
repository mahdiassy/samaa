<?php

namespace Database\Seeders;

use App\Models\Addiction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddictionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addiction_list = [
            [
                'en' => 'No',
                'ar' => 'لا',
                'fr' => 'Non'
            ],
            [
                'en' => 'Yes, alcohol',
                'ar' => 'نعم، الكحول',
                'fr' => 'Oui, alcool'
            ],
            [
                'en' => 'Yes, drugs',
                'ar' => 'نعم، المخدرات',
                'fr' => 'Oui, drogues'
            ],
            [
                'en' => 'Yes, both alcohol and drugs',
                'ar' => 'نعم، الكحول والمخدرات معًا',
                'fr' => 'Oui, alcool et drogues'
            ],
        ];

        foreach ($addiction_list as $addiction){
            Addiction::create([
                "name" => $addiction
            ]);
        }
    }
}
