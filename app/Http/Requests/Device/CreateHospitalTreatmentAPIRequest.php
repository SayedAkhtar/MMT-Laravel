<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class CreateHospitalTreatmentAPIRequest extends FormRequest
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
            'hospital_id' => ['nullable', 'exists:hospitals,id'],
            'treatment_id' => ['nullable', 'exists:treatments,id'],
            'is_active' => ['boolean'],
        ];
    }
}
