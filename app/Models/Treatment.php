<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Treatment extends BaseModel implements HasMedia
{
    use HasRecordOwnerProperties, InteractsWithMedia;

    /**
     * @var string
     */
    protected $table = 'treatments';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'min_price',
        'max_price',
        'logo',
        'days_required',
        'recovery_time',
        'success_rate',
        'covered',
        'not_covered',
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
        'min_price' => 'integer',
        'logo' => 'string',
        'days_required' => 'string',
        'recovery_time' => 'string',
        'success_rate' => 'string',
        'covered' => 'string',
        'not_covered' => 'string',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(150)
            ->height(150)
            ->optimize()
            ->sharpen(10);
    }

    /**
     * @return BelongsToMany
     */
    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class, 'hospital_treatments');
    }

    /**
     * @return BelongsToMany
     */
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_treatments');
    }

    /**
     * @return BelongsToMany
     */
    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'specialization_treatments');
    }
}
