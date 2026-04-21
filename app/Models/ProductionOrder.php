<?php

namespace App\Models;

use App\Traits\ProductionOrderTrait;
use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model
{
    use ProductionOrderTrait;

    protected $fillable = [
        'user_id',
        'recipe_id',
        'production_number',
        'production_date',
        'planned_quantity',
        'produced_quantity',
        'status',
        'total_cost',
        'notes',
    ];

    protected $casts = [
        'production_date' => 'date',
        'planned_quantity' => 'decimal:3',
        'produced_quantity' => 'decimal:3',
        'total_cost' => 'decimal:3',
    ];

 
}