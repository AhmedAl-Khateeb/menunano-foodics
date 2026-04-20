<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'name',
        'phone',
        'email',
        'address',
        'tax_number',
        'commercial_register',
        'balance',
        'opening_balance',
        'current_balance',
        'credit_limit',
        'payment_terms',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'balance' => 'decimal:3',
        'opening_balance' => 'decimal:3',
        'current_balance' => 'decimal:3',
        'credit_limit' => 'decimal:3',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function goodsReceipts()
    {
        return $this->hasMany(GoodsReceipt::class);
    }

    public function rawMaterials()
    {
        return $this->hasMany(RawMaterial::class, 'default_supplier_id');
    }
}