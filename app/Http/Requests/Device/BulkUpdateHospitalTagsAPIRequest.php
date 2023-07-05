<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateHospitalTagsAPIRequest extends FormRequest
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
            'data.*.hospital_id' => ['nullable', 'exists:hospitals,id'],
            'data.*.tag_id' => ['nullable', 'exists:tags,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
