<?php

namespace App\Traits;

use App\Models\GoodsReceipt;
use App\Models\PurchaseOrder;
use App\Models\RawMaterial;
use App\Models\User;

trait SupplierTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function goodsReceipts()
    {
        return $this->hasMany(GoodsReceipt::class);
    }

    public function rawMaterials()
    {
        return $this->belongsToMany(RawMaterial::class, 'supplier_raw_materials')
            ->withPivot([
                'id',
                'unit_id',
                'supplier_item_code',
                'order_quantity',
                'conversion_factor',
                'purchase_cost',
                'is_preferred',
                'notes',
            ])
            ->withTimestamps();
    }
}
