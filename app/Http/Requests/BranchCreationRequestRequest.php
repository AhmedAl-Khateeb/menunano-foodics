<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchCreationRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_name' => 'required|string|max:255',
            'branch_code' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ];
    }
}
