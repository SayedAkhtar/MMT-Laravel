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
            'geo_location' => ['nullable', 'regex:/<iframe\s*src="https:\/\/www\.google\.com\/maps\/embed\?[^"]+"*\s*[^>]+>*<\/iframe>/u'],
            'logo' => ['nullable', 'file'],
            'images' => ['nullable'],
            'is_active' => ['boolean'],
            'doctors' => ['sometimes'],
            'treatments' => ['sometimes'],
            'accreditations' => ['sometimes'],
        ];
    }
}
