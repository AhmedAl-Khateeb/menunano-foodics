<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Shift;
use App\Models\User;

class ShiftReceiptController extends Controller
{
    public function show(Shift $shift)
    {
        if ($shift->user_id !== auth()->id()) {
            abort(403);
        }

        $shiftService = app(\App\Services\ShiftService::class);

        $cashier = User::find($shift->user_id);
        $branch = Branch::find($shift->branch_id);

        $ordersQuery = \App\Models\Order::where('shift_id', $shift->id)
            ->whereIn('status', ['served', 'completed']);

        // عدد الطلبات
        $ordersCount = (clone $ordersQuery)->count();

        // إجمالي الطلبات
        $ordersTotal = (float) (clone $ordersQuery)->sum('total_price');

        // المبيعات النقدية
        $cashSales = (float) (clone $ordersQuery)
            ->where('payment_method', 'cash')
            ->sum('total_price');

        // مبيعات الفيزا / أي طريقة دفع غير كاش
        $visaSales = (float) (clone $ordersQuery)
            ->whereNotNull('payment_method')
            ->where('payment_method', '!=', 'cash')
            ->sum('total_price');

        // المرتجعات - مؤقتًا 0 لو لسه مفيش جدول مرتجعات
        $cashRefund = 0;
        $visaRefund = 0;

        if (\Illuminate\Support\Facades\Schema::hasTable('refunds')) {
            $cashRefund = (float) \Illuminate\Support\Facades\DB::table('refunds')
                ->where('shift_id', $shift->id)
                ->where('payment_method', 'cash')
                ->sum('amount');

            $visaRefund = (float) \Illuminate\Support\Facades\DB::table('refunds')
                ->where('shift_id', $shift->id)
                ->where('payment_method', '!=', 'cash')
                ->sum('amount');
        }

        // الإيداع = رصيد بداية الشيفت
        $deposit = (float) $shift->starting_cash;

        // المصروفات
        $expenses = (float) $shiftService->calculateExpensesForShift($shift);

        // المسلم للمدير
        $transfers = (float) $shiftService->calculateTransfersToManagerForShift($shift);

        // المتاح في الدرج = بداية الشيفت + كاش - مرتجع كاش - مصروفات - تسليمات
        $availableCash = $deposit + $cashSales - $cashRefund - $expenses - $transfers;

        // المتوقع في الدرج حسب السيستم
        $expectedCash = (float) $shiftService->calculateExpectedCashForShift($shift);

        // الفعلي اللي الكاشير كتبه
        $endingCash = (float) ($shift->ending_cash ?? $expectedCash);

        // الفرق
        $difference = $endingCash - $expectedCash;

        return view('livewire.shift-closing-receipt', compact(
            'shift',
            'cashier',
            'branch',
            'ordersCount',
            'ordersTotal',
            'deposit',
            'availableCash',
            'cashSales',
            'visaSales',
            'cashRefund',
            'visaRefund',
            'expenses',
            'transfers',
            'expectedCash',
            'endingCash',
            'difference'
        ));
    }
}
