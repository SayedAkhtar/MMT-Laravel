<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateActiveQueryAPIRequest extends FormRequest
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
            'data.*.query_id' => ['nullable'],
            'data.*.doctor_response' => ['nullable'],
            'data.*.patient_response' => ['nullable'],
            'data.*.attendant_passport' => ['nullable', 'string'],
            'data.*.tickets' => ['nullable', 'string'],
            'data.*.medical_visa' => ['nullable', 'string'],
            'data.*.is_payment_required' => ['boolean'],
            'data.*.is_payment_done' => ['boolean'],
            'data.*.country' => ['nullable', 'string'],
            'data.*.state' => ['nullable', 'string'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
