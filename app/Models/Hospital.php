<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;

class Hospital extends BaseModel
{
    use HasRecordOwnerProperties;

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
    public function testimony()
    {
        return $this->hasMany(PatientTestimony::class, 'hospital_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class, 'hospital_treatments');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accreditation()
    {
        return $this->belongsToMany(Accreditation::class, 'accreditation_hospitals');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_hospitals');
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'hospital_tags');
    }
}
