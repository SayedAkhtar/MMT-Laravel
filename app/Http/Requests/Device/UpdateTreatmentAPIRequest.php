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
            'name' => ['string', 'required'],
            'min_price' => ['integer', 'required'],
            'max_price' => ['integer', 'sometimes'],
            'logo' => ['nullable', 'file'],
            'days_required' => ['string', 'required'],
            'recovery_time' => ['string', 'required'],
            'success_rate' => ['string', 'required'],
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
