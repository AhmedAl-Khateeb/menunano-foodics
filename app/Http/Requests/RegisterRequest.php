<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'store_name' => [
                'required',
                'string',
                'unique:users,store_name',
                'regex:/^[a-zA-Z]+$/',
            ],
            'password' => 'required|string|min:6',
            'image' => 'nullable|image|mimes:jpg,jpeg,webp,heic,png|max:7168',
            'package_id' => 'required|exists:packages,id',
        ];
    }
}
