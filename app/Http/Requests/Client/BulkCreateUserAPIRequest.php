<?php

namespace App\Http\Requests\Client;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkCreateUserAPIRequest extends FormRequest
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
            'data.*.name' => ['nullable', 'string'],
            'data.*.username' => ['nullable', 'string'],
            'data.*.password' => ['nullable', 'string'],
            'data.*.email' => ['nullable', 'string'],
            'data.*.phone' => ['nullable', 'integer'],
            'data.*.email_verified_at' => ['nullable'],
            'data.*.is_active' => ['boolean'],
            'data.*.image' => ['nullable', 'string'],
            'data.*.gender' => ['required', 'unique:users,gender'],
            'data.*.country' => ['nullable', 'string'],
            'data.*.dob' => ['nullable', 'date'],
            'data.*.user_type' => ['required', Rule::in([User::TYPE_ADMIN, User::TYPE_USER])],
        ];
    }
}
