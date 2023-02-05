<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreateQueryAPIRequest extends FormRequest
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
            'data.*.patient_id' => ['required', 'exists:users,id'],
            'data.*.patient_family_id' => ['required', 'exists:users,id'],
            'data.*.name' => ['string', 'required', 'unique:queries,name'],
            'data.*.specialization_id' => ['required', 'exists:specializations,id'],
            'data.*.hospital_id' => ['required', 'exists:hospitals,id'],
            'data.*.doctor_id' => ['nullable', 'exists:users,id'],
            'data.*.medical_history' => ['nullable'],
            'data.*.preffered_country' => ['nullable', 'string'],
            'data.*.medical_report' => ['nullable'],
            'data.*.passport' => ['nullable', 'string'],
            'data.*.passport_image' => ['nullable', 'string'],
            'data.*.status' => ['string', 'required', 'unique:queries,status'],
            'data.*.model' => ['nullable', 'string'],
            'data.*.model_id' => ['nullable'],
            'data.*.is_active' => ['boolean'],
            'data.*.is_completed' => ['boolean'],
            'data.*.completed_at' => ['nullable'],
        ];
    }
}
