<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('https://raw.githubusercontent.com/nshntarora/Indian-Cities-JSON/master/cities.json');
        $country = Country::where('short_form', '=', 'IN')->first();
        DB::table('cities')->truncate();
        foreach (json_decode($response->body(), true) as $value) {
            try {
                City::create([
                    'name' => $value['name'],
                    'short_form' => Str::slug($value['name']),
                    'state_id' => State::where('name', '=', $value['state'])->first()->id,
                    'country_id' => $country->id,
                ]);
            } catch (\Exception $e) {

            }

        }
    }
}
