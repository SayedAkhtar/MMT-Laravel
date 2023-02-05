<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class Treatment extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'treatments';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'price',
        'images',
        'days_required',
        'recovery_time',
        'success_rate',
        'covered',
        'not_covered',
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
        'price' => 'integer',
        'images' => 'json',
        'days_required' => 'integer',
        'recovery_time' => 'integer',
        'success_rate' => 'integer',
        'covered' => 'string',
        'not_covered' => 'string',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function hospitalTreatments()
    {
        return $this->hasMany(HospitalTreatment::class, 'treatment_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function doctorTreatments()
    {
        return $this->hasMany(DoctorTreatment::class, 'treatment_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function specializationTreatments()
    {
        return $this->hasMany(SpecializationTreatment::class, 'treatment_id', 'id');
    }
}
