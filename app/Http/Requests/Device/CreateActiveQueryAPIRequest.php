<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class CreateActiveQueryAPIRequest extends FormRequest
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
            'query_id' => ['nullable'],
            'doctor_response' => ['nullable'],
            'patient_response' => ['nullable'],
            'attendant_passport' => ['nullable', 'string'],
            'tickets' => ['nullable', 'string'],
            'medical_visa' => ['nullable', 'string'],
            'is_payment_required' => ['boolean'],
            'is_payment_done' => ['boolean'],
            'country' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
