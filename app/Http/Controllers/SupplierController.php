<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = \App\Models\Supplier::where('user_id', auth()->id())->latest()->get();
        return view('dashboard.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('dashboard.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'balance' => 'nullable|numeric',
        ]);

        \App\Models\Supplier::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'balance' => $request->balance ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('suppliers.index')->with('success', 'تم إضافة المورد بنجاح');
    }

    public function edit(\App\Models\Supplier $supplier)
    {
        if ($supplier->user_id !== auth()->id()) abort(403);
        return view('dashboard.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, \App\Models\Supplier $supplier)
    {
        if ($supplier->user_id !== auth()->id()) abort(403);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'balance' => 'numeric',
        ]);

        $supplier->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'balance' => $request->balance ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('suppliers.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy(\App\Models\Supplier $supplier)
    {
        if ($supplier->user_id !== auth()->id()) abort(403);
        
        // Prevent deletion if associated with any purchase orders (to be handled later gracefully or cascade)
        $supplier->delete();
        
        return redirect()->route('suppliers.index')->with('success', 'تم الحذف بنجاح');
    }
}
