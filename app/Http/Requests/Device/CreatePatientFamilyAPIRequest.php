<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientFamilyAPIRequest extends FormRequest
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
            'family_id' => ['nullable', 'exists:patient_family_details,id'],
            'is_active' => ['boolean'],
        ];
    }
}
