<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateTreatmentAPIRequest extends FormRequest
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
            'name' => ['string', 'required', 'unique:treatments,name'],
            'price' => ['integer', 'required'],
            'images' => ['nullable'],
            'days_required' => ['integer', 'required'],
            'recovery_time' => ['integer', 'required'],
            'success_rate' => ['integer', 'required'],
            'covered' => ['nullable'],
            'not_covered' => ['nullable'],
            'is_active' => ['boolean'],
        ];
    }
}
