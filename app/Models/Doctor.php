<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;

class Doctor extends BaseModel
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'doctors';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'start_of_service',
        'awards',
        'description',
        'designation_id',
        'qualification_id',
        'faq',
        'time_slots',
        'price',
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
    public function qualification()
    {
        return $this->hasOne(Qualification::class, 'id', 'qualification_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function designation()
    {
        return $this->hasOne(Designation::class, 'id', 'designation_id');
    }

    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class, 'doctor_hospitals');
    }
}
