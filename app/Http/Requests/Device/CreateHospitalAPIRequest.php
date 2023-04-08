<?php

namespace App\Http\Requests\Device;

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
            'geo_location' => ['nullable', 'regex:/<iframe\s*src="https:\/\/www\.google\.com\/maps\/embed\?[^"]+"*\s*[^>]+>*<\/iframe>/u'],
            'logo' => ['nullable', 'file'],
            'images.*' => ['nullable', 'file'],
            'is_active' => ['boolean'],
        ];
    }
}
