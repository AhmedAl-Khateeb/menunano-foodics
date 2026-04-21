<?php

namespace App\Traits;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Subscription;
use App\Models\User;

trait UserTrait
{
    public function categories()
    {
        return $this->hasMany(Category::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function sliders()
    {
        return $this->hasMany(Slider::class);
    }

    public function settings()
    {
        return $this->hasMany(Setting::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }


    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
