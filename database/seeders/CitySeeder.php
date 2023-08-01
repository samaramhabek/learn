<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {      $country= Country::where('name','Syrian Arab Republic')->first();

        City::create(['country_id' => $country->id, 'name' => 'aleppo','homs','hama']);
      
    }
}
