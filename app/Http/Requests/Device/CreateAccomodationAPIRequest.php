<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccomodationAPIRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->request->has('is_active'),
        ]);
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
            'geo_location' => ['nullable', 'string']
        ];
    }
}
