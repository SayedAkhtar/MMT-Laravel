<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateTagsAPIRequest extends FormRequest
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
            'data.*.name' => ['string', 'required', 'unique:tags,name,'.$this->route('tags')],
            'data.*.slug' => ['nullable', 'string', 'unique:tags,slug,'.$this->route('tags')],
            'data.*.model' => ['string', 'required', 'unique:tags,model,'.$this->route('tags')],
            'data.*.is_active' => ['boolean'],
        ];
    }
}
