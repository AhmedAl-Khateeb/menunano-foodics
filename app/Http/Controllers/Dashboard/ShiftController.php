<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShiftRequest;
use App\Models\Order;
use App\Models\Shift;
use App\Services\ShiftService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ShiftController extends Controller
{
    public function __construct(private ShiftService $shiftService)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'user_id',
            'branch_id',
            'status',
            'date_from',
            'date_to',
        ]);

        $shifts = $this->shiftService->getPaginated($filters);
        $users = $this->shiftService->getUsers();
        $branches = $this->shiftService->getStores();

        return view('shifts.index', compact('shifts', 'users', 'branches'));
    }

    public function create()
    {
        $users = $this->shiftService->getUsers();
        $branches = $this->shiftService->getStores();

        return view('shifts.create', compact('users', 'branches'));
    }

    public function store(ShiftRequest $request)
    {
        $data = $request->validated();

        if (empty($data['start_time'])) {
            $data['start_time'] = now();
        }

        $this->shiftService->create($data);

        return redirect()
            ->route('shifts.index')
            ->with('success', 'تم إضافة الشيفت بنجاح');
    }


    public function show(\App\Models\Shift $shift)
{
    $shift->load([
        'user',
        'branch',
        'closer',
    ]);

    $employeeShifts = Shift::with(['branch', 'closer'])
        ->where('user_id', $shift->user_id)
        ->latest('start_time')
        ->get();

    $totalStartingCash = $employeeShifts->sum('starting_cash');
    $totalEndingCash = $employeeShifts->sum('ending_cash');
    $totalCashDifference = $employeeShifts->sum('cash_difference');

    $orders = collect();

    if (Schema::hasColumn('orders', 'shift_id')) {
        $orders = Order::with(['customer', 'table'])
            ->where('shift_id', $shift->id)
            ->latest()
            ->get();
    }

    $ordersCount = $orders->count();
    $ordersTotal = $orders->sum('total_price');
    $paidTotal = $orders->sum('paid_amount');

    return view('shifts.show', compact(
        'shift',
        'employeeShifts',
        'totalStartingCash',
        'totalEndingCash',
        'totalCashDifference',
        'orders',
        'ordersCount',
        'ordersTotal',
        'paidTotal'
    ));
}


    public function edit(Shift $shift)
    {
        $users = $this->shiftService->getUsers();
        $branches = $this->shiftService->getStores();

        return view('shifts.edit', compact('shift', 'users', 'branches'));
    }

    public function update(ShiftRequest $request, Shift $shift)
    {
        $data = $request->validated();

        if (($data['status'] ?? null) === 'closed' && empty($data['end_time'])) {
            $data['end_time'] = now();
        }

        $this->shiftService->update($shift, $data);

        return redirect()
            ->route('shifts.index')
            ->with('success', 'تم تحديث الشيفت بنجاح');
    }

    public function destroy(Shift $shift)
    {
        $this->shiftService->delete($shift);

        return redirect()
            ->route('shifts.index')
            ->with('success', 'تم حذف الشيفت بنجاح');
    }

    public function close(Request $request, Shift $shift)
    {
        $request->validate([
            'ending_cash' => ['nullable', 'numeric', 'min:0'],
            'expected_cash' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $this->shiftService->closeShift($shift, $request->only([
            'ending_cash',
            'expected_cash',
            'notes',
        ]));

        return redirect()
            ->route('shifts.index')
            ->with('success', 'تم إغلاق الشيفت وتسجيل الانصراف بنجاح');
    }
}
