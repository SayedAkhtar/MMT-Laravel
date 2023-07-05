<?php

namespace App\Http\Resources\Device;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;

class ActiveQueryResource extends BaseAPIResource
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
            'query_id' => $this->query_id,
            'doctor_response' => $this->doctor_response,
            'patient_response' => $this->patient_response,
            'attendant_passport' => $this->attendant_passport,
            'tickets' => $this->tickets,
            'medical_visa' => $this->medical_visa,
            'is_payment_required' => $this->is_payment_required,
            'is_payment_done' => $this->is_payment_done,
            'country' => $this->country,
            'state' => $this->state,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
