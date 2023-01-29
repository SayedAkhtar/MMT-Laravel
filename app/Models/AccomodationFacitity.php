<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class AccomodationFacitity extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'accomodation_facitities';

    /**
     * @var string[]
     */
    protected $fillable = [
        'accomodation_id',
        'facility_id',
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
        'accomodation_id' => 'integer',
        'facility_id' => 'integer',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function accomodation()
    {
        return $this->belongsTo(Accomodation::class, 'accomodation_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }
}
