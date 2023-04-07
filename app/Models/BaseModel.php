<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BaseModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(150)
            ->height(150)
            ->optimize()
            ->sharpen(10);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function attachImage(string $key, string $library, bool $isMultiple)
    {
        if ($isMultiple) {
            $this->addMultipleMediaFromRequest([$key])->each(fn($fileAdder) => $fileAdder->toMediaCollection($library));
        } else {
            $this->addMediaFromRequest($key)->toMediaCollection($library);
        }
    }

    public function updateImage(string $key, string $library, bool $isMultiple)
    {
        if ($isMultiple) {
            $this->clearMediaCollection($library);
            return $this->addMultipleMediaFromRequest([$key])->each(fn($fileAdder) => $fileAdder->toMediaCollection($library));
        } else {
            $this->media()->delete();
            return $this->addMediaFromRequest($key)->toMediaCollection($library);
        }
    }
}
