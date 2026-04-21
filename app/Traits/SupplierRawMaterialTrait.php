<?php

namespace App\Traits;

use App\Models\RawMaterial;
use App\Models\Supplier;
use App\Models\Unit;

trait SupplierRawMaterialTrait
{
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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
