<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseInvoiceController extends Controller
{
    public function index()
    {
        $invoices = \App\Models\PurchaseInvoice::with('supplier')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();
            
        return view('dashboard.purchases.index', compact('invoices'));
    }

    public function create()
    {
        return view('dashboard.purchases.create');
    }

    public function show(\App\Models\PurchaseInvoice $purchase)
    {
        if ($purchase->user_id !== auth()->id()) abort(403);
        $purchase->load('supplier', 'items.inventory.inventoriable');
        return view('dashboard.purchases.show', compact('purchase'));
    }

    public function destroy(\App\Models\PurchaseInvoice $purchase)
    {
        if ($purchase->user_id !== auth()->id()) abort(403);
        
        // Handle reverting inventory stock (future)
        
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'تم حذف الفاتورة بنجاح');
    }
}

