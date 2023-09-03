<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;

class HCFResource extends BaseAPIResource
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

        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'patient_name' => $this->patient->name,
            'patient_image' => $this->patient->patientDetails?->getMedia('avatar')->first()->getUrl(),
            'query_hash' => $this->getQueryHashAttribute(),
            'query_id' => $this->id,
            'fcm_token' => $this->is_active,
            'specialization' => $this->specialization?->name,
        ];
    }
}
