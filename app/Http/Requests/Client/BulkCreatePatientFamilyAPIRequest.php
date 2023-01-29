<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreatePatientFamilyAPIRequest extends FormRequest
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
            'data.*.patient_id' => ['nullable', 'exists:users,id'],
            'data.*.family_id' => ['nullable', 'exists:patient_family_details,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
