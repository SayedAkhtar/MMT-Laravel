<?php

namespace App\Http\Requests\Client;

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
            'password' => ['nullable', 'string'],
            'phone' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
            'image' => ['nullable', 'string'],
            'gender' => ['nullable'],
            'country' => ['nullable', 'string'],
            'treatment_country' => ['nullable', 'string'],
            'dob' => ['nullable', 'date'],
            'user_type' => [Rule::in([User::TYPE_USER])],
        ];
    }
}
