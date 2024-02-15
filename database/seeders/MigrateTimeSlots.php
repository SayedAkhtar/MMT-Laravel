<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateTimeSlots extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        TimeSlot::truncate();
        $doctors = Doctor::all();
        $update = [];
        foreach ($doctors as $doctor) {
            $time_slots = $doctor->time_slots;
            if (!empty($time_slots)) {
                $time_slots = json_decode($time_slots);
                foreach ($time_slots as $day => $times) {
                    foreach ($times as $time) {
                        $update[] = [
                            'doctor_id' => $doctor->id,
                            'day' => $day,
                            'time' => $time,
                            'timestamp' => TimeSlot::getTimestamp($time)
                        ];
                    }
                }
            }
        }
        TimeSlot::insert($update);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
