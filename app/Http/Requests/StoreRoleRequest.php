<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->where(function ($query) {
                    return $query->where('created_by', auth()->id())
                        ->where('guard_name', 'web');
                }),
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الدور مطلوب',
            'name.unique' => 'اسم الدور موجود بالفعل',
            'permissions.array' => 'صيغة الصلاحيات غير صحيحة',
            'permissions.*.exists' => 'إحدى الصلاحيات المحددة غير موجودة',
        ];
    }
}
