<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreateHospitalTreatmentAPIRequest extends FormRequest
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
            'data.*.hospital_id' => ['nullable', 'exists:hospitals,id'],
            'data.*.treatment_id' => ['nullable', 'exists:treatments,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
