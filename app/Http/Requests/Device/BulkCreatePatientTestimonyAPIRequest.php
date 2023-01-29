<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreatePatientTestimonyAPIRequest extends FormRequest
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
            'data.*.hospital_id' => ['nullable', 'exists:hospitals,id'],
            'data.*.doctor_id' => ['nullable', 'exists:users,id'],
            'data.*.description' => ['nullable'],
            'data.*.images' => ['nullable'],
            'data.*.videos' => ['nullable'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
