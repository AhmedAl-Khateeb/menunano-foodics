<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'user_id',
        'supplier_id',
        'purchase_request_id',
        'po_number',
        'po_date',
        'expected_date',
        'status',
        'subtotal',
        'discount',
        'tax',
        'total',
        'notes',
    ];

    protected $casts = [
        'po_date' => 'date',
        'expected_date' => 'date',
        'subtotal' => 'decimal:3',
        'discount' => 'decimal:3',
        'tax' => 'decimal:3',
        'total' => 'decimal:3',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function request()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function receipts()
    {
        return $this->hasMany(GoodsReceipt::class);
    }
}