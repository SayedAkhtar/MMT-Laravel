<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateHospitalAPIRequest extends FormRequest
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
            'name' => ['nullable', 'string'],
            'address' => ['nullable'],
            'description' => ['nullable'],
            'geo_location' => ['nullable'],
            'logo' => ['nullable', 'string'],
            'images' => ['nullable'],
            'is_active' => ['boolean'],
        ];
    }
}
