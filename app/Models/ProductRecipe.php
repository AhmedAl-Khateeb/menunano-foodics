<?php

namespace App\Models;

use App\Traits\ProductRecipeTrait;
use Illuminate\Database\Eloquent\Model;

class ProductRecipe extends Model
{
    use ProductRecipeTrait;

    protected $fillable = [
        'product_id',
        'ingredient_id',
        'quantity',
        'unit_id',
        'product_size_id'
    ];

}
