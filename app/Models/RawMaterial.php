<?php

namespace App\Models;

use App\Traits\RawMaterialTrait;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use RawMaterialTrait;

    protected $fillable = [
        'user_id',
        'inventory_category_id',
        'default_supplier_id',
        'purchase_unit_id',
        'name',
        'sku',
        'barcode',
        'description',
        'purchase_price',
        'avg_cost',
        'last_cost',
        'reorder_level',
        'min_quantity',
        'max_quantity',
        'is_active',
        'is_produced',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:3',
        'avg_cost' => 'decimal:3',
        'last_cost' => 'decimal:3',
        'reorder_level' => 'decimal:3',
        'min_quantity' => 'decimal:3',
        'max_quantity' => 'decimal:3',
        'is_active' => 'boolean',
        'is_produced' => 'boolean',
    ];

}
