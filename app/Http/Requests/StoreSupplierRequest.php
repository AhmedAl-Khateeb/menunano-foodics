<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'code'                => ['nullable', 'string', 'max:100'],
            'name'                => ['required', 'string', 'max:255'],
            'phone'               => ['nullable', 'string', 'max:20'],
            'email'               => ['nullable', 'email', 'max:255'],
            'address'             => ['nullable', 'string'],
            'tax_number'          => ['nullable', 'string', 'max:100'],
            'commercial_register' => ['nullable', 'string', 'max:100'],
            'opening_balance'     => ['nullable', 'numeric'],
            'current_balance'     => ['nullable', 'numeric'],
            'credit_limit'        => ['nullable', 'numeric'],
            'payment_terms'       => ['nullable', 'string', 'max:255'],
            'notes'               => ['nullable', 'string'],
            'is_active'           => ['nullable', 'boolean'],
        ];
    }
}