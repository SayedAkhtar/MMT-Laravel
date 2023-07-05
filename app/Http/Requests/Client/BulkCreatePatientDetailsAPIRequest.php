<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreatePatientDetailsAPIRequest extends FormRequest
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
            'data.*.user_id' => ['nullable', 'exists:users,id'],
            'data.*.speciality' => ['nullable', 'exists:specializations,id'],
            'data.*.treatment_country' => ['nullable', 'string'],
            'data.*.medical_ifo' => ['nullable'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
