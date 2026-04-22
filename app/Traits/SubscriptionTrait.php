<?php

namespace App\Traits;

use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\User;

trait SubscriptionTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
