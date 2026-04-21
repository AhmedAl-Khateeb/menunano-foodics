<?php

namespace App\Traits;

use App\Models\PurchaseOrder;
use App\Models\RawMaterial;
use App\Models\Unit;

trait PurchaseOrderItemTrait
{
    public function order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
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
