<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordAPIRequest extends FormRequest
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
            'code' => ['required'],
            'new_password' => ['required'],
        ];
    }
}
