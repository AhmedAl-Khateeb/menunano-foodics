<?php

namespace App\Traits;

use App\Models\RawMaterial;
use App\Models\TransferRequest;
use App\Models\Unit;

trait TransferRequestItemTrait
{
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
