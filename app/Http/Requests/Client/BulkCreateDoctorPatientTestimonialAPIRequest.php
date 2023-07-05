<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreateDoctorPatientTestimonialAPIRequest extends FormRequest
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
            'data.*.doctor_id' => ['nullable', 'exists:doctors,id'],
            'data.*.testimonial_id' => ['nullable', 'exists:patient_testimonies,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
