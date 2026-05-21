<?php

namespace App\Models;

use App\Traits\ProductSizeTrait;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use ProductSizeTrait;

    protected $fillable = [
        'size',
        'price',
        'product_id',
        'Purchase_price',
        'selling_price',
        'barcode',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'Purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function recipes()
    {
        return $this->hasMany(ProductRecipe::class, 'product_size_id');
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
        $commonRecipes = $this->product->recipes()->whereNull('product_size_id')->get();
        $specificRecipes = $this->recipes;

        $allRecipes = $commonRecipes->concat($specificRecipes);

        if ($allRecipes->isEmpty()) {
            return 0;
        }

        $min_production = null;

        foreach ($allRecipes as $recipe) {
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

    // barcode generation logic
    protected static function booted()
    {
        static::created(function ($size) {
            if (!$size->barcode) {
                $size->barcode = self::makeEan13Barcode('21', $size->id);
                $size->saveQuietly();
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
