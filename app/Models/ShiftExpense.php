<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftExpense extends Model
{
    protected $table = 'shift_expenses';

    protected $fillable = [
        'shift_id',
        'user_id',
        'branch_id',
        'title',
        'amount',
        'expense_date',
        'status',
        'approved_by',
        'notes',
        'receipt_image',
    ];

    protected $casts = [
        'expense_date' => 'datetime',
        'amount' => 'float',
        'approved_by' => 'integer',
        'branch_id' => 'integer',
        'user_id' => 'integer',
        'shift_id' => 'integer',
        'receipt_image' => 'string',
        'status' => 'string',
        'notes' => 'string',
        'title' => 'string',
    ];


    
    // الشيفت الذي خرج منه المصروف
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    // الكاشير الذي سجل المصروف
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // الفرع
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // المدير الذي اعتمد المصروف
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'قيد المراجعة',
            'approved' => 'معتمد',
            'rejected' => 'مرفوض',
            default => $this->status,
        };
    }
}
