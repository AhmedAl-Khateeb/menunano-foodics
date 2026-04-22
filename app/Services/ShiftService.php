<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Shift;
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

        if (!empty($filters['created_at'])) {
            $query->whereDate('created_at', $filters['created_at']);
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

    public function closeShift(Shift $shift, array $data = []): Shift
    {
        if ($shift->status === 'closed') {
            throw ValidationException::withMessages(['status' => ['هذا الشيفت مغلق بالفعل']]);
        }

        $endingCash = $data['ending_cash'] ?? $shift->ending_cash;
        $expectedCash = $data['expected_cash'] ?? $shift->expected_cash ?? 0;
        $endTime = $data['end_time'] ?? now();

        $shift->update([
            'ending_cash' => $endingCash,
            'expected_cash' => $expectedCash,
            'cash_difference' => $this->calculateCashDifference($expectedCash, $endingCash),
            'end_time' => $endTime,
            'status' => 'closed',
            'closed_by' => auth()->id(),
            'notes' => $data['notes'] ?? $shift->notes,
        ]);

        $attendance = Attendance::where('shift_id', $shift->id)->first();

        if ($attendance) {
            $attendance->update([
                'check_out' => $endTime,
            ]);
        }

        return $shift->fresh();
    }
}
