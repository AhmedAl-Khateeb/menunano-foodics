<?php

namespace App\Traits;

use App\Models\Branch;
use App\Models\TransferRequestItem;
use App\Models\User;

trait TransferRequestTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransferRequestItem::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
