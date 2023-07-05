<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateDetoxificationWellnessAPIRequest extends FormRequest
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
            'detoxification_category_id' => ['nullable', 'exists:detoxification_categories,id'],
            'wellness_center_id' => ['nullable', 'exists:wellness_centers,id'],
            'is_active' => ['boolean'],
        ];
    }
}
