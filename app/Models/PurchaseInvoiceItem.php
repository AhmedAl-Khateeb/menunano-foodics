<?php

namespace App\Models;

use App\Traits\PurchaseInvoiceItemTrait;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceItem extends Model
{
    use PurchaseInvoiceItemTrait;

    protected $fillable = [
        'purchase_invoice_id',
        'inventory_id',
        'quantity',
        'unit_price',
        'total',
    ];

 
}

