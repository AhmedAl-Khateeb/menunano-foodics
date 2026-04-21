<?php

namespace App\Models;

use App\Traits\ShiftTrait;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use ShiftTrait;

    protected $fillable = [
        'user_id',
        'branch_id',
        'starting_cash',
        'ending_cash',
        'start_time',
        'end_time',
        'status',
        'notes',
        'expected_cash',
        'cash_difference',
        'closed_by',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'starting_cash' => 'decimal:2',
        'ending_cash' => 'decimal:2',
        'expected_cash' => 'decimal:2',
        'cash_difference' => 'decimal:2',
    ];

  

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    public function isPaused(): bool
    {
        return $this->status === 'paused';
    }
}
