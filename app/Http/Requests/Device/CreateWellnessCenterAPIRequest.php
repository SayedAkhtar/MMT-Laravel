<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class CreateWellnessCenterAPIRequest extends FormRequest
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
            'address' => ['required'],
            'description' => ['nullable'],
            'logo' => ['nullable', 'file'],
            'images.*' => ['nullable', 'file'],
            'geo_location' => ['nullable', 'regex:/<iframe\s*src="https:\/\/www\.google\.com\/maps\/embed\?[^"]+"*\s*[^>]+>*<\/iframe>/u'],
            'is_active' => ['boolean'],
        ];
    }
}
