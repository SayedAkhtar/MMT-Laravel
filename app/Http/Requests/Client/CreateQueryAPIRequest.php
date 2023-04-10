<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateQueryAPIRequest extends FormRequest
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
            'patient_family_id' => ['nullable', 'exists:users,id'],
            'name' => ['string', 'nullable'],
            'specialization_id' => ['required', 'exists:specializations,id'],
            'hospital_id' => ['required', 'exists:hospitals,id'],
            'doctor_id' => ['nullable', 'exists:doctors,id'],
            'medical_history' => ['nullable', 'string'],
            'preferred_country' => ['nullable', 'string'],
            'medical_report' => ['nullable', 'file'],
            'passport' => ['nullable', 'file'],
            'passport_image' => ['nullable', 'file'],
            'model_id' => ['nullable'],
            'is_active' => ['boolean'],
            'is_completed' => ['boolean'],
            'completed_at' => ['nullable'],
        ];
    }
}
