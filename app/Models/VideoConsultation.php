<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoConsultation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'is_active' => 'bool',
        'is_completed' => 'bool'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(PatientDetails::class);
    }

}
