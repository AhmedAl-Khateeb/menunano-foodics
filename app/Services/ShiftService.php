<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\CashTransfer;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Shift;
use App\Models\ShiftExpense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class ShiftService
{
    public function getPaginated(array $filters = []): LengthAwarePaginator
    {
        $query = Shift::with(['user', 'branch', 'closer'])->latest();

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->paginate(10)->appends($filters);
    }

    public function getUsers()
    {
        return User::orderBy('name')->get();
    }

    public function getStores()
    {
        return Branch::orderBy('name')->get();
    }

    public function create(array $data): Shift
    {
        $this->ensureNoActiveShiftForUser($data['user_id']);

        $data['expected_cash'] = $data['expected_cash'] ?? 0;
        $data['cash_difference'] = $this->calculateCashDifference(
            $data['expected_cash'],
            $data['ending_cash'] ?? null
        );

        if (empty($data['start_time'])) {
            $data['start_time'] = now();
        }

        $shift = Shift::create($data);

        Attendance::firstOrCreate(
            [
                'user_id' => $shift->user_id,
                'attendance_date' => Carbon::parse($shift->start_time)->toDateString(),
            ],
            [
                'shift_id' => $shift->id,
                'check_in' => $shift->start_time,
                'status' => 'present',
                'notes' => 'تم إنشاء السجل تلقائيًا عند فتح الشيفت',
            ]
        );

        return $shift;
    }

    public function update(Shift $shift, array $data): Shift
    {
        if ($shift->status === 'closed') {
            throw ValidationException::withMessages(['status' => ['لا يمكن تعديل شيفت مغلق']]);
        }

        $newUserId = $data['user_id'] ?? $shift->user_id;
        $newStatus = $data['status'] ?? $shift->status;

        if ($newStatus === 'active') {
            $this->ensureNoActiveShiftForUser($newUserId, $shift->id);
        }

        if ($newStatus === 'closed' && empty($data['closed_by'])) {
            $data['closed_by'] = auth()->id();
        }

        if ($newStatus === 'closed' && empty($data['end_time'])) {
            $data['end_time'] = now();
        }

        $expectedCash = $data['expected_cash'] ?? $shift->expected_cash ?? 0;
        $endingCash = array_key_exists('ending_cash', $data) ? $data['ending_cash'] : $shift->ending_cash;

        $data['cash_difference'] = $this->calculateCashDifference($expectedCash, $endingCash);

        $shift->update($data);

        if (($data['status'] ?? null) === 'closed') {
            $attendance = Attendance::where('shift_id', $shift->id)->first();

            if ($attendance) {
                $attendance->update([
                    'check_out' => $data['end_time'] ?? now(),
                ]);
            }
        }

        return $shift->fresh();
    }

    public function delete(Shift $shift): bool
    {
        return $shift->delete();
    }

    protected function ensureNoActiveShiftForUser(int $userId, ?int $ignoreId = null): void
    {
        $query = Shift::where('user_id', $userId)->where('status', 'active');

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages(['user_id' => ['هذا الموظف لديه شيفت نشط بالفعل']]);
        }
    }

    protected function calculateCashDifference($expectedCash, $endingCash): float
    {
        if ($endingCash === null || $endingCash === '') {
            return 0;
        }

        return (float) $endingCash - (float) $expectedCash;
    }

    protected function getCashPaymentValues(): array
    {
        $values = ['cash', 'كاش', 'نقدي'];

        if (class_exists(PaymentMethod::class)) {
            $paymentMethodIds = PaymentMethod::query()
                ->where(function ($query) {
                    $query->where('name', 'like', '%cash%')
                        ->orWhere('name', 'like', '%كاش%')
                        ->orWhere('name', 'like', '%نقد%');
                })
                ->pluck('id')
                ->map(fn ($id) => (string) $id)
                ->toArray();

            $values = array_merge($values, $paymentMethodIds);
        }

        return array_unique($values);
    }

   

    public function calculateCashSalesForShift(Shift $shift): float
    {
        return (float) Order::where('shift_id', $shift->id)
            ->whereIn('payment_method', $this->getCashPaymentValues())
            ->selectRaw('COALESCE(SUM(COALESCE(paid_amount, 0) - COALESCE(change_amount, 0)), 0) as total')
            ->value('total');
    }

    public function calculateExpensesForShift(Shift $shift): float
    {
        return (float) ShiftExpense::where('shift_id', $shift->id)
            ->whereIn('status', ['approved', 'pending'])
            ->sum('amount');
    }

    public function calculateTransfersToManagerForShift(Shift $shift): float
    {
        return (float) CashTransfer::where('from_shift_id', $shift->id)
            ->whereIn('type', ['to_manager', 'to_safe'])
            ->whereIn('status', ['approved', 'pending'])
            ->sum('amount');
    }

    public function calculateExpectedCashForShift(Shift $shift): float
    {
        $cashSales = $this->calculateCashSalesForShift($shift);
        $expenses = $this->calculateExpensesForShift($shift);
        $transfersToManager = $this->calculateTransfersToManagerForShift($shift);

        return (float) $shift->starting_cash
            + (float) $cashSales
            - (float) $expenses
            - (float) $transfersToManager;
    }

    // تحديث دالة إغلاق الشيفت لتضمين عمليات التحويل النقدي للمدير وللشيفت التالي
    // تحديث دالة إغلاق الشيفت لتضمين المصروفات وتسليمات المدير وترحيل المتبقي للشيفت التالي
    public function closeShift(Shift $shift, array $data = []): Shift
    {
        $endingCash = (float) ($data['ending_cash'] ?? 0);

        /*
         * هذا اختياري:
         * لو عندك خانة داخل مودال الإغلاق اسمها sent_to_manager
         * يتم تسجيلها كحركة تسليم جديدة للمدير.
         * أما لو التسليم يتم من زر "تسليم للمدير" أثناء الشيفت،
         * ستظل القيمة هنا = 0 ولن يتم إنشاء حركة مكررة.
         */
        $closingSentToManager = (float) ($data['sent_to_manager'] ?? 0);

        if ($closingSentToManager > $endingCash) {
            throw ValidationException::withMessages(['sent_to_manager' => ['المبلغ المسلم للمدير لا يمكن أن يكون أكبر من رصيد نهاية الدرج.']]);
        }

        // لو تم إدخال مبلغ تسليم للمدير أثناء الإغلاق، نسجله كحركة نقدية
        if ($closingSentToManager > 0) {
            CashTransfer::create([
                'from_shift_id' => $shift->id,
                'to_shift_id' => null,
                'branch_id' => $shift->branch_id,

                'from_user_id' => $shift->user_id,
                'to_user_id' => $data['manager_id']
                    ?? User::where('role', 'admin')->value('id'),
                'type' => 'to_manager',
                'amount' => $closingSentToManager,
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'notes' => $data['notes'] ?? 'تسليم مبلغ للمدير عند إغلاق الشيفت',
            ]);
        }

        /*
         * مهم:
         * نحسب الإجماليات بعد تسجيل أي تسليم جديد للمدير
         */
        $expensesTotal = $this->calculateExpensesForShift($shift);

        $transfersToManagerTotal = $this->calculateTransfersToManagerForShift($shift);

        $expectedCash = $this->calculateExpectedCashForShift($shift);

        /*
         * بعد خصم المصروفات وتسليمات المدير من المتوقع،
         * يصبح ending_cash هو المبلغ المتبقي فعليًا في الدرج.
         * وهذا هو المبلغ الذي سيُرحّل للشيفت التالي.
         */
        $carryoverToNextShift = $endingCash;

        $shift->update([
            'expenses_total' => $expensesTotal,
            'sent_to_manager' => $transfersToManagerTotal,
            'carryover_to_next_shift' => $carryoverToNextShift,

            'expected_cash' => $expectedCash,
            'ending_cash' => $endingCash,
            'cash_difference' => $endingCash - $expectedCash,

            'end_time' => now(),
            'status' => 'closed',
            'closed_by' => auth()->id(),
            'notes' => $data['notes'] ?? $shift->notes,
        ]);

        /*
         * ترحيل المتبقي للشيفت التالي.
         * لو المتبقي صفر، نحذف أي ترحيل قديم لنفس الشيفت.
         */
        if ($carryoverToNextShift > 0) {
            CashTransfer::updateOrCreate(
                [
                    'from_shift_id' => $shift->id,
                    'type' => 'to_next_shift',
                ],
                [
                    'to_shift_id' => null,
                    'branch_id' => $shift->branch_id,
                    'from_user_id' => $shift->user_id,
                    'to_user_id' => null,
                    'amount' => $carryoverToNextShift,
                    'status' => 'approved',
                    'approved_by' => auth()->id(),
                    'notes' => 'مبلغ مرحل للشيفت التالي',
                ]
            );
        } else {
            CashTransfer::where('from_shift_id', $shift->id)
                ->where('type', 'to_next_shift')
                ->delete();
        }

        return $shift->fresh();
    }
}
