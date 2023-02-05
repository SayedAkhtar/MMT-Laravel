<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class Query extends Model
{
    use HasRecordOwnerProperties;

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
        'name',
        'specialization_id',
        'hospital_id',
        'doctor_id',
        'medical_history',
        'preffered_country',
        'medical_report',
        'passport',
        'passport_image',
        'status',
        'model',
        'model_id',
        'is_active',
        'created_at',
        'updated_at',
        'added_by',
        'updated_by',
        'is_completed',
        'completed_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'patient_id' => 'integer',
        'patient_family_id' => 'integer',
        'name' => 'string',
        'specialization_id' => 'integer',
        'hospital_id' => 'integer',
        'doctor_id' => 'integer',
        'medical_history' => 'string',
        'preffered_country' => 'string',
        'medical_report' => 'string',
        'passport' => 'string',
        'passport_image' => 'string',
        'status' => 'string',
        'model' => 'string',
        'model_id' => 'integer',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
        'is_completed' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function pastQueries()
    {
        return $this->hasMany(PastQuery::class, 'query_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function confirmedQuery()
    {
        return $this->belongsTo(ConfirmedQuery::class, 'query_id', 'id');
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
    public function user()
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
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }
}
