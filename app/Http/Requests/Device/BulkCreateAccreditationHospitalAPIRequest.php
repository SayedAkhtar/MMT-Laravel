<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreateAccreditationHospitalAPIRequest extends FormRequest
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
            'data.*.accreditation_id' => ['nullable', 'exists:accreditations,id'],
            'data.*.hospital_id' => ['nullable', 'exists:hospitals,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
