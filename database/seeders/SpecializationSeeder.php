<?php

namespace Database\Seeders;

use App\Models\Accreditation;
use App\Models\Designation;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $d = [];
        if (($open = fopen(__DIR__ . '/data.csv', "r")) !== FALSE) {

            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $d[] = $data;
            }

            fclose($open);
        }
        foreach ($d as $k => $line) {
            if ($k == 0) {
                continue;
            }
            Specialization::create(['name' => $line[0], 'added_by' => User::where('email', 'admin@gmail.com')->first()->id]);
        }
        foreach ($d as $k => $line) {
            if ($k == 0) {
                continue;
            }
            Accreditation::create(['name' => $line[2], 'added_by' => User::where('email', 'admin@gmail.com')->first()->id]);
        }

        foreach ($d as $k => $line) {
            if ($k == 0) {
                continue;
            }
            Designation::create(['name' => $line[3], 'added_by' => User::where('email', 'admin@gmail.com')->first()->id]);
        }

//        Specialization::factory()->count(15)->create();
    }
}
