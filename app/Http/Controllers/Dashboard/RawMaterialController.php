<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Unit;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryMovement;

class RawMaterialController extends Controller
{
    public function index()
    {
        $rawMaterials = Product::where('type', 'raw')
            ->where('user_id', auth()->id())
            ->with(['inventory.unit'])
            ->latest()
            ->paginate(20);

        $units = Unit::active()->get();

        return view('dashboard.inventory.raw.index', compact('rawMaterials', 'units'));
    }

    public function create()
    {
        $units = Unit::active()->get();
        // Fetch Internal Categories ONLY
        $categories = Category::where('user_id', auth()->id())
            ->where('type', 'internal')
            ->get();
        return view('dashboard.inventory.raw.create', compact('units', 'categories'));
    }



    public function store(Request $request)
    {
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'nullable|exists:categories,id',
                'purchase_price' => 'required|numeric|min:0',
                'purchase_unit_id' => 'required|exists:units,id',
                'current_quantity' => 'required|numeric|min:0',
            ]);
    
            DB::beginTransaction();
            try {
                $categoryId = $request->category_id;
                
                if (!$categoryId) {
                    // Create default if not selected
                    $category = Category::firstOrCreate(
                        ['name' => 'Raw Materials', 'user_id' => auth()->id(), 'type' => 'internal'],
                        ['is_active' => true]
                    );
                    $categoryId = $category->id;
                }
    
                $product = Product::create([
                    'name' => $request->name,
                    'user_id' => auth()->id(),
                    'category_id' => $categoryId, // This category should be internal
                    'type' => 'raw',
                    'price' => 0, 
                ]);
// ... rest is same


            $product->inventory()->create([
                'purchase_price' => $request->purchase_price,
                'purchase_unit_id' => $request->purchase_unit_id,
                'current_quantity' => $request->current_quantity,
                'user_id' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('inventory.raw.create')->with('success', 'تم إضافة المادة الخام بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء الإضافة: ' . $e->getMessage());
        }
    }

    public function adjustStock(Request $request, $id, \App\Services\InventoryService $inventoryService)
    {
        $request->validate([
            'quantity' => 'required|numeric',
            'type' => 'required|in:purchase,waste,adjustment',
            'description' => 'nullable|string',
            'unit_cost' => 'nullable|numeric|min:0',
        ]);

        try {
            $product = Product::where('user_id', auth()->id())->findOrFail($id);
            
            // Get inventory record
            $inventory = $product->inventory;
            
            if (!$inventory) {
                // Should exist for raw materials, but just in case
                $inventory = $product->inventory()->create([
                    'user_id' => auth()->id(),
                    'current_quantity' => 0,
                    'purchase_unit_id' => $product->unit_id, 
                    'purchase_price' => 0
                ]);
            }

            $inventoryService->adjust(
                $inventory,
                $request->type,
                $request->quantity,
                $request->unit_cost,
                $request->description,
                auth()->id()
            );

            return back()->with('success', 'تم تحديث مخزون المادة الخام بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $product = Product::where('user_id', auth()->id())->where('type', 'raw')->findOrFail($id);
        $units = Unit::active()->get();
        $categories = Category::where('user_id', auth()->id())->get();
        return view('dashboard.inventory.raw.edit', compact('product', 'units', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'purchase_price' => 'required|numeric|min:0',
            'purchase_unit_id' => 'required|exists:units,id',
        ]);

        $product = Product::where('user_id', auth()->id())->where('type', 'raw')->findOrFail($id);

        DB::beginTransaction();
        try {
            $categoryId = $request->category_id;
            if (!$categoryId) {
                $category = Category::firstOrCreate(
                    ['name' => 'Raw Materials', 'user_id' => auth()->id(), 'type' => 'internal'],
                    ['is_active' => true]
                );
                $categoryId = $category->id;
            }

            $product->update([
                'name' => $request->name,
                'category_id' => $categoryId,
            ]);

            // Update inventory Purchase Price & Unit
            $product->inventory()->updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'purchase_price' => $request->purchase_price,
                    'purchase_unit_id' => $request->purchase_unit_id,
                ]
            );

            DB::commit();
            return redirect()->route('inventory.raw.index')->with('success', 'تم تعديل المادة الخام بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
    public function history($id)
    {
        $product = Product::where('user_id', auth()->id())
            ->where('type', 'raw')
            ->with(['inventory'])
            ->findOrFail($id);

        if (!$product->inventory) {
             return back()->with('error', 'لا يوجد سجل مخزون لهذا المنتج بعد.');
        }

        $movements = $product->inventory->movements()
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('dashboard.inventory.raw.history', compact('product', 'movements'));
    }
}
