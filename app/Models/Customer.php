<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
    ];

    /**
     * Get the store owner that this customer belongs to
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all cart items for this customer
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Format phone number to include country code
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = str_starts_with($value, '+2')
            ? $value
            : '+20' . ltrim($value, '0+');
    }
}
