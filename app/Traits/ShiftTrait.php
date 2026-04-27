<?php

namespace App\Traits;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\CashTransfer;
use App\Models\ShiftExpense;
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

    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    // مصروفات تمت من درج هذا الشيفت
    public function expenses()
    {
        return $this->hasMany(ShiftExpense::class);
    }

    // تحويلات خارجة من هذا الشيفت
    public function outgoingCashTransfers()
    {
        return $this->hasMany(CashTransfer::class, 'from_shift_id');
    }

    // تحويلات داخلة لهذا الشيفت من شيفت سابق
    public function incomingCashTransfers()
    {
        return $this->hasMany(CashTransfer::class, 'to_shift_id');
    }

    // المبلغ المرحل للشيفت التالي
    public function nextShiftTransfer()
    {
        return $this->hasOne(CashTransfer::class, 'from_shift_id')
            ->where('type', 'to_next_shift');
    }

    // المبلغ المسلم للمدير / الخزنة
    public function managerTransfers()
    {
        return $this->hasMany(CashTransfer::class, 'from_shift_id')
            ->whereIn('type', ['to_manager', 'to_safe']);
    }
}
