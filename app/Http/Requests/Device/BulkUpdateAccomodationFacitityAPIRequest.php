<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateAccomodationFacitityAPIRequest extends FormRequest
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
