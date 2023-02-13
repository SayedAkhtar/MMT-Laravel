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
            'patient_id' => ['required', 'exists:users,id'],
            'patient_family_id' => ['nullable', 'exists:users,id'],
            'name' => ['string', 'required', 'unique:queries,name'],
            'specialization_id' => ['required', 'exists:specializations,id'],
            'hospital_id' => ['required', 'exists:hospitals,id'],
            'doctor_id' => ['nullable', 'exists:users,id'],
            'medical_history' => ['nullable'],
            'preffered_country' => ['nullable', 'string'],
            'medical_report' => ['nullable'],
            'passport' => ['nullable', 'string'],
            'passport_image' => ['nullable', 'string'],
            'status' => ['string', 'required',],
            'model' => ['nullable', 'string'],
            'model_id' => ['nullable'],
            'is_active' => ['boolean'],
            'is_completed' => ['boolean'],
            'completed_at' => ['nullable'],
        ];
    }
}