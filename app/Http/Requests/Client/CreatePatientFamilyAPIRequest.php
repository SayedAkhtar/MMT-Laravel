<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientFamilyAPIRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(){
        $this->merge([
            'is_active' => true,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'patient_id' => ['nullable', 'exists:users,id'],
            'name' => ['required'],
            'dob' => ['required'],
            'gender' => ['required'],
            'phone' => ['required'],
            'relationship' => ['required'],
            'treatment_country' => ['required'],
            'is_active' => ['boolean'],
        ];
    }
}
