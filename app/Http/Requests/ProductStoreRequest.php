<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'cover' => 'required|file|mimes:jpeg,png,jpg,heic,gif,webp,avif|max:5000',
            'price' => 'nullable|numeric|min:0',
            'sizes' => 'nullable|array',
            'sizes.*.size' => 'nullable|string|max:255',
            'sizes.*.price' => 'nullable|numeric|min:0',
        ];
    }
}
