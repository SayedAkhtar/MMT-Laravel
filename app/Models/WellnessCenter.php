<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class WellnessCenter extends Model
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
        'adress',
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
        'adress' => 'string',
        'description' => 'string',
        'logo' => 'string',
        'image' => 'json',
        'geo_location' => 'json',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function detoxificationWellnesses()
    {
        return $this->hasMany(DetoxificationWellness::class, 'wellness_center_id', 'id');
    }
}
