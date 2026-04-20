<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductionOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'recipe_id'         => ['required', 'exists:recipes,id'],
            'production_date'   => ['required', 'date'],
            'planned_quantity'  => ['required', 'numeric', 'min:0.001'],
            'produced_quantity' => ['required', 'numeric', 'min:0.001'],
            'notes'             => ['nullable', 'string'],

            'items'                        => ['required', 'array', 'min:1'],
            'items.*.raw_material_id'      => ['required', 'exists:raw_materials,id'],
            'items.*.unit_id'              => ['nullable', 'exists:units,id'],
            'items.*.planned_quantity'     => ['required', 'numeric', 'min:0.001'],
            'items.*.consumed_quantity'    => ['required', 'numeric', 'min:0.001'],
        ];
    }
}