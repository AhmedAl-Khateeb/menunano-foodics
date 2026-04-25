<?php

namespace App\Traits;

use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\ProductSize;
use App\Models\Table;
use App\Models\User;

trait OrderTrait
{
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function deliveryMan()
    {
        return $this->belongsTo(DeliveryMan::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->belongsToMany(ProductSize::class, 'order_product_sizes')
            ->withPivot('price', 'quantity')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
