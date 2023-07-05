<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class DoctorTag extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'doctor_tags';

    /**
     * @var string[]
     */
    protected $fillable = [
        'doctor_id',
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
        'doctor_id' => 'integer',
        'tag_id' => 'integer',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function tags()
    {
        return $this->belongsTo(Tags::class, 'tag_id', 'id');
    }
}
