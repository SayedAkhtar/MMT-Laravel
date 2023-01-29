<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class CreateTagsAPIRequest extends FormRequest
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
            'name' => ['string', 'required', 'unique:tags,name'],
            'slug' => ['nullable', 'string', 'unique:tags,slug'],
            'model' => ['string', 'required', 'unique:tags,model'],
            'is_active' => ['boolean'],
        ];
    }
}
