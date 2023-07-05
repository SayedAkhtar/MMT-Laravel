<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class CreateSpecializationTreatmentAPIRequest extends FormRequest
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
            'specialization_id' => ['required', 'exists:specializations,id'],
            'treatment_id' => ['required', 'exists:treatments,id'],
            'is_active' => ['boolean'],
        ];
    }
}
