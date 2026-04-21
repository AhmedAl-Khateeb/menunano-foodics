<?php

namespace App\Traits;

use App\Models\RawMaterial;
use App\Models\Recipe;
use App\Models\Unit;

trait RecipeItemTrait
{
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
