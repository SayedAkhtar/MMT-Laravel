<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateAccomodationAPIRequest extends FormRequest
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
            'data.*.name' => ['nullable', 'string'],
            'data.*.address' => ['nullable', 'string'],
            'data.*.images' => ['nullable', 'string'],
            'data.*.type' => ['nullable', 'exists:accomodation_types,id'],
            'data.*.geo_location' => ['nullable', 'string'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
