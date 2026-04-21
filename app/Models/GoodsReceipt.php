<?php

namespace App\Models;

use App\Traits\GoodsReceiptTrait;
use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    use GoodsReceiptTrait;

    protected $fillable = [
        'user_id',
        'purchase_order_id',
        'supplier_id',
        'receipt_number',
        'receipt_date',
        'status',
        'subtotal',
        'discount',
        'tax',
        'total',
        'notes',
    ];

    protected $casts = [
        'receipt_date' => 'date',
        'subtotal' => 'decimal:3',
        'discount' => 'decimal:3',
        'tax' => 'decimal:3',
        'total' => 'decimal:3',
    ];


}