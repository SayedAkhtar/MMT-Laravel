<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagsAPIRequest extends FormRequest
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
            'name' => ['string', 'required', 'unique:tags,name,'.$this->route('tags')],
            'slug' => ['nullable', 'string', 'unique:tags,slug,'.$this->route('tags')],
            'model' => ['string', 'required', 'unique:tags,model,'.$this->route('tags')],
            'is_active' => ['boolean'],
        ];
    }
}
