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
        'Purchase_price',
        'selling_price',
        'category_id',
        'type',
        'price',
        'barcode',
    ];

    protected $casts = [
        'Purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function charges()
    {
        return $this->morphToMany(Charge::class, 'chargeable');
    }

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

        $builder->when($category_id, function ($builder, $value) {
            $builder->where('category_id', $value);
        });
    }

    public function getCoverUrlAttribute()
    {
        return asset("storage/{$this->cover}");
    }

    public function getPosSellingPriceAttribute()
    {
        return (float) ($this->selling_price ?? $this->price ?? 0);
    }

    public function getPosPurchasePriceAttribute()
    {
        return (float) ($this->Purchase_price ?? 0);
    }

    public function getMaxProductionQuantityAttribute()
    {
        if ($this->recipes->isEmpty()) {
            return 0;
        }

        $min_production = null;

        foreach ($this->recipes->whereNull('product_size_id') as $recipe) {
            if (!$recipe->ingredient || !$recipe->ingredient->inventory) {
                continue;
            }

            $ingredient_stock = max(0, $recipe->ingredient->inventory->current_quantity ?? 0);

            if ($ingredient_stock <= 0) {
                $min_production = 0;
                break;
            }

            if ($recipe->quantity <= 0) {
                continue;
            }

            $possible = (int) floor($ingredient_stock / $recipe->quantity);

            if ($min_production === null || $possible < $min_production) {
                $min_production = $possible;
            }
        }

        return $min_production ?? 0;
    }

    // make barcode
    protected static function booted()
    {
        static::created(function ($product) {
            if (!$product->barcode) {
                $product->barcode = self::makeEan13Barcode('20', $product->id);
                $product->saveQuietly();
            }
        });
    }

    private static function makeEan13Barcode($prefix, $id)
    {
        $base = $prefix.str_pad($id, 10, '0', STR_PAD_LEFT);

        $sum = 0;

        for ($i = 0; $i < 12; ++$i) {
            $digit = (int) $base[$i];
            $sum += ($i % 2 === 0) ? $digit : $digit * 3;
        }

        $checkDigit = (10 - ($sum % 10)) % 10;

        return $base.$checkDigit;
    }
}
