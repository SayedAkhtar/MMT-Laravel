<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;

class QueryResource extends BaseAPIResource
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
            'patient_family_id' => $this->patient_family_id,
            'name' => $this->name,
            'specialization_id' => $this->specialization_id,
            'hospital_id' => $this->hospital_id,
            'doctor_id' => $this->doctor_id,
            'medical_history' => $this->medical_history,
            'preffered_country' => $this->preffered_country,
            'medical_report' => $this->medical_report,
            'passport' => $this->passport,
            'passport_image' => $this->passport_image,
            'status' => $this->status,
            'model' => $this->model,
            'model_id' => $this->model_id,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
            'is_completed' => $this->is_completed,
            'completed_at' => $this->completed_at,
        ];
    }
}
