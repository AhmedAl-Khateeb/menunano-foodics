<?php

namespace App\Models;

use App\Traits\SupplierRawMaterialTrait;
use Illuminate\Database\Eloquent\Model;

class SupplierRawMaterial extends Model
{
    use SupplierRawMaterialTrait;

    protected $fillable = [
        'user_id',
        'supplier_id',
        'raw_material_id',
        'unit_id',
        'supplier_item_code',
        'order_quantity',
        'conversion_factor',
        'purchase_cost',
        'is_preferred',
        'notes',
    ];

    protected $casts = [
        'order_quantity' => 'decimal:3',
        'conversion_factor' => 'decimal:3',
        'purchase_cost' => 'decimal:3',
        'is_preferred' => 'boolean',
    ];


}
