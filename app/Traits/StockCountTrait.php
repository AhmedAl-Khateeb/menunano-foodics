<?php

namespace App\Traits;

use App\Models\StockCountItem;
use App\Models\User;

trait StockCountTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(StockCountItem::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
