<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class AccreditationHospital extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'accreditation_hospitals';

    /**
     * @var string[]
     */
    protected $fillable = [
        'accreditation_id',
        'hospital_id',
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
        'accreditation_id' => 'integer',
        'hospital_id' => 'integer',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function accreditation()
    {
        return $this->belongsTo(Accreditation::class, 'accreditation_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'id');
    }
}
