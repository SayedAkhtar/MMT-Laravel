<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpecializationAPIRequest extends FormRequest
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
            'is_active' => $this->request->has('is_active'),
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required', 'unique:specializations,name,' . $this->route('specialization')],
            'logo' => ['nullable', 'file'],
            'is_active' => ['sometimes'],
        ];
    }
}
