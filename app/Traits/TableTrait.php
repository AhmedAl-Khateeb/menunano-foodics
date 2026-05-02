<?php

namespace App\Traits;

use App\Models\Branch;
use App\Models\DiningArea;
use App\Models\Order;

trait TableTrait
{
    public function diningArea()
    {
        return $this->belongsTo(DiningArea::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
