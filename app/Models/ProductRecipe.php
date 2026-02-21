<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRecipe extends Model
{
    protected $fillable = [
        'product_id',
        'ingredient_id',
        'quantity',
        'unit_id',
        'product_size_id'
    ];

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
