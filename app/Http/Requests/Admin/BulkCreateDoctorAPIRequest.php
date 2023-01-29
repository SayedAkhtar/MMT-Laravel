<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreateDoctorAPIRequest extends FormRequest
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
            'data.*.start_of_service' => ['nullable', 'string'],
            'data.*.awards' => ['nullable', 'string'],
            'data.*.description' => ['nullable', 'string'],
            'data.*.designation_id' => ['nullable', 'string'],
            'data.*.qualification_id' => ['nullable', 'string'],
            'data.*.faq' => ['nullable'],
            'data.*.time_slots' => ['nullable'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
