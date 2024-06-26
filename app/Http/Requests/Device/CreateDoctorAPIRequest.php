<?php

namespace App\Http\Requests\Device;

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
            'awards' => ['nullable'],
            'description' => ['nullable'],
            'designation_id.*' => ['required'],
            'qualification_id.*' => ['required'],
            'faq' => ['nullable'],
            'time_slots' => ['nullable'],
            'start_of_service' => ['required'],
            'is_active' => ['boolean'],
        ];
    }
}
