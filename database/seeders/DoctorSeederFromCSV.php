<?php

namespace Database\Seeders;

use App\Models\Designation;
use App\Models\Doctor;
use App\Models\Qualification;
use App\Models\Specialization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeederFromCSV extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(__DIR__ . '/doctors.json');
        $json_data = json_decode($json, true);
        $faker = \Faker\Factory::create('en_IN');
        // dump($json_data);
        foreach ($json_data as $json) {

            // dump($doctor_specialization);
            $user = User::where('name', $json['Name'])->first();
            if (empty($user)) {
                DB::beginTransaction();
                try {
                    $designation = Designation::where('name', $json['Designation'])->first();
                    if ($designation == null) {
                        $designation = Designation::create([
                            'name' => $json['Designation']
                        ]);
                    }
                    $country = DB::table('countries')->where('name', $json['Country'])->first();
                    $state = DB::table('states')->where('name', $json['State'])->first();
                    $city = DB::table('cities')->where('name', $json['City'])->first();
                    if (!empty($json["Start of service"])) {
                        $json["Start of service"] = "01/01/" . $json["Start of service"];
                    } else {
                        $json["Start of service"] = "01/01/2023";
                    }
                    $date = Carbon::make($json["Start of service"])->format('m-d-Y');
                    $qualifications = explode(',', $json['Qualification']);
                    $doctor_qualification = [];
                    foreach ($qualifications as $q) {
                        $qualification = Qualification::where('name', $q)->first();
                        if ($qualification) {
                            $doctor_qualification[] = $qualification->id;
                        } else {
                            $q = Qualification::create([
                                'name' => $q
                            ]);
                            $doctor_qualification[] = $q->id;
                        }
                    }
                    $specializations = explode(',', str_replace(['&', 'and'], ',', $json['Specialization']));
                    $doctor_specialization = [];
                    foreach ($specializations as $sp) {
                        $specialization = Specialization::where('name', $sp)->first();
                        if ($specialization) {
                            $doctor_specialization[] = $specialization->id;
                        } else {
                            $s = Specialization::create([
                                'name' => $sp
                            ]);
                            $doctor_specialization[] = $s->id;
                        }
                    }
                    $user = User::create([
                        'name' => $json['Name'],
                        'email' => null,
                        'password' => bcrypt('password'),
                        'country' => $country->id,
                        'phone' => $faker->numerify('9#########'),
                        'country_code' => '+91',
                        'user_type' => 4,
                        'gender' => strtolower($json['Gender'])
                    ]);
                    $doctor = Doctor::create([
                        'user_id' => $user->id,
                        'start_of_service' => $date,
                        'description' => '<p>' . $json['About doctor'] . '</p>',
                        'awards' => $json['Awards'],
                        'price' => 15,
                        'state_id' => $state->id,
                        'city_id' => $city->id,
                    ]);
                    $doctor->qualifications()->sync($doctor_qualification);
                    $doctor->specializations()->sync($doctor_specialization);
                    $doctor->designations()->attach([$designation->id]);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    dump($e->getMessage());
                }
            }
        }
    }
}
