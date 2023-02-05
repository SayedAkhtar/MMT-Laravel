<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateDoctorPatientTestimonialAPIRequest extends FormRequest
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
            'doctor_id' => ['nullable', 'exists:doctors,id'],
            'testimonial_id' => ['nullable', 'exists:patient_testimonies,id'],
            'is_active' => ['boolean'],
        ];
    }
}
