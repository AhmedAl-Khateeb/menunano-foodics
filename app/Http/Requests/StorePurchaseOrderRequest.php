<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'supplier_id'          => ['required', 'exists:suppliers,id'],
            'purchase_request_id'  => ['nullable', 'exists:purchase_requests,id'],
            'po_date'              => ['required', 'date'],
            'expected_date'        => ['nullable', 'date'],
            'subtotal'             => ['nullable', 'numeric', 'min:0'],
            'discount'             => ['nullable', 'numeric', 'min:0'],
            'tax'                  => ['nullable', 'numeric', 'min:0'],
            'total'                => ['nullable', 'numeric', 'min:0'],
            'notes'                => ['nullable', 'string'],

            'items'                        => ['required', 'array', 'min:1'],
            'items.*.raw_material_id'      => ['required', 'exists:raw_materials,id'],
            'items.*.unit_id'              => ['nullable', 'exists:units,id'],
            'items.*.quantity'             => ['required', 'numeric', 'min:0.001'],
            'items.*.unit_price'           => ['required', 'numeric', 'min:0'],
            'items.*.notes'                => ['nullable', 'string'],
        ];
    }
}