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
        'address',
        'total_price',
        'status',
    ];

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
        $builder->when($status,function ($builder,$value){
            $builder->where('status',$value);
        });
    }
}
