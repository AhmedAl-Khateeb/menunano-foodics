<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('units')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
                }),
            ],
            'symbol' => 'required|string|max:10',
            'type' => 'required|in:count,weight,volume',
            'allow_decimal' => 'boolean',
            'is_active' => 'boolean',
            'base_unit_id' => 'nullable|exists:units,id',
            'conversion_rate' => 'nullable|numeric|required_with:base_unit_id',
        ];
    }
    
    public function prepareForValidation() 
    {
        $this->merge([
            'allow_decimal' => $this->has('allow_decimal'),
            'is_active' => $this->has('is_active'),
        ]);
    }
}
