<?php

namespace App\Traits;

use App\Models\GoodsReceipt;
use App\Models\PurchaseOrderItem;
use App\Models\RawMaterial;
use App\Models\Unit;

trait GoodsReceiptItemTrait
{
    public function receipt()
    {
        return $this->belongsTo(GoodsReceipt::class, 'goods_receipt_id');
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function purchaseOrderItem()
    {
        return $this->belongsTo(PurchaseOrderItem::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
