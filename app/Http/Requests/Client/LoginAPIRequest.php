<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class LoginAPIRequest extends FormRequest
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
            'phone' => ['required'],
            'password' => ['required'],
            'language' => ['nullable'],
            'role' => ['required', 'integer'],
        ];
    }
}
