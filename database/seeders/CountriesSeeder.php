<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CountriesSeeder extends Seeder
{
    public function run()
    {
        $countryArray = array(
            'LBAK'=>array('name'=>'Akkar'),
            'LBAS'=>array('name'=>'North'),
            'LBBA'=>array('name'=>'Beirut'),
            'LBBH'=>array('name'=>'Baalbek-El Hermel'),
            'LBBI'=>array('name'=>'Bekaa'),
            'LBJA'=>array('name'=>'South'),
            'LBJL'=>array('name'=>'Mount Lebanon'),
            'LBNA'=>array('name'=>'El Nabatieh'),
        );

        foreach ($countryArray as $key => $country){
            Country::create([
                'name' => ucwords(strtolower($country['name'])) ,
                'iso' => $key,
            ]);
        }
    }
}
