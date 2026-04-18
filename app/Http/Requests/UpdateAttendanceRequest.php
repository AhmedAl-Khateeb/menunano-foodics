<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'shift_id' => ['nullable', 'exists:shifts,id'],
            'attendance_date' => ['required', 'date'],
            'check_in' => ['nullable', 'date'],
            'check_out' => ['nullable', 'date', 'after_or_equal:check_in'],
            'status' => ['required', Rule::in(['present', 'absent', 'late', 'leave'])],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'الموظف مطلوب',
            'user_id.exists' => 'الموظف المحدد غير موجود',
            'shift_id.exists' => 'الشيفت المحدد غير موجود',
            'attendance_date.required' => 'تاريخ الحضور مطلوب',
            'attendance_date.date' => 'تاريخ الحضور غير صحيح',
            'check_in.date' => 'وقت الحضور غير صحيح',
            'check_out.date' => 'وقت الانصراف غير صحيح',
            'check_out.after_or_equal' => 'وقت الانصراف يجب أن يكون بعد أو مساويًا لوقت الحضور',
            'status.required' => 'الحالة مطلوبة',
            'status.in' => 'الحالة المحددة غير صحيحة',
        ];
    }
}
