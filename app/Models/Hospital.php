<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Hospital extends Model implements HasMedia
{
    use HasRecordOwnerProperties, InteractsWithMedia;

    /**
     * @var string
     */
    protected $table = 'hospitals';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'address',
        'description',
        'geo_location',
        'logo',
        'images',
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
        'name' => 'string',
        'address' => 'string',
        'description' => 'string',
        'geo_location' => 'json',
        'logo' => 'string',
        'images' => 'json',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function queries()
    {
        return $this->belongsTo(Query::class, 'hospital_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function patientTestimony()
    {
        return $this->belongsTo(PatientTestimony::class, 'hospital_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function hospitalTreatments()
    {
        return $this->hasMany(HospitalTreatment::class, 'hospital_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function accreditationHospitals()
    {
        return $this->hasMany(AccreditationHospital::class, 'hospital_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function doctorHospitals()
    {
        return $this->hasMany(DoctorHospital::class, 'hospital_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function hospitalTags()
    {
        return $this->hasMany(HospitalTags::class, 'hospital_id', 'id');
    }
}