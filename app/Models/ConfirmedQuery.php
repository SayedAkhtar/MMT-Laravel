<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class ConfirmedQuery extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'confirmed_queries';

    /**
     * @var string[]
     */
    protected $fillable = [
        'query_id',
        'accomodation_id',
        'cab_detail',
        'coordinator_id',
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
        'query_id' => 'integer',
        'accomodation_id' => 'integer',
        'cab_detail' => 'string',
        'coordinator_id' => 'integer',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function query()
    {
        return $this->hasOne(Query::class, 'id', 'query_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function accomodation()
    {
        return $this->hasOne(Accomodation::class, 'id', 'accomodation_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'coordinator_id');
    }
}
