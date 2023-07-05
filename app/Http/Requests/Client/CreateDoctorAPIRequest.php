<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateDoctorAPIRequest extends FormRequest
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
            'user_id' => ['nullable', 'exists:users,id'],
            'start_of_service' => ['nullable'],
            'awards' => ['nullable'],
            'description' => ['nullable'],
            'designation_id' => ['nullable', 'integer', 'exists:designations,id'],
            'qualification_id' => ['nullable', 'exists:qualifications,id'],
            'faq' => ['nullable'],
            'time_slots' => ['nullable'],
            'is_active' => ['boolean'],
        ];
    }
}