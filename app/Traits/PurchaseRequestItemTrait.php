<?php

namespace App\Traits;

use App\Models\PurchaseRequest;
use App\Models\RawMaterial;
use App\Models\Unit;

trait PurchaseRequestItemTrait
{
    public function request()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
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
