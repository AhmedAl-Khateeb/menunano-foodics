<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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

            'cover' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:2048',

            'Purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',

            'sizes' => 'nullable|array',
            'sizes.*.size' => 'nullable|string|max:255',
            'sizes.*.Purchase_price' => 'nullable|numeric|min:0',
            'sizes.*.selling_price' => 'nullable|numeric|min:0',
        ];
    }
}
