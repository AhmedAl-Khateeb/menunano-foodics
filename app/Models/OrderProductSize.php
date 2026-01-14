<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProductSize extends Model
{
    protected $fillable = [
        'order_id',
        'product_size_id',
        'price',
        'quantity'
    ];
}
