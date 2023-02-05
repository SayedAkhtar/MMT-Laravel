<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateConfirmedQueryAPIRequest extends FormRequest
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
            'query_id' => ['nullable', 'exists:queries,id'],
            'accomodation_id' => ['nullable', 'exists:accomodations,id'],
            'cab_detail' => ['nullable'],
            'coordinator_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['boolean'],
        ];
    }
}
