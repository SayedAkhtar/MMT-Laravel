<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateHospitalTagsAPIRequest extends FormRequest
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
            'hospital_id' => ['nullable', 'exists:hospitals,id'],
            'tag_id' => ['nullable', 'exists:tags,id'],
            'is_active' => ['boolean'],
        ];
    }
}
