<?php

namespace App\Models;

use App\Traits\StockCountItemTrait;
use Illuminate\Database\Eloquent\Model;

class StockCountItem extends Model
{
    use StockCountItemTrait;

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
}
