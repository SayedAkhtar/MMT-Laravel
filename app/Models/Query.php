<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Query extends BaseModel
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'queries';

    /**
     * @var string[]
     */
    protected $fillable = [
        'patient_id',
        'patient_name',
        'specialization_id',
        'hospital_id',
        'doctor_id',
        'status',
        'type',
        'query_for',
        'current_step',
        'payment_required',
        'is_completed',
        'vil'
    ];
    protected static $tabs = [
        'details',
        'doctor-review',
        'upload-medical-visa',
        'payment-required',
        'upload-ticket',
        'coordinator',
    ];

    protected $with = [
        'patient'
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

    public function routeNotificationForFcm()
    {
        return $this->patient->firebase_token;
    }

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

    public function getNextStep()
    {
        if ($this->payment_required && $this->current_step == 3) {
            return QueryResponse::payment;
        }
        if (!$this->payment_required && $this->current_step == 3) {
            return QueryResponse::ticketsAndVisa;
        } 
        return $this->current_step+1;
    }

    public function getQueryHashAttribute(): string
    {
        return "MMT-" . (implode('-', str_split(Carbon::make($this->created_at)->timestamp, 5))) . "-" . str_pad($this->id, 3, "0", STR_PAD_LEFT);
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
        $response = [];
        try {
            if($step == 2){
                $this->responses->where('step', $step)->each(function($res) use (&$response) {
                    array_push($response, json_decode($res->response ?? '', true));
                });
                
            }elseif($step == 3){
                $res = $this->responses->where('step', $step)->first()->response ?? '';
                if(!empty($res)){
                    $response = json_decode($res ?? '', true) ?? [];
                    $response['vil'] = json_decode($this->find($this->id)->vil);
                }
            }
            else{
                $res = $this->responses->where('step', $step)->first()->response ?? '';
                if(!empty($res)){
                    $response = json_decode($res ?? '', true) ?? [];
                }
            }
        } catch (\Exception $e) {
            throw (new \Exception("Response for the step not found"));
        }
        return $response;
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
        return $this->hasOne(PatientFamilyDetails::class, 'id', 'patient_family_id');
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

    public function getVil(){
        return $this->vil;
    }
}
