<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;
    protected $fillable = ['doctor_id', 'day', 'time', 'imestamp'];
    protected $visible = ['day', 'time', 'timestamp'];

    public static function getTimestamp($time){
        $carbonTime = Carbon::parse($time);

        // If the time is PM and not 12 PM, add 12 hours to convert it to 24-hour format
        if ($carbonTime->format('A') === 'PM' && $carbonTime->format('g') != 12) {
            $carbonTime->addHours(12);
        };
        return $carbonTime->timestamp;
    }
}
