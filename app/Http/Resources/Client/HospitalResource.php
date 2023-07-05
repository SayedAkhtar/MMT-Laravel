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
        $originalImage = [];
        if (!empty($this->getMedia('gallery'))) {
            foreach ($this->getMedia('gallery') as $image) {
                $originalImage[] = $image->getUrl();
            }
        }
        $banners = [];
        if (!empty($this->getMedia('gallery'))) {
            foreach ($this->getMedia('gallery') as $image) {
                $banners[] = $image->getUrl('banner');
            }
        }
        $doctors = [];
        if(!empty($this->doctors)){
            foreach ($this->doctors as $doctor){
                $doctors[] = (new DoctorResource($doctor))->resolve();
                // $doctors[] = [
                //     'id' => $doctor->id,
                //     'name' => $doctor->user->name,
                //     'avatar' => $doctor->getMedia('avatar')->first() ? $doctor->getMedia('avatar')->first()->getUrl('thumbnail') : '',
                //     'start_of_service' => $doctor->start_of_service ? $doctor->start_of_service->diffInYears() . " yrs of Experience" : '',
                //     'designation' => $doctor->designations->pluck('name')->join(', '),
                //     'specialization' => $doctor->specializations->pluck('name')->join(', '),
                // ];
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'map_frame' => $this->geo_location,
            'description' => $this->description,
            'logo' => $this->getMedia('logo')->first()?->getUrl(),
            'original_image' => $originalImage,
            'banner' => $banners,
            'doctors' => $doctors,
            'treatments' => $this->treatments,
            'testimonies' => $processedTestimony,
            'is_active' => $this->is_active,
        ];
    }
}
