<?php

namespace App\Http\Requests\Client;

use App\Models\Query;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateQueryAPIRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        $this->merge([
            'patient_id' => Auth::id(),
        ]);
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'query_id' => ['nullable'],
            'patient_family_id' => ['nullable', 'exists:users,id'],
            'type' => ['required', Rule::in([Query::TYPE_QUERY, Query::TYPE_MEDICAL_VISA])],
            'current_step' => ['required', 'integer'],
            'response' => ['required', 'array'],
        ];
    }
}
