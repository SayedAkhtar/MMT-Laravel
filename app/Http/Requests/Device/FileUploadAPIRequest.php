<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadAPIRequest extends FormRequest
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
            'files' => ['required'],
            'files.*' => ['mimes:png,jpeg,jpg,pdf', 'max:10240'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'files.*.max' => 'The file size must not be greater than 10 mb',
        ];
    }
}
