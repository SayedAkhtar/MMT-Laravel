<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use App\Traits\OnlyActive;
use App\Traits\HasTranslations;

class Doctor extends BaseModel
{
    use HasRecordOwnerProperties, OnlyActive, HasTranslations;

    /**
     * @var string
     */
    protected $table = 'doctors';
    public $translatable = ['awards', 'description', 'faq'];
    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'start_of_service',
        'awards',
        'description',
        'faq',
        'time_slots',
        'price',
        'state_id',
        'city_id',
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
        'user_id' => 'integer',
        'start_of_service' => 'datetime',
        'awards' => 'string',
        'description' => 'string',
        'designation_id' => 'string',
        'qualification_id' => 'integer',
        'faq' => 'array',
        'time_slots' => 'string',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function doctorPatientTestimonials()
    {
        return $this->hasMany(DoctorPatientTestimonial::class, 'doctor_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function doctorTags()
    {
        return $this->hasMany(DoctorTag::class, 'doctor_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'doctor_specializations');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function doctorHospitals()
    {
        return $this->hasMany(DoctorHospital::class, 'doctor_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function doctorTreatments()
    {
        return $this->hasMany(DoctorTreatment::class, 'doctor_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function qualifications()
    {
        return $this->belongsToMany(Qualification::class,'doctor_qualification');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function designations()
    {
        return $this->belongsToMany(Designation::class, 'designations_doctor');
    }

    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class, 'doctor_hospitals');
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
