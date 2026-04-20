<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRawMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'inventory_category_id' => ['nullable', 'exists:inventory_categories,id'],
            'default_supplier_id' => ['nullable', 'exists:suppliers,id'],
            'purchase_unit_id' => ['nullable', 'exists:units,id'],
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:100'],
            'barcode' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'avg_cost' => ['nullable', 'numeric', 'min:0'],
            'last_cost' => ['nullable', 'numeric', 'min:0'],
            'reorder_level' => ['nullable', 'numeric', 'min:0'],
            'min_quantity' => ['nullable', 'numeric', 'min:0'],
            'max_quantity' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],

            'is_produced' => ['nullable', 'boolean'],
            'yield_quantity' => ['nullable', 'numeric', 'min:0.001'],
            'yield_unit_id' => ['nullable', 'exists:units,id'],
            'recipe_notes' => ['nullable', 'string'],

            'recipe_items' => ['nullable', 'array'],
            'recipe_items.*.raw_material_id' => ['nullable', 'exists:raw_materials,id'],
            'recipe_items.*.unit_id' => ['nullable', 'exists:units,id'],
            'recipe_items.*.quantity' => ['nullable', 'numeric', 'min:0.001'],
            'recipe_items.*.waste_percent' => ['nullable', 'numeric', 'min:0'],
            'recipe_items.*.notes' => ['nullable', 'string'],
        ];
    }
}
