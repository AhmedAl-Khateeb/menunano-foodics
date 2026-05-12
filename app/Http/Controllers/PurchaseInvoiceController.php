<?php

namespace App\Http\Controllers;

use App\Models\PurchaseInvoice;

class PurchaseInvoiceController extends Controller
{
    public function index()
    {
        $invoices = PurchaseInvoice::with('supplier')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('dashboard.purchases.index', compact('invoices'));
    }

    public function create()
    {
        return view('dashboard.purchases.create');
    }

    public function show(PurchaseInvoice $purchase)
    {
        if ($purchase->user_id !== auth()->id()) {
            abort(403);
        }
        $purchase->load('supplier', 'items.inventory.inventoriable');

        return view('dashboard.purchases.show', compact('purchase'));
    }

    public function destroy(PurchaseInvoice $purchase)
    {
        if ($purchase->user_id !== auth()->id()) {
            abort(403);
        }

        $purchase->delete();

        return redirect()->route('purchases.index')->with('success', 'تم حذف الفاتورة بنجاح');
    }
}
