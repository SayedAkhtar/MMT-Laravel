<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;

class PatientFamilyResource extends BaseAPIResource
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
            'name' => $this->name,
            'phone' => $this->phone,
            'relationship' => $this->relationship,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'treatment_country' => $this->treatment_country,
            'is_active' => $this->is_active,
            'family_user_id' => $this->family_user_id,
        ];
    }
}
