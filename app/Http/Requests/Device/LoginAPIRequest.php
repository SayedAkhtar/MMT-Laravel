<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class LoginAPIRequest extends FormRequest
{
//    protected $redirect = '/admin/login';
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
            'email' => ['required'],
            'password' => ['required'],
        ];
    }
}