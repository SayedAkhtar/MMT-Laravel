<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (file_exists(storage_path('CountryCodes.json'))) {
            $file = file_get_contents(storage_path('CountryCodes.json'));
            $countries = json_decode($file, true);
            foreach ($countries as $data) {
                Country::create([
                    'name' => $data['name'],
                    'short_form' => $data['code']
                ]);
            }
        }
    }
}
