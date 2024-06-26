<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDesignationAPIRequest extends FormRequest
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
            'is_active' => ['boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => (bool)$this->input('is_active')
        ]);
    }
}