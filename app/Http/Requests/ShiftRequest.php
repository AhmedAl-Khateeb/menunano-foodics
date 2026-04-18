<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShiftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'starting_cash' => ['required', 'numeric', 'min:0'],
            'expected_cash' => ['nullable', 'numeric', 'min:0'],
            'ending_cash' => ['nullable', 'numeric', 'min:0'],
            'start_time' => ['nullable', 'date'],
            'end_time' => ['nullable', 'date', 'after_or_equal:start_time'],
            'status' => ['required', Rule::in(['active', 'paused', 'closed'])],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'الموظف مطلوب',
            'user_id.exists' => 'الموظف المحدد غير موجود',
            'branch_id.required' => 'الفروع مطلوبة',
            'branch_id.exists' => 'الفروع المحددة غير موجودة',
            'starting_cash.required' => 'رصيد البداية مطلوب',
            'starting_cash.numeric' => 'رصيد البداية يجب أن يكون رقمًا',
            'starting_cash.min' => 'رصيد البداية لا يمكن أن يكون أقل من صفر',
            'expected_cash.numeric' => 'الكاش المتوقع يجب أن يكون رقمًا',
            'expected_cash.min' => 'الكاش المتوقع لا يمكن أن يكون أقل من صفر',
            'ending_cash.numeric' => 'رصيد النهاية يجب أن يكون رقمًا',
            'ending_cash.min' => 'رصيد النهاية لا يمكن أن يكون أقل من صفر',
            'start_time.date' => 'وقت بداية الشيفت غير صحيح',
            'end_time.date' => 'وقت نهاية الشيفت غير صحيح',
            'end_time.after_or_equal' => 'وقت نهاية الشيفت يجب أن يكون بعد أو مساويًا لوقت البداية',
            'status.required' => 'حالة الشيفت مطلوبة',
            'status.in' => 'حالة الشيفت غير صحيحة',
        ];
    }
}
