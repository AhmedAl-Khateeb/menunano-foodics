<?php

namespace App\Traits;

use App\Models\Inventory;
use App\Models\StockCount;

trait StockCountItemTrait
{
    public function stockCount()
    {
        return $this->belongsTo(StockCount::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
