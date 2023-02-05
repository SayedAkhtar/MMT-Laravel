<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class PastQuery extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'past_queries';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'opening_date',
        'closing_date',
        'specialization_id',
        'is_active',
        'created_at',
        'updated_at',
        'added_by',
        'updated_by',
        'query_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'opening_date' => 'datetime',
        'closing_date' => 'datetime',
        'specialization_id' => 'integer',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
        'query_id' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function queries()
    {
        return $this->belongsTo(Query::class, 'query_id', 'id');
    }
}