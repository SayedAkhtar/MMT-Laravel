<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateDoctorTagAPIRequest extends FormRequest
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
            'doctor_id' => ['nullable', 'exists:doctors,id'],
            'tag_id' => ['nullable', 'exists:tags,id'],
            'is_active' => ['boolean'],
        ];
    }
}