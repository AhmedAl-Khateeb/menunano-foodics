<?php

namespace App\Models;

use App\Traits\PurchaseOrderItemTrait;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use PurchaseOrderItemTrait;

    protected $fillable = [
        'purchase_order_id',
        'raw_material_id',
        'unit_id',
        'quantity',
        'received_quantity',
        'unit_price',
        'total',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'received_quantity' => 'decimal:3',
        'unit_price' => 'decimal:3',
        'total' => 'decimal:3',
    ];

}