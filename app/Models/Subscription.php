<?php

namespace App\Models;

use App\Traits\SubscriptionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    use SubscriptionTrait;

    protected $fillable = [
        'user_id',
        'package_id',
        'payment_method_id',
        'phone',
        'receipt_image',
        'status',
        'starts_at',
        'ends_at',
        'is_active',
        'price_paid',
    ];

    public function isCurrentlyActive(): bool
    {
        return $this->is_active
            && $this->status === 'active'
            && $this->starts_at
            && $this->ends_at
            && now()->between($this->starts_at, $this->ends_at);
    }
}
