<?php

namespace App\Models;

use App\Traits\PurchaseOrderTrait;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use PurchaseOrderTrait;

    protected $fillable = [
        'user_id',
        'supplier_id',
        'purchase_request_id',
        'po_number',
        'po_date',
        'expected_date',
        'status',
        'subtotal',
        'discount',
        'tax',
        'total',
        'notes',
    ];

    protected $casts = [
        'po_date' => 'date',
        'expected_date' => 'date',
        'subtotal' => 'decimal:3',
        'discount' => 'decimal:3',
        'tax' => 'decimal:3',
        'total' => 'decimal:3',
    ];
}