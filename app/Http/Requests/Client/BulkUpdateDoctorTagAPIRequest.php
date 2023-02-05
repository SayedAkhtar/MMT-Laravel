<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateDoctorTagAPIRequest extends FormRequest
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
            'data.*.doctor_id' => ['nullable', 'exists:doctors,id'],
            'data.*.tag_id' => ['nullable', 'exists:tags,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
