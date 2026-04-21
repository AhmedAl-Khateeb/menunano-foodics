<?php

namespace App\Models;

use App\Traits\TransferRequestItemTrait;
use Illuminate\Database\Eloquent\Model;

class TransferRequestItem extends Model
{
    use TransferRequestItemTrait;

    protected $fillable = [
        'transfer_request_id',
        'raw_material_id',
        'unit_id',
        'requested_quantity',
        'sent_quantity',
        'received_quantity',
        'notes',
    ];

    protected $casts = [
        'requested_quantity' => 'decimal:3',
        'sent_quantity' => 'decimal:3',
        'received_quantity' => 'decimal:3',
    ];

 
}