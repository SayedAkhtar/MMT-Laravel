<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class Tags extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'tags';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'model',
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
        'slug' => 'string',
        'model' => 'string',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function doctorTags()
    {
        return $this->hasMany(DoctorTag::class, 'tag_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function patientTestimonyTags()
    {
        return $this->hasMany(PatientTestimonyTag::class, 'tag_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function hospitalTags()
    {
        return $this->hasMany(HospitalTags::class, 'tag_id', 'id');
    }
}
