<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientFamilyDetailsAPIRequest extends FormRequest
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
            'patient_id' => ['nullable', 'exists:users,id'],
            'name' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'relationship' => ['nullable', 'string'],
            'dob' => ['nullable'],
            'gender' => ['nullable', 'string', 'unique:patient_family_details,gender'],
            'geo_location' => ['nullable'],
            'treatment_country' => ['nullable', 'string'],
            'medical_info' => ['nullable'],
            'is_active' => ['boolean'],
        ];
    }
}
