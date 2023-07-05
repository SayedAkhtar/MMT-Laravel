<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;

class Accreditation extends BaseModel
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'accreditations';

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
    public function accreditationHospitals()
    {
        return $this->hasMany(AccreditationHospital::class, 'accreditation_id', 'id');
    }
}
