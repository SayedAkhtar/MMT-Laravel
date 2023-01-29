<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdatePatientFamilyDetailsAPIRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'data.*.patient_id' => ['nullable', 'exists:users,id'],
            'data.*.name' => ['nullable', 'string'],
            'data.*.phone' => ['nullable', 'string'],
            'data.*.relationship' => ['nullable', 'string'],
            'data.*.dob' => ['nullable'],
            'data.*.gender' => ['nullable', 'string', 'unique:patient_family_details,gender,'.$this->route('patientFamilyDetails')],
            'data.*.geo_location' => ['nullable'],
            'data.*.treatment_country' => ['nullable', 'string'],
            'data.*.medical_info' => ['nullable'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
