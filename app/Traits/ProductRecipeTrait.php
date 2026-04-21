<?php

namespace App\Traits;

use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Unit;

trait ProductRecipeTrait
{
    public function size()
    {
        return $this->belongsTo(ProductSize::class, 'product_size_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Product::class, 'ingredient_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
