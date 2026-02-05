<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * تحديد ما إذا كان المستخدم مخوّلًا لإجراء هذا الطلب.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * تحديد قواعد التحقق من الصحة.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'cover' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,heic,avif|max:2048',
            'price' => 'nullable|numeric|min:0',
            'sizes' => 'nullable|array',
            'sizes.*.size' => 'nullable|string|max:255',
            'sizes.*.price' => 'nullable|numeric|min:0',
        ];
    }
}
