<?php

namespace App\Http\Requests\Client;

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

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required', 'unique:wellness_centers,name,'.$this->route('wellnessCenter')],
            'adress' => ['required', 'unique:wellness_centers,adress,'.$this->route('wellnessCenter')],
            'description' => ['nullable'],
            'logo' => ['nullable', 'string'],
            'image' => ['nullable'],
            'geo_location' => ['nullable'],
            'is_active' => ['boolean'],
        ];
    }
}
