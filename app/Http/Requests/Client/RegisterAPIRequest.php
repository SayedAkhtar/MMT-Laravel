<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAPIRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'gender' => strtolower($this->gender),
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'username' => ['nullable', 'string'],
            'password' => ['required', 'string'],
            'email' => ['nullable', 'string'],
            'phone' => ['required', 'integer'],
            'gender' => ['required', 'in:male,female,other'],
            'country_code' => ['required', 'string'],
            'country' => ['nullable', 'string'],
            'dob' => ['nullable', 'date'],
            'role' => ['integer', 'required'],
        ];
    }
}
