<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePastQueryAPIRequest extends FormRequest
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
            'user_id' => ['nullable', 'exists:users,id'],
            'opening_date' => ['nullable'],
            'closing_date' => ['nullable'],
            'specialization_id' => ['nullable', 'exists:specializations,id'],
            'is_active' => ['boolean'],
            'query_id' => ['nullable', 'exists:queries,id'],
        ];
    }
}
