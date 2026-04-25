<?php

namespace App\Models;

use App\Traits\OrderTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use OrderTrait;

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
        'shift_id',
    ];

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

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function scopeFilter(Builder $builder)
    {
        $status = request()->query('status') ?? null;
        $builder->when($status, function ($builder, $value) {
            $builder->where('status', $value);
        });
    }
}
