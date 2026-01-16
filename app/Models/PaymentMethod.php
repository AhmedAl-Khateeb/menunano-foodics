<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['name', 'description', 'phone', 'is_active', 'created_by'];
    protected $casts = ['is_active' => 'boolean'];
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
