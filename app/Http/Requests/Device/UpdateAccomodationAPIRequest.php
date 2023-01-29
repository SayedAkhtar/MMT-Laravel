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
            'images' => ['nullable', 'string'],
            'type' => ['nullable', 'exists:accomodation_types,id'],
            'geo_location' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
