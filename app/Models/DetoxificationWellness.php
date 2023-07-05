<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class DetoxificationWellness extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'detoxification_wellnesses';

    /**
     * @var string[]
     */
    protected $fillable = [
        'detoxification_category_id',
        'wellness_center_id',
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
        'detoxification_category_id' => 'integer',
        'wellness_center_id' => 'integer',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function detoxificationCategory()
    {
        return $this->belongsTo(DetoxificationCategory::class, 'detoxification_category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function wellnessCenter()
    {
        return $this->belongsTo(WellnessCenter::class, 'wellness_center_id', 'id');
    }
}
