<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreateAccomodationFacitityAPIRequest extends FormRequest
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
            'data.*.accomodation_id' => ['nullable', 'exists:accomodations,id'],
            'data.*.facility_id' => ['nullable', 'exists:facilities,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
