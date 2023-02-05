<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateHospitalAPIRequest extends FormRequest
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
            'data.*.address' => ['nullable'],
            'data.*.description' => ['nullable'],
            'data.*.geo_location' => ['nullable'],
            'data.*.logo' => ['nullable', 'string'],
            'data.*.images' => ['nullable'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
