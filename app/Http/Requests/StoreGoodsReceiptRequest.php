<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGoodsReceiptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'purchase_order_id' => ['nullable', 'exists:purchase_orders,id'],
            'supplier_id'       => ['required', 'exists:suppliers,id'],
            'receipt_date'      => ['required', 'date'],
            'subtotal'          => ['nullable', 'numeric', 'min:0'],
            'discount'          => ['nullable', 'numeric', 'min:0'],
            'tax'               => ['nullable', 'numeric', 'min:0'],
            'total'             => ['nullable', 'numeric', 'min:0'],
            'notes'             => ['nullable', 'string'],

            'items'                          => ['required', 'array', 'min:1'],
            'items.*.raw_material_id'        => ['required', 'exists:raw_materials,id'],
            'items.*.purchase_order_item_id' => ['nullable', 'exists:purchase_order_items,id'],
            'items.*.unit_id'                => ['nullable', 'exists:units,id'],
            'items.*.quantity'               => ['required', 'numeric', 'min:0.001'],
            'items.*.unit_cost'              => ['required', 'numeric', 'min:0'],
        ];
    }
}