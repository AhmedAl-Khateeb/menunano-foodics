<?php

namespace App\Traits;

use App\Models\PurchaseInvoiceItem;
use App\Models\Supplier;
use App\Models\User;

trait PurchaseInvoiceTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseInvoiceItem::class);
    }
}
