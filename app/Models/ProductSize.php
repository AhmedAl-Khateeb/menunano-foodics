<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $fillable = [
        'size',
        'price',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function recipes()
    {
        return $this->hasMany(ProductRecipe::class, 'product_size_id');
    }

    public function getMaxProductionQuantityAttribute()
    {
        // Combine Common Ingredients (null size) and Specific Ingredients
        $commonRecipes = $this->product->recipes()->whereNull('product_size_id')->get();
        $specificRecipes = $this->recipes;
        
        $allRecipes = $commonRecipes->concat($specificRecipes);

        if ($allRecipes->isEmpty()) return 0;
        
        $min_production = null;
        foreach ($allRecipes as $recipe) {
            if (!$recipe->ingredient || !$recipe->ingredient->inventory) continue;
            
            $ingredient_stock = max(0, $recipe->ingredient->inventory->current_quantity ?? 0);
            
            // If any ingredient is out of stock, max production is zero
            if ($ingredient_stock <= 0) {
                $min_production = 0;
                break;
            }
            
            // Prevent division by zero and invalid recipe quantities
            if ($recipe->quantity <= 0) continue;
            
            $possible = (int) floor($ingredient_stock / $recipe->quantity);
            
            if ($min_production === null || $possible < $min_production) {
                $min_production = $possible;
            }
        }
        return $min_production ?? 0;
    }

    public function inventory()
    {
        return $this->morphOne(Inventory::class, 'inventoriable');
    }
}
