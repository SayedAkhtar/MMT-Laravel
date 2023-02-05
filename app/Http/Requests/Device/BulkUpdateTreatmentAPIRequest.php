<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateTreatmentAPIRequest extends FormRequest
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
            'data.*.name' => ['string', 'required', 'unique:treatments,name,'.$this->route('treatment')],
            'data.*.price' => ['integer', 'required'],
            'data.*.images' => ['nullable'],
            'data.*.days_required' => ['integer', 'required'],
            'data.*.recovery_time' => ['integer', 'required'],
            'data.*.success_rate' => ['integer', 'required'],
            'data.*.covered' => ['nullable'],
            'data.*.not_covered' => ['nullable'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
