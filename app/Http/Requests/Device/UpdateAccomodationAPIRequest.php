<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccomodationAPIRequest extends FormRequest
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
            'address' => ['nullable', 'string'],
            'images.*' => ['nullable', 'file'],
            'type' => ['nullable', 'exists:accommodation_types,id'],
            'geo_location' => ['nullable', 'regex:/<iframe\s*src="https:\/\/www\.google\.com\/maps\/embed\?[^"]+"*\s*[^>]+>*<\/iframe>/u'],
            'is_active' => ['boolean'],
        ];
    }
}
