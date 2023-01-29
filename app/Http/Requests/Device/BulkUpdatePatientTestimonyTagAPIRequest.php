<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdatePatientTestimonyTagAPIRequest extends FormRequest
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
            'data.*.testimony_id' => ['nullable', 'exists:patient_testimonies,id'],
            'data.*.tag_id' => ['nullable', 'exists:tags,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
