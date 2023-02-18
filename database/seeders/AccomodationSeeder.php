<?php

namespace Database\Seeders;

use App\Models\Accommodation;
use Illuminate\Database\Seeder;

class AccomodationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Accommodation::create([
            'name' => "New Hotel",
            'address' => "52, Popyye Vally, Dreamland - 11102",
            'images' => "https://www.tajhotels.com/content/dam/luxury/hotels/Taj_Mahal_Delhi/images/new-images/Taj-Mahal-New-Delhi-Facade.jpg/_jcr_content/renditions/cq5dam.web.1280.1280.jpeg",
            'type' => 1,
            'geo_location' => "28.5058058,77.0679584",
            'is_active' => true,
            'created_at' => now(),
            'updated_at' =>now(),
            'added_by' => 4,
            'updated_by' => null,
        ]);
    }
}