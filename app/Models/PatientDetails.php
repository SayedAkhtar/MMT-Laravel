<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class PatientDetails extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'patient_details';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'speciality',
        'treatment_country',
        'medical_ifo',
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
        'speciality' => 'integer',
        'treatment_country' => 'string',
        'medical_ifo' => 'string',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function specialization()
    {
        return $this->hasOne(Specialization::class, 'id', 'speciality');
    }
}
