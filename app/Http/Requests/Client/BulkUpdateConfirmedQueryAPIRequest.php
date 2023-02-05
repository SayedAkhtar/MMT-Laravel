<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateConfirmedQueryAPIRequest extends FormRequest
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
            'data.*.query_id' => ['nullable', 'exists:queries,id'],
            'data.*.accomodation_id' => ['nullable', 'exists:accomodations,id'],
            'data.*.cab_detail' => ['nullable'],
            'data.*.coordinator_id' => ['nullable', 'exists:users,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
