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
