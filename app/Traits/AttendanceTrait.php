<?php

namespace App\Traits;

use App\Models\Branch;
use App\Models\Shift;
use App\Models\staff;

trait AttendanceTrait
{
    public function staff()
    {
        return $this->belongsTo(staff::class);
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
