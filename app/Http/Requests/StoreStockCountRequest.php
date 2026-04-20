<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockCountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'count_date' => ['required', 'date'],
            'type'       => ['required', 'in:full,spot'],
            'notes'      => ['nullable', 'string'],

            'items'                       => ['required', 'array', 'min:1'],
            'items.*.inventory_id'        => ['required', 'exists:inventories,id'],
            'items.*.physical_quantity'   => ['required', 'numeric', 'min:0'],
            'items.*.notes'               => ['nullable', 'string'],
        ];
    }
}