<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchUpdateRequest extends FormRequest
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

            'manager_user_id' => 'nullable|exists:users,id',
            'branch_role' => 'nullable|in:manager,cashier,staff',
            'is_primary_manager' => 'nullable|boolean',
            'can_manage_permissions' => 'nullable|boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ];
    }
}
