<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateWellnessCenterAPIRequest extends FormRequest
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
            'data.*.name' => ['string', 'required', 'unique:wellness_centers,name,'.$this->route('wellnessCenter')],
            'data.*.adress' => ['required', 'unique:wellness_centers,adress,'.$this->route('wellnessCenter')],
            'data.*.description' => ['nullable'],
            'data.*.logo' => ['nullable', 'string'],
            'data.*.image' => ['nullable'],
            'data.*.geo_location' => ['nullable'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
