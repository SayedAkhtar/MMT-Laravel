<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryResponse extends Model
{
    use HasFactory;


    protected $fillable = ['query_id', 'step', 'response'];

    const generateQuery = 1;
    const doctorResponse = 2;
    const documentForVisa = 3;
    const payment = 4;
    const ticketsAndVisa = 5;

    const queryConfirmed = 10;

    const stepOneFields = [
        'history' => 'nullable | string',
        'country' => 'nullable | string',
        'medical_report.*' => 'nullable | string',
        'passport.*' => 'nullable | string',
    ];

    const stepTwoFields = [
        'doctor' => 'string',
        'patient.*' => 'nullable | string',
    ];

    const stepThreeFields = [
        'passport' => 'required | string',
        'attendant_passport.*' => 'string',
        'country' => 'required | string',
        'city' => 'required | string'
    ];

    const stepFourFields = [
        'payment_id' => 'required | string'
    ];

    const stepFiveFields = [
        'tickets.*' => 'required | string',
        'visa.*' => 'required | string',
    ];


    protected $casts = [
        'response' => 'array'
    ];

    static function getNextTab($currentTab)
    {
        switch ($currentTab + 1) {
            case 1:
                return 'details';
            case 2:
                return 'doctor-review';
            case 3:
                return 'upload-medical-visa';
            case 4:
                return 'payment-required';
            case 5:
                return 'upload-ticket';
            case 6:
                return 'coordinator';
        }
    }

}
