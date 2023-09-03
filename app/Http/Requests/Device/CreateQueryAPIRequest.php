<?php

namespace App\Http\Requests\Device;

use App\Models\Query;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateQueryAPIRequest extends FormRequest
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
            'patient_name' => ['nullable'],
            'type' => ['required', Rule::in([Query::TYPE_QUERY, Query::TYPE_MEDICAL_VISA])],
            'query_for' => ['required', Rule::in(['1','2'])],
            'current_step' => ['required', 'integer'],
            'response' => ['required'],
            'proforma_invoice' => 'nullable | file'
        ];
    }
}
