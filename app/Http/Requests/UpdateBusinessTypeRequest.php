<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBusinessTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function rules(): array
    {
        $businessTypeId = $this->route('business_type');

        if (is_object($businessTypeId)) {
            $businessTypeId = $businessTypeId->id;
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('business_types', 'slug')->ignore($businessTypeId),
            ],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
