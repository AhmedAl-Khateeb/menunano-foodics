<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierRawMaterial extends Model
{
    protected $fillable = [
        'user_id',
        'supplier_id',
        'raw_material_id',
        'unit_id',
        'supplier_item_code',
        'order_quantity',
        'conversion_factor',
        'purchase_cost',
        'is_preferred',
        'notes',
    ];

    protected $casts = [
        'order_quantity' => 'decimal:3',
        'conversion_factor' => 'decimal:3',
        'purchase_cost' => 'decimal:3',
        'is_preferred' => 'boolean',
    ];

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
