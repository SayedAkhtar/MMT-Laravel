<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientTestimonyTagAPIRequest extends FormRequest
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
            'testimony_id' => ['nullable', 'exists:patient_testimonies,id'],
            'tag_id' => ['nullable', 'exists:tags,id'],
            'is_active' => ['boolean'],
        ];
    }
}
