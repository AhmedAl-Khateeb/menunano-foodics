<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    protected $fillable = [
        'user_id',
        'inventory_category_id',
        'default_supplier_id',
        'purchase_unit_id',
        'name',
        'sku',
        'barcode',
        'description',
        'purchase_price',
        'avg_cost',
        'last_cost',
        'reorder_level',
        'min_quantity',
        'max_quantity',
        'is_active',
        'is_produced',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:3',
        'avg_cost' => 'decimal:3',
        'last_cost' => 'decimal:3',
        'reorder_level' => 'decimal:3',
        'min_quantity' => 'decimal:3',
        'max_quantity' => 'decimal:3',
        'is_active' => 'boolean',
        'is_produced' => 'boolean',
    ];

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
