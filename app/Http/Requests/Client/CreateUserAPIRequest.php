<?php

namespace App\Http\Requests\Client;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserAPIRequest extends FormRequest
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
            'name' => ['nullable', 'string'],
            'username' => ['nullable', 'string'],
            'password' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'phone' => ['nullable', 'integer'],
            'email_verified_at' => ['nullable'],
            'is_active' => ['boolean'],
            'image' => ['nullable', 'string'],
            'gender' => ['required', 'unique:users,gender'],
            'country' => ['nullable', 'string'],
            'dob' => ['nullable', 'date'],
            'user_type' => ['required', Rule::in([User::TYPE_ADMIN, User::TYPE_USER])],
        ];
    }
}
