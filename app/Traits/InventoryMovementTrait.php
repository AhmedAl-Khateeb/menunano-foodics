<?php

namespace App\Traits;

use App\Models\Inventory;
use App\Models\User;

trait InventoryMovementTrait
{
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
