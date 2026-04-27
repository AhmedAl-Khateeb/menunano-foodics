<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashTransfer extends Model
{
    protected $table = 'cash_transfers';

    protected $fillable = [
        'from_shift_id',
        'to_shift_id',
        'branch_id',
        'from_user_id',
        'to_user_id',
        'type',
        'amount',
        'status',
        'approved_by',
        'notes',
    ];

    protected $casts = [
        'from_shift_id' => 'integer',
        'to_shift_id' => 'integer',
        'branch_id' => 'integer',
        'from_user_id' => 'integer',
        'to_user_id' => 'integer',
        'amount' => 'float',
        'approved_by' => 'integer',
        'type' => 'string',
        'status' => 'string',
        'notes' => 'string',
    ];


    
    // الشيفت الذي خرج منه المبلغ
    public function fromShift()
    {
        return $this->belongsTo(Shift::class, 'from_shift_id');
    }

    // الشيفت الذي استلم المبلغ المرحل
    public function toShift()
    {
        return $this->belongsTo(Shift::class, 'to_shift_id');
    }

    // الفرع
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // الكاشير الذي أرسل المبلغ
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    // المدير أو الكاشير التالي الذي استلم المبلغ
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    // المستخدم الذي اعتمد التحويل
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            'to_manager' => 'تسليم للمدير',
            'to_next_shift' => 'ترحيل للشيفت التالي',
            'to_safe' => 'إيداع في الخزنة',
            default => $this->type,
        };
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
