<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $gallery = [];
        foreach (range(1, 10) as $index){
            $gallery[]=$faker->imageUrl;
        }
        $hospital = [
            'name' => $faker->company,
            'address' => $faker->address,
            'description' => $faker->realTextBetween(160, 500),
            'geo_location' => $faker->latitude.','.$faker->longitude,
            'logo' => $faker->imageUrl,
            'images' => $gallery
        ];
        Hospital::create($hospital);
    }
}