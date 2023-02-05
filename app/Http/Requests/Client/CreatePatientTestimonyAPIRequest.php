<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientTestimonyAPIRequest extends FormRequest
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
            'hospital_id' => ['nullable', 'exists:hospitals,id'],
            'doctor_id' => ['nullable', 'exists:users,id'],
            'description' => ['nullable'],
            'images' => ['nullable'],
            'videos' => ['nullable'],
            'is_active' => ['boolean'],
        ];
    }
}
