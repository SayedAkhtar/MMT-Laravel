<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;

class PatientFamilyDetailsResource extends BaseAPIResource
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
        $male = ['avatar.png', 'avatar5.png', 'avatar4.png'];
        $female = ['avatar2.png', 'avatar3.png'];
        $avatar = "";
        if ($this->gender == 'male') {
            $avatar = $male[rand(0, 2)];
        } else {
            $avatar = $female[rand(0, 1)];
        }

        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'avatar' => asset('img/' . $avatar),
            'name' => $this->name,
            'phone' => $this->phone,
            'relationship' => $this->relationship,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'treatment_country' => $this->treatment_country,
            'speciality' => $this->specialization?->name
        ];
    }
}
