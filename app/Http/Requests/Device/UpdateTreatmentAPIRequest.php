<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTreatmentAPIRequest extends FormRequest
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
            'name' => ['string', 'required', 'unique:treatments,name,' . $this->route('treatment')],
            'price' => ['integer', 'required'],
            'images.*' => ['nullable', 'file'],
            'days_required' => ['integer', 'required'],
            'recovery_time' => ['integer', 'required'],
            'success_rate' => ['integer', 'required'],
            'hospitals.*' => ['integer', 'sometimes'],
            'doctors.*' => ['integer', 'sometimes'],
            'specializations.*' => ['integer', 'sometimes'],
            'blogs.*' => ['integer', 'sometimes'],
            'covered' => ['nullable'],
            'not_covered' => ['nullable'],
            'is_active' => ['boolean'],
        ];
    }
}
