<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::where('user_id', auth()->id())->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $suppliers = $query->paginate(15)->withQueryString();

        return view('dashboard.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('dashboard.suppliers.create');
    }

    public function store(StoreSupplierRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['is_active'] = $request->boolean('is_active');
        $data['opening_balance'] = $data['opening_balance'] ?? 0;
        $data['current_balance'] = $data['current_balance'] ?? ($data['opening_balance'] ?? 0);
        $data['credit_limit'] = $data['credit_limit'] ?? 0;

        Supplier::create($data);

        return redirect()
            ->route('inventory.suppliers.index')
            ->with('success', 'تم إضافة المورد بنجاح');
    }

    public function edit(Supplier $supplier)
    {
        abort_if($supplier->user_id !== auth()->id(), 403);

        return view('dashboard.suppliers.edit', compact('supplier'));
    }

    public function update(StoreSupplierRequest $request, Supplier $supplier)
    {
        abort_if($supplier->user_id !== auth()->id(), 403);

        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['opening_balance'] = $data['opening_balance'] ?? 0;
        $data['current_balance'] = $data['current_balance'] ?? ($supplier->current_balance ?? $data['opening_balance']);
        $data['credit_limit'] = $data['credit_limit'] ?? 0;

        $supplier->update($data);

        return redirect()
            ->route('inventory.suppliers.index')
            ->with('success', 'تم تعديل المورد بنجاح');
    }

    public function destroy(Supplier $supplier)
    {
        abort_if($supplier->user_id !== auth()->id(), 403);

        $supplier->delete();

        return redirect()
            ->route('inventory.suppliers.index')
            ->with('success', 'تم حذف المورد بنجاح');
    }
}