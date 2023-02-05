<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class Specialization extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'specializations';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'logo',
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
        'logo' => 'string',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function pastQueries()
    {
        return $this->hasMany(PastQuery::class, 'specialization_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function doctorSpecializations()
    {
        return $this->hasMany(DoctorSpecialization::class, 'specialization_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function specializationTreatments()
    {
        return $this->hasMany(SpecializationTreatment::class, 'specialization_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function specializationQuery()
    {
        return $this->belongsTo(Query::class, 'specialization_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function patientDetails()
    {
        return $this->belongsTo(PatientDetails::class, 'speciality', 'id');
    }
}