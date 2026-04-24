<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Models\RawMaterial;
use App\Models\Supplier;
use App\Models\SupplierRawMaterial;
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
                ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
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

    public function show(Supplier $supplier)
    {
        abort_if($supplier->user_id !== auth()->id(), 403);

        $supplier->load([
            'rawMaterials.unit',
            'rawMaterials' => function ($q) {
                $q->orderBy('name');
            },
        ]);

        $materials = RawMaterial::where('user_id', auth()->id())
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $units = \App\Models\Unit::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('dashboard.suppliers.show', compact('supplier', 'materials', 'units'));
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

    public function attachMaterial(Request $request, Supplier $supplier)
    {
        abort_if($supplier->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'raw_material_id' => ['required', 'exists:raw_materials,id'],
            'unit_id' => ['nullable', 'exists:units,id'],
            'supplier_item_code' => ['nullable', 'string', 'max:255'],
            'order_quantity' => ['required', 'numeric', 'min:0.001'],
            'conversion_factor' => ['required', 'numeric', 'min:0.001'],
            'purchase_cost' => ['required', 'numeric', 'min:0'],
            'is_preferred' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
        ]);

        $material = RawMaterial::where('user_id', auth()->id())
            ->findOrFail($validated['raw_material_id']);

        $supplier->rawMaterials()->syncWithoutDetaching([
            $material->id => [
                'user_id' => auth()->id(),
                'unit_id' => $validated['unit_id'] ?? null,
                'supplier_item_code' => $validated['supplier_item_code'] ?? null,
                'order_quantity' => $validated['order_quantity'],
                'conversion_factor' => $validated['conversion_factor'],
                'purchase_cost' => $validated['purchase_cost'],
                'is_preferred' => $request->boolean('is_preferred'),
                'notes' => $validated['notes'] ?? null,
            ],
        ]);

        return back()->with('success', 'تم ربط مادة المخزن بالمورد بنجاح');
    }

    public function updateAttachedMaterial(Request $request, Supplier $supplier, $pivotId)
    {
        abort_if($supplier->user_id !== auth()->id(), 403);

        $pivot = SupplierRawMaterial::where('supplier_id', $supplier->id)
            ->where('user_id', auth()->id())
            ->findOrFail($pivotId);

        $validated = $request->validate([
            'unit_id' => ['nullable', 'exists:units,id'],
            'supplier_item_code' => ['nullable', 'string', 'max:255'],
            'order_quantity' => ['required', 'numeric', 'min:0.001'],
            'conversion_factor' => ['required', 'numeric', 'min:0.001'],
            'purchase_cost' => ['required', 'numeric', 'min:0'],
            'is_preferred' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
        ]);

        $pivot->update([
            'unit_id' => $validated['unit_id'] ?? null,
            'supplier_item_code' => $validated['supplier_item_code'] ?? null,
            'order_quantity' => $validated['order_quantity'],
            'conversion_factor' => $validated['conversion_factor'],
            'purchase_cost' => $validated['purchase_cost'],
            'is_preferred' => $request->boolean('is_preferred'),
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'تم تحديث بيانات وحدة المخزون للمورد');
    }
}
