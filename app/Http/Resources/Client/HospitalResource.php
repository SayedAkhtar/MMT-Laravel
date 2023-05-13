<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HospitalResource extends BaseAPIResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $fieldsFilter = $request->get('fields');
        if (!empty($fieldsFilter) || $request->get('include')) {
            return $this->resource->toArray();
        }
        $processedTestimony = [];
        if (!empty($this->testimony)) {
            foreach ($this->testimony as $testimony) {
                $images = explode(',', $testimony->images);
                foreach ($images as $path) {
                    $processedTestimony[] = [
                        'type' => 'image',
                        'value' => env('APP_URL') . Storage::url($path),
                    ];
                }
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'description' => $this->description,
            'logo' => $this->getMedia('logo')->first()?->getUrl(),
            'treatments' => $this->treatments,
            'testimonies' => $processedTestimony,
            'is_active' => $this->is_active,
        ];
    }
}
