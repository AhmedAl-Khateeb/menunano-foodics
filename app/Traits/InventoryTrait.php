<?php

namespace App\Traits;

use App\Models\InventoryMovement;
use App\Models\Unit;
use App\Models\User;

trait InventoryTrait
{
        public function inventoriable()
    {
        return $this->morphTo();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'purchase_unit_id');
    }

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
