<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientDetailsAPIRequest extends FormRequest
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
            'user_id' => ['nullable', 'exists:users,id'],
            'speciality' => ['nullable', 'exists:specializations,id'],
            'treatment_country' => ['nullable', 'string'],
            'medical_ifo' => ['nullable'],
            'is_active' => ['boolean'],
        ];
    }
}
