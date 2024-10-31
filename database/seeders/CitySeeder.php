<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $csv = file(public_path('data/cities.csv'));
        $cities = [];

        foreach ($csv as $i => $row) {
            if ($i == 0) {
                continue;
            }

            $city = str_getcsv($row, ';');

            $cities[] = [
                'city_code' => $city[0],
                'city_name' => $city[1],
            ];
        }

        City::insert($cities);
    }
}
