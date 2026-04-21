<?php

namespace App\Models;

use App\Traits\GoodsReceiptItemTrait;
use Illuminate\Database\Eloquent\Model;

class GoodsReceiptItem extends Model
{
    use GoodsReceiptItemTrait;

    protected $fillable = [
        'goods_receipt_id',
        'raw_material_id',
        'purchase_order_item_id',
        'unit_id',
        'quantity',
        'unit_cost',
        'total_cost',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'unit_cost' => 'decimal:3',
        'total_cost' => 'decimal:3',
    ];

}
