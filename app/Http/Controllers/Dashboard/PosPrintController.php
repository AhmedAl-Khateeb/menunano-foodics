<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Shift;

class PosPrintController extends Controller
{
    public function printTwo(Order $order)
    {
        $order->load([
            'customer',
            'table',
            'deliveryMan',
            'items.product',
        ]);

        $shift = Shift::find($order->shift_id);
        $branch = $shift ? Branch::find($shift->branch_id) : null;

        return view('livewire.print-two-invoices', compact('order', 'shift', 'branch'));
    }
}
