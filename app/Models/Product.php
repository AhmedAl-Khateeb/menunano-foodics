<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'cover',
        'price',
        'category_id',
        'type'
    ];

    public function inventory()
    {
        return $this->morphOne(Inventory::class, 'inventoriable');
    }

    public function recipes()
    {
        return $this->hasMany(ProductRecipe::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function user()
    {
       return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeCategoryFilter(Builder $builder)
    {
        $category_id = request()->query('category') ?? null;
        $builder->when($category_id,function ($builder,$value){
            $builder->where('category_id',$value);
        });
    }

    public function getCoverUrlAttribute()
    {
        return asset("storage/{$this->cover}");
    }

    public function getMaxProductionQuantityAttribute()
    {
        if ($this->recipes->isEmpty())  return 0;
        
        $min_production = null;
        foreach ($this->recipes->whereNull('product_size_id') as $recipe) {
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
}
