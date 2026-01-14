<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'cover' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,heic,avif|max:2048',
        ];
    }
}
