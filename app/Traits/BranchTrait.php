<?php

namespace App\Traits;

use App\Models\CashTransfer;
use App\Models\Shift;
use App\Models\ShiftExpense;
use App\Models\User;

trait BranchTrait
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function shiftExpenses()
    {
        return $this->hasMany(ShiftExpense::class);
    }

    public function cashTransfers()
    {
        return $this->hasMany(CashTransfer::class);
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}
