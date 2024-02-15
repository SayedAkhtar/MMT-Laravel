<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHospitalAPIRequest extends FormRequest
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
            'geo_location' => ['nullable', 'string'],
            'logo' => ['nullable', 'file'],
            'images' => ['nullable'],
            'is_active' => ['boolean'],
            'order' => ['sometimes', 'numeric'],
            'doctors.*' => ['sometimes'],
            'treatments.*' => ['sometimes'],
            'accreditations.*' => ['sometimes'],
            'country_id.*' => ['sometimes'],
            'state_id.*' => ['sometimes'],
            'city_id.*' => ['sometimes'],
        ];
    }
}
