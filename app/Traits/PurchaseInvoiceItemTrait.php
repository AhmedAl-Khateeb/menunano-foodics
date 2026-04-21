<?php

namespace App\Traits;

use App\Models\Inventory;
use App\Models\PurchaseInvoice;

trait PurchaseInvoiceItemTrait
{
    public function invoice()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
