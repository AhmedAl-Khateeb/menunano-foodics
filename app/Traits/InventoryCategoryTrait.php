<?php

namespace App\Traits;

use App\Models\RawMaterial;
use App\Models\User;

trait InventoryCategoryTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rawMaterials()
    {
        return $this->hasMany(RawMaterial::class);
    }
}
