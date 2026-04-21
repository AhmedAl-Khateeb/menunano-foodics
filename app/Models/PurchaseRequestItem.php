<?php

namespace App\Models;

use App\Traits\PurchaseRequestItemTrait;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
    use PurchaseRequestItemTrait;

    protected $fillable = [
        'purchase_request_id',
        'raw_material_id',
        'unit_id',
        'requested_quantity',
        'approved_quantity',
        'notes',
    ];

    protected $casts = [
        'requested_quantity' => 'decimal:3',
        'approved_quantity' => 'decimal:3',
    ];

}