<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class PatientFamilyDetails extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'patient_family_details';

    /**
     * @var string[]
     */
    protected $fillable = [
        'patient_id',
        'name',
        'phone',
        'relationship',
        'dob',
        'gender',
        'geo_location',
        'treatment_country',
        'speciality',
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
        'name' => 'string',
        'phone' => 'string',
        'relationship' => 'string',
        'dob' => 'datetime',
        'gender' => 'string',
        'geo_location' => 'json',
        'treatment_country' => 'string',
        'medical_info' => 'string',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function patientFamilies()
    {
        return $this->hasMany(PatientFamily::class, 'family_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    public function specialization()
    {
        return $this->hasOne(Specialization::class, 'id', 'speciality');
    }
}
