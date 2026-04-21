<?php

namespace App\Traits;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\User;

trait ShiftTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function closer()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }
}
