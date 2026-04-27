<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\CashTransfer;
use App\Models\Shift;
use App\Models\ShiftExpense;
use App\Models\User;
use App\Services\StoreService;
use Illuminate\Http\Request;

class CashierCashReportController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $storeOwnerId = StoreService::getStoreOwnerId();

        $cashiers = User::query()
            ->where(function ($query) use ($storeOwnerId) {
                $query->where('id', $storeOwnerId)
                    ->orWhere('created_by', $storeOwnerId);
            })
            ->whereIn('role', ['admin', 'cashier', 'staff', 'employee'])
            ->when($request->filled('user_id'), function ($query) use ($request) {
                $query->where('id', $request->user_id);
            })
            ->orderBy('name')
            ->get();

        $cashierIds = $cashiers->pluck('id')->toArray();

        $branches = Branch::where('created_by', $storeOwnerId)
            ->orderBy('name')
            ->get();

        $expensesQuery = ShiftExpense::query()
            ->whereIn('user_id', $cashierIds)
            ->whereIn('status', ['approved', 'pending']);

        $this->applyDateFilter($expensesQuery, $request, 'created_at');

        if ($request->filled('branch_id')) {
            $expensesQuery->where('branch_id', $request->branch_id);
        }

        $expenseTotals = $expensesQuery
            ->selectRaw('user_id, COALESCE(SUM(amount), 0) as total')
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        $transfersQuery = CashTransfer::query()
            ->whereIn('from_user_id', $cashierIds)
            ->whereIn('type', ['to_manager', 'to_safe'])
            ->whereIn('status', ['approved', 'pending']);

        $this->applyDateFilter($transfersQuery, $request, 'created_at');

        if ($request->filled('branch_id')) {
            $transfersQuery->where('branch_id', $request->branch_id);
        }

        $managerTransferTotals = $transfersQuery
            ->selectRaw('from_user_id, COALESCE(SUM(amount), 0) as total')
            ->groupBy('from_user_id')
            ->pluck('total', 'from_user_id');

        $carryoverQuery = Shift::query()
            ->whereIn('user_id', $cashierIds)
            ->where('status', 'closed');

        $this->applyDateFilter($carryoverQuery, $request, 'end_time');

        if ($request->filled('branch_id')) {
            $carryoverQuery->where('branch_id', $request->branch_id);
        }

        $carryoverTotals = $carryoverQuery
            ->selectRaw('user_id, COALESCE(SUM(carryover_to_next_shift), 0) as total')
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        $shiftsCountQuery = Shift::query()
            ->whereIn('user_id', $cashierIds);

        $this->applyDateFilter($shiftsCountQuery, $request, 'start_time');

        if ($request->filled('branch_id')) {
            $shiftsCountQuery->where('branch_id', $request->branch_id);
        }

        $shiftCounts = $shiftsCountQuery
            ->selectRaw('user_id, COUNT(*) as total')
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        $rows = $cashiers->map(function ($cashier) use ($expenseTotals, $managerTransferTotals, $carryoverTotals, $shiftCounts) {
            return [
                'user' => $cashier,
                'expenses_total' => (float) ($expenseTotals[$cashier->id] ?? 0),
                'sent_to_manager' => (float) ($managerTransferTotals[$cashier->id] ?? 0),
                'carryover_total' => (float) ($carryoverTotals[$cashier->id] ?? 0),
                'shifts_count' => (int) ($shiftCounts[$cashier->id] ?? 0),
            ];
        });

        $summary = [
            'expenses_total' => $rows->sum('expenses_total'),
            'sent_to_manager' => $rows->sum('sent_to_manager'),
            'carryover_total' => $rows->sum('carryover_total'),
            'shifts_count' => $rows->sum('shifts_count'),
        ];

        return view('cashier_cash_reports.index', compact(
            'rows',
            'summary',
            'cashiers',
            'branches'
        ));
    }

    public function show(Request $request, User $user)
    {
        $storeOwnerId = StoreService::getStoreOwnerId();

        abort_if(
            $user->id != $storeOwnerId && $user->created_by != $storeOwnerId,
            403
        );

        $expenses = ShiftExpense::with(['shift', 'branch', 'approver'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['approved', 'pending'])
            ->when($request->filled('branch_id'), function ($query) use ($request) {
                $query->where('branch_id', $request->branch_id);
            });

        $this->applyDateFilter($expenses, $request, 'created_at');

        $expenses = $expenses->latest()->get();

        $managerTransfers = CashTransfer::with(['fromShift', 'toUser', 'branch', 'approver'])
            ->where('from_user_id', $user->id)
            ->whereIn('type', ['to_manager', 'to_safe'])
            ->whereIn('status', ['approved', 'pending'])
            ->when($request->filled('branch_id'), function ($query) use ($request) {
                $query->where('branch_id', $request->branch_id);
            });

        $this->applyDateFilter($managerTransfers, $request, 'created_at');

        $managerTransfers = $managerTransfers->latest()->get();

        $carryoverTransfers = CashTransfer::with(['fromShift', 'toShift', 'toUser', 'branch'])
            ->where('from_user_id', $user->id)
            ->where('type', 'to_next_shift')
            ->whereIn('status', ['approved', 'pending'])
            ->when($request->filled('branch_id'), function ($query) use ($request) {
                $query->where('branch_id', $request->branch_id);
            });

        $this->applyDateFilter($carryoverTransfers, $request, 'created_at');

        $carryoverTransfers = $carryoverTransfers->latest()->get();

        $shifts = Shift::with(['branch', 'closer'])
            ->where('user_id', $user->id)
            ->when($request->filled('branch_id'), function ($query) use ($request) {
                $query->where('branch_id', $request->branch_id);
            });

        $this->applyDateFilter($shifts, $request, 'start_time');

        $shifts = $shifts->latest('start_time')->get();

        $summary = [
            'expenses_total' => $expenses->sum('amount'),
            'sent_to_manager' => $managerTransfers->sum('amount'),
            'carryover_total' => $shifts->sum('carryover_to_next_shift'),
            'shifts_count' => $shifts->count(),
        ];

        return view('cashier_cash_reports.show', compact(
            'user',
            'expenses',
            'managerTransfers',
            'carryoverTransfers',
            'shifts',
            'summary'
        ));
    }

    private function applyDateFilter($query, Request $request, string $column)
    {
        if ($request->filled('date_from')) {
            $query->whereDate($column, '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate($column, '<=', $request->date_to);
        }

        return $query;
    }
}
