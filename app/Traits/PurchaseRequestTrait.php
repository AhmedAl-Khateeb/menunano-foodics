<?php

namespace App\Traits;

use App\Models\PurchaseRequestItem;
use App\Models\User;

trait PurchaseRequestTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
