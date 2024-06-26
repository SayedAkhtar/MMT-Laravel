<?php

namespace App\Http\Resources\Client\HomeResource;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DoctorHomeResource extends BaseAPIResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->user?->name,
            'avatar' => $this->getMedia('avatar')->first() ? $this->getMedia('avatar')->first()->getUrl('thumbnail') : '',
            'start_of_service' => Carbon::make($this->start_of_service)->diffInYears() . " yrs of Experience",
            'designation' => $this->designations->pluck('name')->join(', '),
            'specialization' => $this->when($this->specializations != null, function () {
                return $this->specializations->pluck('name')->join(', ');
            }),
        ];
    }
}
