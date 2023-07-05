<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Model as Model;

class PatientTestimonyTag extends Model
{
    use HasRecordOwnerProperties;

    /**
     * @var string
     */
    protected $table = 'patient_testimony_tags';

    /**
     * @var string[]
     */
    protected $fillable = [
        'testimony_id',
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
        'testimony_id' => 'integer',
        'tag_id' => 'integer',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function patientTestimony()
    {
        return $this->belongsTo(PatientTestimony::class, 'testimony_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function tags()
    {
        return $this->belongsTo(Tags::class, 'tag_id', 'id');
    }
}
