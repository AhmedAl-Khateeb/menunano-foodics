<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('web')->check();
    }

    public function rules(): array
    {
        return [
            'from_branch_id' => 'required|exists:branches,id',
            'to_branch_id' => 'required|exists:branches,id|different:from_branch_id',
            'type' => 'required|in:linked,inventory_transfer,shared_reports,main_sub_branch',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'from_branch_id.required' => 'يجب اختيار الفرع المصدر.',
            'to_branch_id.required' => 'يجب اختيار الفرع الهدف.',
            'to_branch_id.different' => 'لا يمكن ربط الفرع بنفسه.',
            'type.required' => 'يجب اختيار نوع الربط.',
        ];
    }
}
