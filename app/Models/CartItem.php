<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'customer_id',
        'product_size_id',
        'quantity',
        'branch_id',
    ];

    /**
     * Get the customer that owns this cart item.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the product size for this cart item.
     */
    public function productSize()
    {
        return $this->belongsTo(ProductSize::class)->with('product');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
