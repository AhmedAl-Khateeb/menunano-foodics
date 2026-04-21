<?php

namespace App\Traits;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductRecipe;

trait ProductSizeTrait
{
    public function inventory()
    {
        return $this->morphOne(Inventory::class, 'inventoriable');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function recipes()
    {
        return $this->hasMany(ProductRecipe::class, 'product_size_id');
    }
}
