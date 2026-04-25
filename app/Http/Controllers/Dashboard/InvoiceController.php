<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Services\StoreService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\InvoiceService;

class InvoiceController extends Controller
{
      protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index(Request $request)
    {
        $orders = $this->invoiceService->getPosInvoices(20);

        return view('invoices.index', compact('orders'));
    }

    public function print(Order $order)
    {
        $order = $this->invoiceService->getInvoiceForPrint($order);

        return view('invoices.print', compact('order'));
    }
}