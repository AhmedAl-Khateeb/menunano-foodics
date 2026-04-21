<?php

namespace App\Traits;

use App\Models\ProductionOrder;
use App\Models\RawMaterial;
use App\Models\RecipeItem;
use App\Models\Unit;
use App\Models\User;

trait RecipeTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipeable()
    {
        return $this->morphTo();
    }

    public function yieldUnit()
    {
        return $this->belongsTo(Unit::class, 'yield_unit_id');
    }

    public function outputMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'output_raw_material_id');
    }

    public function items()
    {
        return $this->hasMany(RecipeItem::class);
    }

    public function productionOrders()
    {
        return $this->hasMany(ProductionOrder::class);
    }
}
