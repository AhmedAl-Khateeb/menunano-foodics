<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'name',
        'contact_name',
        'phone',
        'email',
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

    // public function rawMaterials()
    // {
    //     return $this->hasMany(RawMaterial::class, 'default_supplier_id');
    // }

    public function rawMaterials()
    {
        return $this->belongsToMany(RawMaterial::class, 'supplier_raw_materials')
            ->withPivot([
                'id',
                'unit_id',
                'supplier_item_code',
                'order_quantity',
                'conversion_factor',
                'purchase_cost',
                'is_preferred',
                'notes',
            ])
            ->withTimestamps();
    }
}
