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
        'proforma_invoice' => 'sometimes',
        'document_required' => 'required| bool'
    ];

    const stepThreeFields = [
        'passport' => 'required | string',
        'attendant_passport.*' => 'string',
        'country' => 'required | string',
        'city' => 'required | string',
        'from_country' => 'sometimes | string',
        'from_city' => 'sometimes | string'
    ];

    const stepFourFields = [
        'r_payment_id' => 'required | string',
        'amount' => 'sometimes',
        'response' => 'sometimes'
    ];

    const stepFiveFields = [
        'tickets.*' => 'required | string',
        'visa.*' => 'required | string',
    ];

    const availableTabs = [
        'details' => 1,
        'doctor-review' => 2,
        'upload-medical-visa' => 3,
        'payment-required' => 4,
        'upload-ticket' => 5,
        'coordinator' => 10
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

    public function parentQuery(){
        return $this->hasOne(Query::class, 'id', 'query_id');
    }

}
