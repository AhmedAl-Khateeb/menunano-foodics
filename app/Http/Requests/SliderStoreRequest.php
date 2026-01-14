<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|file|mimes:jpeg,png,jpg,webp,gif,svg,heic,avif',
        ];
    }
}
