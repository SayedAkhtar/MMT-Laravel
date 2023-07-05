<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class Query extends BaseModel
{

    /**
     * @var string
     */
    protected $table = 'queries';

    /**
     * @var string[]
     */
    protected $fillable = [
        'patient_id',
        'patient_family_id',
        'specialization_id',
        'hospital_id',
        'doctor_id',
        'status',
        'type',
        'current_step',
        'payment_required',
        'is_completed',
    ];
    protected static $tabs = [
        'details',
        'doctor-review',
        'upload-medical-visa',
        'payment-required',
        'upload-ticket',
        'coordinator',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'patient_id' => 'integer',
        'patient_family_id' => 'integer',
        'specialization_id' => 'integer',
        'hospital_id' => 'integer',
        'doctor_id' => 'integer',
        'status' => 'string',
        'type' => 'integer',
        'current_step' => 'integer',
        'payment_required' => 'boolean',
        'is_completed' => 'boolean',
    ];

    const TYPE_QUERY = 1;
    const TYPE_MEDICAL_VISA = 2;

    // public function newQuery($excludeDeleted = true) {
    //     // if(Auth::user()->user_type != User::TYPE_ADMIN || Auth::user()->user_type != User::TYPE_HCF){
    //     //     return parent::newQuery($excludeDeleted)
    //     //     ->where('patient_id', '=', Auth::id());
    //     // }
        
    // }


    public static function getTabs()
    {
        return self::$tabs;
    }

    public function getQueryTypeAttribute(): string
    {
        if ($this->type == static::TYPE_QUERY) {
            return "Medical Query";
        } else {
            return "Visa Query";
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function responses()
    {
        return $this->hasMany(QueryResponse::class, 'query_id', 'id');
    }

    public function getStepResponse(int $step): array
    {
        try {
            $response = $this->responses->where('step', $step)->first()->response ?? '';
            return json_decode($response, true) ?? [];
        } catch (\Exception $e) {
            throw (new \Exception("Response for the step not found"));
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient()
    {
        return $this->hasOne(User::class, 'id', 'patient_id');
//        return $this->hasOneThrough(User::class, PatientDetails::class, 'user_id', 'id', 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function patientFamily()
    {
        return $this->hasOne(User::class, 'id', 'patient_family_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function specialization()
    {
        return $this->hasOne(Specialization::class, 'id', 'specialization_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function hospital()
    {
        return $this->hasOne(Hospital::class, 'id', 'hospital_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'id', 'doctor_id');
    }
}
