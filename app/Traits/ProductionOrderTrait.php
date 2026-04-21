<?php

namespace App\Traits;

use App\Models\ProductionOrderItem;
use App\Models\Recipe;
use App\Models\User;

trait ProductionOrderTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function items()
    {
        return $this->hasMany(ProductionOrderItem::class);
    }
}
