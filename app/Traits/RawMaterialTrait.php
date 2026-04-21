<?php

namespace App\Traits;

use App\Models\Inventory;
use App\Models\InventoryCategory;
use App\Models\Recipe;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;

trait RawMaterialTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(InventoryCategory::class, 'inventory_category_id');
    }

    public function defaultSupplier()
    {
        return $this->belongsTo(Supplier::class, 'default_supplier_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'purchase_unit_id');
    }

    public function inventory()
    {
        return $this->morphOne(Inventory::class, 'inventoriable');
    }

    public function recipe()
    {
        return $this->hasOne(Recipe::class, 'output_raw_material_id');
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'supplier_raw_materials')
            ->withPivot([
                'id',
                'unit_id',
                'supplier_item_code',
                'order_quantity',
                'conversion_factor',
                'purchase_cost',
                'is_preferred',
                'notes',
            ])
            ->withTimestamps();
    }
}
