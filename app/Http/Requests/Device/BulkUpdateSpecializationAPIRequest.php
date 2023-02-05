<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateSpecializationAPIRequest extends FormRequest
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
            'data.*.name' => ['string', 'required', 'unique:specializations,name,'.$this->route('specialization')],
            'data.*.logo' => ['nullable', 'string'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
