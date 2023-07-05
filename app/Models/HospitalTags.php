<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class HospitalTags extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'hospital_tags';

    /**
     * @var string[]
     */
    protected $fillable = [
        'hospital_id',
        'tag_id',
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
        'hospital_id' => 'integer',
        'tag_id' => 'integer',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function tags()
    {
        return $this->belongsTo(Tags::class, 'tag_id', 'id');
    }
}
