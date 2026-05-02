<?php

namespace App\Traits;

use App\Models\Branch;
use App\Models\Shift;
use App\Models\User;

trait AttendanceTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
