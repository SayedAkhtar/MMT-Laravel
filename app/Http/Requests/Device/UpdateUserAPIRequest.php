<?php

namespace App\Http\Requests\Device;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserAPIRequest extends FormRequest
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
            'gender' => ['required', 'unique:users,gender,'.$this->route('user')],
            'country' => ['nullable', 'string'],
            'dob' => ['nullable', 'date'],
            'user_type' => [Rule::in([User::TYPE_ADMIN, User::TYPE_USER])],
        ];
    }
}
