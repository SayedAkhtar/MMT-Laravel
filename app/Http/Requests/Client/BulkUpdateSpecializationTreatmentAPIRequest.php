<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateSpecializationTreatmentAPIRequest extends FormRequest
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
            'data.*.specialization_id' => ['required', 'exists:specializations,id'],
            'data.*.treatment_id' => ['required', 'exists:treatments,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
