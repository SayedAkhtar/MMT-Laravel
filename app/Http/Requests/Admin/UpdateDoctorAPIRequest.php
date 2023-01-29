<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorAPIRequest extends FormRequest
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
            'start_of_service' => ['nullable', 'string'],
            'awards' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'designation_id' => ['nullable', 'string'],
            'qualification_id' => ['nullable', 'string'],
            'faq' => ['nullable'],
            'time_slots' => ['nullable'],
            'is_active' => ['boolean'],
        ];
    }
}
