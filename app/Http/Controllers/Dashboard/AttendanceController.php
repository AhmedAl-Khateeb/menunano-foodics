<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Services\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(private AttendanceService $attendanceService)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'user_id',
            'attendance_date',
            'status',
        ]);

        $attendances = $this->attendanceService->getPaginated($filters);
        $users = $this->attendanceService->getUsers();

        return view('attendances.index', compact('attendances', 'users'));
    }

    public function create()
    {
        $users = $this->attendanceService->getUsers();
        $shifts = $this->attendanceService->getShifts();

        return view('attendances.create', compact('users', 'shifts'));
    }

    public function store(StoreAttendanceRequest $request)
    {
        $this->attendanceService->create($request->validated());

        return redirect()
            ->route('attendances.index')
            ->with('success', 'تم إضافة سجل الحضور والانصراف بنجاح');
    }

    public function edit(Attendance $attendance)
    {
        $users = $this->attendanceService->getUsers();
        $shifts = $this->attendanceService->getShifts();

        return view('dashboard.attendances.edit', compact('attendance', 'users', 'shifts'));
    }

    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $this->attendanceService->update($attendance, $request->validated());

        return redirect()
            ->route('attendances.index')
            ->with('success', 'تم تحديث سجل الحضور والانصراف بنجاح');
    }

    public function destroy(Attendance $attendance)
    {
        $this->attendanceService->delete($attendance);

        return redirect()
            ->route('attendances.index')
            ->with('success', 'تم حذف سجل الحضور والانصراف بنجاح');
    }
}
