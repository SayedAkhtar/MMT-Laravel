<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreateDoctorHospitalAPIRequest extends FormRequest
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
            'data.*.doctor_id' => ['nullable', 'exists:doctors,id'],
            'data.*.hospital_id' => ['nullable', 'exists:hospitals,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
