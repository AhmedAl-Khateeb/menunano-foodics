<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockCountItem extends Model
{
    protected $fillable = [
        'stock_count_id',
        'inventory_id',
        'system_quantity',
        'physical_quantity',
        'difference_quantity',
        'notes',
    ];

    protected $casts = [
        'system_quantity' => 'decimal:3',
        'physical_quantity' => 'decimal:3',
        'difference_quantity' => 'decimal:3',
    ];

    public function stockCount()
    {
        return $this->belongsTo(StockCount::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}