<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';

    protected $fillable = [
        'inventoriable_id',
        'inventoriable_type',
        'purchase_price',
        'purchase_unit_id',
        'current_quantity',
        'user_id'
    ];

    public function inventoriable()
    {
        return $this->morphTo();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'purchase_unit_id');
    }

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
