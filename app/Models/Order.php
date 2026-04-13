<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'user_id',
        'customer_id',
        'address',
        'total_price',
        'payment_method',
        'payment_proof',
        'source',
        'paid_amount',
        'change_amount',
        'status',
        'type',
        'table_id',
        'delivery_fee',
        'delivery_man_id',
    ];

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

    //    public function scopeOwnedBy(Builder $query, $userId): Builder
    public function scopeOwnedBy(Builder $query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeDelivery(Builder $query): Builder
    {
        return $query->where('type', 'delivery');
    }

    public function scopePickup(Builder $query): Builder
    {
        return $query->where('type', 'takeaway');
    }

    public function scopeLocal(Builder $query): Builder
    {
        return $query->whereIn('type', ['table', 'free_seating']);
    }

    public function items()
    {
        return $this->belongsToMany(ProductSize::class, 'order_product_sizes')
            ->withPivot('price', 'quantity')
            ->withTimestamps();
    }

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFilter(Builder $builder)
    {
        $status = request()->query('status') ?? null;
        $builder->when($status, function ($builder, $value) {
            $builder->where('status', $value);
        });
    }
}
