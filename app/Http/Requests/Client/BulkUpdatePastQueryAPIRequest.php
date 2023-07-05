<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdatePastQueryAPIRequest extends FormRequest
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
            'data.*.user_id' => ['nullable', 'exists:users,id'],
            'data.*.opening_date' => ['nullable'],
            'data.*.closing_date' => ['nullable'],
            'data.*.specialization_id' => ['nullable', 'exists:specializations,id'],
            'data.*.is_active' => ['boolean'],
            'data.*.query_id' => ['nullable', 'exists:queries,id'],
        ];
    }
}
