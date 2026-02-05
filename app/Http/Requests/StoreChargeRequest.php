<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChargeRequest extends FormRequest
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
                \Illuminate\Validation\Rule::unique('charges')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
                }),
            ],
            'classification' => 'required|in:tax,fee',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'is_inclusive' => 'boolean',
            'applicable_order_types' => 'nullable|array',
            'applicable_order_types.*' => 'in:dining_in,takeaway,delivery',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ];
    }
    
    public function prepareForValidation() 
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
            'is_inclusive' => $this->has('is_inclusive'),
        ]);
    }
}
