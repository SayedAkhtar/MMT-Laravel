<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateDetoxificationWellnessAPIRequest extends FormRequest
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
            'data.*.detoxification_category_id' => ['nullable', 'exists:detoxification_categories,id'],
            'data.*.wellness_center_id' => ['nullable', 'exists:wellness_centers,id'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
