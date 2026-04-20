<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'request_date' => ['required', 'date'],
            'notes'        => ['nullable', 'string'],
            'items'        => ['required', 'array', 'min:1'],
            'items.*.raw_material_id'    => ['required', 'exists:raw_materials,id'],
            'items.*.unit_id'            => ['nullable', 'exists:units,id'],
            'items.*.requested_quantity' => ['required', 'numeric', 'min:0.001'],
            'items.*.notes'              => ['nullable', 'string'],
        ];
    }
}