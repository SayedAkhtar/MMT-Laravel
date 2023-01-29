<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreateTagsAPIRequest extends FormRequest
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
            'data.*.name' => ['string', 'required', 'unique:tags,name'],
            'data.*.slug' => ['nullable', 'string', 'unique:tags,slug'],
            'data.*.model' => ['string', 'required', 'unique:tags,model'],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
