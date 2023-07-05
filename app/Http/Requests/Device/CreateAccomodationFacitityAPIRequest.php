<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccomodationFacitityAPIRequest extends FormRequest
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
            'accomodation_id' => ['nullable', 'exists:accomodations,id'],
            'facility_id' => ['nullable', 'exists:facilities,id'],
            'is_active' => ['boolean'],
        ];
    }
}
