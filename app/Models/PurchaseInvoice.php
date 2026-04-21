<?php

namespace App\Models;

use App\Traits\PurchaseInvoiceTrait;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use PurchaseInvoiceTrait;

    protected $fillable = [
        'user_id',
        'supplier_id',
        'invoice_number',
        'total_amount',
        'paid_amount',
        'due_date',
        'notes',
        'status',
    ];

 
}

