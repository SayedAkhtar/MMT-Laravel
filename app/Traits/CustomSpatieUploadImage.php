<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\Model;

trait CustomSpatieUploadImage
{
    public function attachImage(Model $model, string $key, string $library, bool $isMultiple)
    {
        if ($isMultiple) {
            $model->addMultipleMediaFromRequest([$key])->each(fn($fileAdder) => $fileAdder->toMediaCollection($library));
        } else {
            $model->addMediaFromRequest($key)->toMediaCollection($library);
        }
    }
}
