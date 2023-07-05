<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccreditationHospitalAPIRequest extends FormRequest
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
            'accreditation_id' => ['nullable', 'exists:accreditations,id'],
            'hospital_id' => ['nullable', 'exists:hospitals,id'],
            'is_active' => ['boolean'],
        ];
    }
}
