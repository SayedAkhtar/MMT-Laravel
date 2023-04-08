<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWellnessCenterAPIRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'is_active' => (bool)$this->request->has('is_active'),
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required'],
            'address' => ['required', 'string'],
            'description' => ['nullable'],
            'logo' => ['nullable', 'file'],
            'images.*' => ['nullable', 'file'],
            'geo_location' => ['nullable', 'regex:/<iframe\s*src="https:\/\/www\.google\.com\/maps\/embed\?[^"]+"*\s*[^>]+>*<\/iframe>/u'],
            'is_active' => ['boolean'],
        ];
    }
}
