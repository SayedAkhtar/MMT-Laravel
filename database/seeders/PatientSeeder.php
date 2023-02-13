<?php

namespace Database\Seeders;

use App\Models\PatientDetails;
use App\Models\Specialization;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    protected \Faker\Generator $faker;
    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try{
            $user = User::factory()->create();
            $details = [
                "user_id" => $user->id,
                "speciality" => Specialization::all()->pluck('id')->random(),
                "treatment_country" => $this->faker->country,
                "medical_ifo" => $this->faker->realText,
                "is_active" => true
            ];
            PatientDetails::create($details);
            $this->callWith(FamilyDetailsSeeder::class, ['user_id' => $user->id]);
            DB::commit();
        }catch (\Exception $e){
            echo "Failed ".$e->getMessage();
            DB::rollBack();
        }
    }
}