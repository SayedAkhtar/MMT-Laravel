<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class Doctor extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'doctors';

    /**
     * @var string[]
     */
    protected $fillable = [
        'start_of_service',
        'awards',
        'description',
        'designation_id',
        'qualification_id',
        'faq',
        'time_slots',
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
        'start_of_service' => 'string',
        'awards' => 'string',
        'description' => 'string',
        'designation_id' => 'string',
        'qualification_id' => 'string',
        'faq' => 'json',
        'time_slots' => 'json',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];
}
