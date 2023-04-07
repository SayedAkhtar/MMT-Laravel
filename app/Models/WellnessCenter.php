<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;

class WellnessCenter extends BaseModel
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'wellness_centers';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'address',
        'description',
        'logo',
        'image',
        'geo_location',
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
        'logo' => 'string',
        'image' => 'Array',
        'geo_location' => 'json',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function detoxification()
    {
        return $this->belongsToMany(DetoxificationCategory::class, 'detoxification_wellness');
    }
}
