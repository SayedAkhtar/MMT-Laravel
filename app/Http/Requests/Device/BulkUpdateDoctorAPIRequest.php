<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateDoctorAPIRequest extends FormRequest
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
            'data.*.user_id' => ['nullable', 'exists:users,id'],
            'data.*.start_of_service' => ['nullable'],
            'data.*.awards' => ['nullable'],
            'data.*.description' => ['nullable'],
            'data.*.designation_id' => ['nullable', 'string'],
            'data.*.qualification_id' => ['nullable', 'exists:qualifications,id'],
            'data.*.faq' => ['nullable'],
            'data.*.time_slots' => ['nullable'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
