<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class AttendanceService
{
    public function getPaginated(array $filters = []): LengthAwarePaginator
    {
        $query = Attendance::with(['user', 'shift'])->latest();

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate(10)->appends($filters);
    }

    public function getUsers()
    {
        return User::orderBy('name')->get();
    }

    public function getShifts()
    {
        return Shift::with('user')->orderByDesc('id')->get();
    }

    public function create(array $data): Attendance
    {
        $this->ensureUniqueAttendance($data['user_id'], $data['attendance_date']);

        return Attendance::create($data);
    }

    public function update(Attendance $attendance, array $data): Attendance
    {
        $this->ensureUniqueAttendance(
            $data['user_id'],
            $data['attendance_date'],
            $attendance->id
        );

        $attendance->update($data);

        return $attendance;
    }

    public function delete(Attendance $attendance): bool
    {
        return $attendance->delete();
    }

    protected function ensureUniqueAttendance(int $userId, string $attendanceDate, ?int $ignoreId = null): void
    {
        $query = Attendance::where('user_id', $userId)
            ->whereDate('attendance_date', $attendanceDate);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages(['attendance_date' => ['يوجد سجل حضور وانصراف لهذا الموظف في نفس اليوم بالفعل']]);
        }
    }
}
