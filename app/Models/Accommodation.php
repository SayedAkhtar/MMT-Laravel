<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Spatie\Translatable\HasTranslations;

class Accommodation extends BaseModel
{
    use HasRecordOwnerProperties, HasTranslations;

    /**
     * @var string
     */
    protected $table = 'accommodations';
    public $translatable = ['name', 'address'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'address',
        'images',
        'type',
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
        'images' => 'array',
        'type' => 'integer',
        'geo_location' => 'string',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function confirmedQuery()
    {
        return $this->belongsTo(ConfirmedQuery::class, 'accommodation_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'accommodation_facilities');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function category()
    {
        return $this->hasOne(AccommodationType::class, 'id', 'type');
    }
}
