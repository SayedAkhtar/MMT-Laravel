<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;
use App\Traits\HasTranslations;

class Designation extends Model
{
    use HasRecordOwnerProperties, HasTranslations;

    /**
     * @var string
     */
    protected $table = 'designations';
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

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'designations_doctor');
    }
}
