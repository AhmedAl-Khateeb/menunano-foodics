<?php

namespace App\Models;

use App\Traits\ProductionOrderItemTrait;
use Illuminate\Database\Eloquent\Model;

class ProductionOrderItem extends Model
{
    use ProductionOrderItemTrait;

    protected $fillable = [
        'production_order_id',
        'raw_material_id',
        'unit_id',
        'planned_quantity',
        'consumed_quantity',
        'unit_cost',
        'total_cost',
    ];

    protected $casts = [
        'planned_quantity' => 'decimal:3',
        'consumed_quantity' => 'decimal:3',
        'unit_cost' => 'decimal:3',
        'total_cost' => 'decimal:3',
    ];


}
