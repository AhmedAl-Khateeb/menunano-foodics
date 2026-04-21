<?php

namespace App\Models;

use App\Traits\InventoryMovementTrait;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use InventoryMovementTrait;

    const TYPE_PURCHASE = 'purchase';
    const TYPE_SALE = 'sale';
    const TYPE_WASTE = 'waste';
    const TYPE_ADJUSTMENT = 'adjustment';
    const TYPE_TRANSFER_IN = 'transfer_in';
    const TYPE_TRANSFER_OUT = 'transfer_out';
    const TYPE_PRODUCTION_IN = 'production_in';
    const TYPE_PRODUCTION_OUT = 'production_out';

    protected $fillable = [
        'user_id',
        'inventory_id',
        'type',
        'quantity',
        'unit_cost',
        'total_cost',
        'balance_before',
        'balance_after',
        'reference_type',
        'reference_id',
        'description',
        'notes',
        'movement_date',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'unit_cost' => 'decimal:3',
        'total_cost' => 'decimal:3',
        'balance_before' => 'decimal:3',
        'balance_after' => 'decimal:3',
        'movement_date' => 'datetime',
    ];

}