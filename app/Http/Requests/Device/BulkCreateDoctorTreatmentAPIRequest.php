<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreateDoctorTreatmentAPIRequest extends FormRequest
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
            'data.*.treatment_id' => ['nullable', 'exists:treatments,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
