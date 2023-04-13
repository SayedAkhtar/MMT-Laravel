<?php

namespace App\Http\Requests\Device;

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
            'user_id' => ['nullable', 'exists:users,id'],
            'start_of_service' => ['nullable'],
            'awards' => ['nullable'],
            'description' => ['nullable'],
            'designation_id' => ['nullable', 'string'],
            'qualification_id' => ['nullable', 'exists:qualifications,id'],
            'faq' => ['nullable'],
            'time_slots' => ['nullable', "string"],
            'is_active' => ['boolean'],
        ];
    }
}
