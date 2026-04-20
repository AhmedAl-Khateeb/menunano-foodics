<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionOrderItem extends Model
{
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

    public function productionOrder()
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
