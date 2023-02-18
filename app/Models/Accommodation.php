<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class Accommodation extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'accommodations';

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
        'images' => 'string',
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
        return $this->belongsTo(ConfirmedQuery::class, 'accomodation_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function accomodationFacitities()
    {
        return $this->hasMany(AccomodationFacitity::class, 'accomodation_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function accomodationType()
    {
        return $this->hasOne(AccomodationType::class, 'id', 'type');
    }
}