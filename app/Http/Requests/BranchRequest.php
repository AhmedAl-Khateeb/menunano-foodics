<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ];
    }
}
