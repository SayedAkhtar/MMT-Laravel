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
            'patient_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string'],
            'phone' => ['required', 'unique:patient_family_details,phone', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'speciality' => ['nullable'],
            'relationship' => ['required', 'string'],
            'dob' => ['nullable'],
            'gender' => ['nullable', 'string'],
            'treatment_country' => ['nullable', 'string'],
        ];
    }
}
