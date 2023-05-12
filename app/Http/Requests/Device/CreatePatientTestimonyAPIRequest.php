<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientTestimonyAPIRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->request->has('is_active'),
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
//            'patient_id' => ['nullable', 'exists:users,id'],
//            'hospital_id' => ['nullable', 'exists:hospitals,id'],
//            'doctor_id' => ['nullable', 'exists:users,id'],
            'description' => ['nullable'],
            'images.*' => ['nullable'],
            'videos.*' => ['nullable'],
            'is_active' => ['sometimes'],
        ];
    }
}
