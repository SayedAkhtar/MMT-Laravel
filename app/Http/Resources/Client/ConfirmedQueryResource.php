<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;

class ConfirmedQueryResource extends BaseAPIResource
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

        $accomodation = [
            "name" => $this->accommodation->name,
            "address" => $this->accommodation->address,
            "geo_location" => $this->accommodation->geo_location,
        ];

        $coordinator = [
            "name" => $this->coordinator->name,
            "phone" => $this->coordinator->phone,
            "email" => $this->coordinator->email,
            "image" => $this->coordinator->image,
        ];

        return [
            'accommodation' => $accomodation,
            'cab' => ["name" => $this->cab_name, "number" => $this->cab_number, "type" => $this->cab_type],
            'coordinator' => $this->when($this->coordinator != null, $coordinator),
        ];
    }
}
