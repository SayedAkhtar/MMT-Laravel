<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpecializationAPIRequest extends FormRequest
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
            'name' => ['string', 'required', 'unique:specializations,name,'.$this->route('specialization')],
            'logo' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
