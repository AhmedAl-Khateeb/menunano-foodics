<?php

namespace App\Traits;

use App\Models\ProductionOrder;
use App\Models\RawMaterial;
use App\Models\Unit;

trait ProductionOrderItemTrait
{
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
