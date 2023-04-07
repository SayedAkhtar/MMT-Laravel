<?php

namespace App\Http\Resources\Client\HomeResource;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
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
            'name' => $this->user->name,
            'avatar' => asset('img/doctor-avatar.webp'),
            'start_of_service' => Carbon::make($this->start_of_service)->diffInYears(). " yrs of Experience",
            'designation' => $this->designation->name,
            'specialization' => $this->when($this->doctorSpecializations != null, function (){
                return $this->doctorSpecializations->pluck('name')->join(', ');
            }),
        ];
    }
}