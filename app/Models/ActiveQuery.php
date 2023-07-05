<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class ActiveQuery extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'active_queries';

    /**
     * @var string[]
     */
    protected $fillable = [
        'query_id',
        'doctor_response',
        'patient_response',
        'attendant_passport',
        'tickets',
        'medical_visa',
        'is_payment_required',
        'is_payment_done',
        'country',
        'state',
        'is_active',
        'created_at',
        'updated_at',
        'added_by',
        'updated_by',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'query_id' => 'integer',
        'doctor_response' => 'string',
        'patient_response' => 'string',
        'attendant_passport' => 'string',
        'tickets' => 'string',
        'medical_visa' => 'string',
        'is_payment_required' => 'boolean',
        'is_payment_done' => 'boolean',
        'country' => 'string',
        'state' => 'string',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];
}
