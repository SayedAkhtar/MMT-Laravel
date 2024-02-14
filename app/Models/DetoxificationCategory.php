<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;
use App\Traits\HasTranslations;

class DetoxificationCategory extends Model
{
    use HasRecordOwnerProperties, HasTranslations;

    /**
     * @var string
     */
    protected $table = 'detoxification_categories';
    public $translatable = ['name'];
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
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
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function detoxificationWellnesses()
    {
        return $this->hasMany(DetoxificationWellness::class, 'detoxification_category_id', 'id');
    }
}
