<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $languages_list = array(
            "Arabic",
            "English",
            "French"
        );

        foreach ($languages_list as $language){
            Language::create([
                "name" => $language
            ]);
        }
    }
}
