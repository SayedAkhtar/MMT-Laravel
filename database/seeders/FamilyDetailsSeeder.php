<?php

namespace Database\Seeders;

use App\Models\PatientFamily;
use App\Models\PatientFamilyDetails;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class FamilyDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($user_id = null)
    {
        $faker = Factory::create();
        $user = User::all()->pluck('id');
        $family = [
            "patient_id" => $user_id?$user_id:$user->random(),
            "name" => $faker->name,
            "phone" => $faker->phoneNumber,
            "relationship" => $faker->randomElement(['nephew', 'niece', 'mother', 'father']),
            "dob" => $faker->dateTime,
            "gender" => $faker->randomElement(['male', 'female']),
            "geo_location" => $faker->latitude.','. $faker->longitude,
            "treatment_country" => $faker->country,
            "medical_info" => $faker->realText,
            "is_active" => true
        ];
        PatientFamilyDetails::create($family);
    }
}