<?php

namespace App\Traits;

use App\Models\GoodsReceiptItem;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\User;

trait GoodsReceiptTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(GoodsReceiptItem::class);
    }
}
