<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferRequestItem extends Model
{
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

    public function transfer()
    {
        return $this->belongsTo(TransferRequest::class, 'transfer_request_id');
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}