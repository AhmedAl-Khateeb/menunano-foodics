<?php

namespace App\Models;

use App\Traits\InventoryTrait;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use InventoryTrait;

    protected $fillable = [
        'inventoriable_id',
        'inventoriable_type',
        'purchase_price',
        'avg_cost',
        'last_cost',
        'purchase_unit_id',
        'current_quantity',
        'reorder_level',
        'min_quantity',
        'max_quantity',
        'is_active',
        'user_id',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:3',
        'avg_cost' => 'decimal:3',
        'last_cost' => 'decimal:3',
        'current_quantity' => 'decimal:3',
        'reorder_level' => 'decimal:3',
        'min_quantity' => 'decimal:3',
        'max_quantity' => 'decimal:3',
        'is_active' => 'boolean',
    ];
}
