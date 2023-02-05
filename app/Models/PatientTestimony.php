<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class PatientTestimony extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'patient_testimonies';

    /**
     * @var string[]
     */
    protected $fillable = [
        'patient_id',
        'hospital_id',
        'doctor_id',
        'description',
        'images',
        'videos',
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
        'patient_id' => 'integer',
        'hospital_id' => 'integer',
        'doctor_id' => 'integer',
        'description' => 'string',
        'images' => 'json',
        'videos' => 'json',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function doctorPatientTestimonials()
    {
        return $this->hasMany(DoctorPatientTestimonial::class, 'testimonial_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function patientTestimonyTags()
    {
        return $this->hasMany(PatientTestimonyTag::class, 'testimony_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'patient_id');
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
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }
}
