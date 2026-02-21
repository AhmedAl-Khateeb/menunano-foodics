<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\InventoryMovement;

class ReadyItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('type', 'ready')
            ->where('user_id', auth()->id())
            ->with(['category', 'inventory.unit', 'sizes'])
            ->latest();

        if ($request->has('category_id') && $request->category_id != 'all') {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(12);

        $categories = Category::where('user_id', auth()->id())
            ->where('type', 'menu')
            ->get();
            
        $units = Unit::active()->get();

        return view('dashboard.inventory.ready.index', compact('products', 'categories', 'units'));
    }

    public function create()
    {
        $categories = Category::where('user_id', auth()->id())
            ->where('type', 'menu')
            ->get();
        $units = Unit::active()->get();
        return view('dashboard.inventory.ready.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'current_quantity' => 'nullable|numeric|min:0',
            'unit_id' => 'nullable|exists:units,id',
            'sizes' => 'nullable|array',
            'sizes.*.size' => 'required_with:sizes|string|max:255',
            'sizes.*.price' => 'required_with:sizes|numeric|min:0',
            'sizes.*.cost' => 'nullable|numeric|min:0',
            'sizes.*.quantity' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id,
                'price' => $request->has_sizes ? null : $request->price,
                'description' => $request->description,
                'type' => 'ready',
            ];

            if ($request->hasFile('cover')) {
                $data['cover'] = $request->file('cover')->store('products', 'public');
            }

            $product = Product::create($data);

            // Handle Sizes
            if ($request->has_sizes && $request->has('sizes') && is_array($request->sizes)) {
                foreach ($request->sizes as $sizeData) {
                    $size = $product->sizes()->create([
                        'size' => $sizeData['size'],
                        'price' => $sizeData['price'] ?? 0,
                    ]);

                    // Create inventory for each size
                    $size->inventory()->create([
                        'user_id' => auth()->id(),
                        'purchase_price' => $sizeData['cost'] ?? 0,
                        'current_quantity' => $sizeData['quantity'] ?? 0,
                        'purchase_unit_id' => $sizeData['unit_id'] ?: ($request->unit_id ?? null)
                    ]);
                }
            } else {
                // If no sizes, create inventory for the main product
                $product->inventory()->create([
                    'user_id' => auth()->id(),
                    'current_quantity' => $request->current_quantity ?? 0,
                    'purchase_unit_id' => $request->unit_id,
                    'purchase_price' => 0
                ]);
            }

            DB::commit();
            return redirect()->route('inventory.ready.index')->with('success', 'تم إضافة المنتج بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = Product::where('user_id', auth()->id())
            ->where('type', 'ready')
            ->with(['inventory', 'sizes.inventory'])
            ->findOrFail($id);
            
        $categories = Category::where('user_id', auth()->id())
            ->where('type', 'menu')
            ->get();
            
        $units = Unit::active()->get();

        return view('dashboard.inventory.ready.edit', compact('product', 'categories', 'units'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sizes' => 'nullable|array',
            'sizes.*.size' => 'required_with:sizes|string|max:255',
            'sizes.*.price' => 'required_with:sizes|numeric|min:0',
            'sizes.*.cost' => 'nullable|numeric|min:0',
            'sizes.*.quantity' => 'nullable|numeric|min:0',
        ]);

        $product = Product::where('user_id', auth()->id())->where('type', 'ready')->findOrFail($id);

        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $request->has_sizes ? null : $request->price,
                'description' => $request->description,
            ];

            if ($request->hasFile('cover')) {
                // Delete old image if exists
                if ($product->cover && Storage::disk('public')->exists($product->cover)) {
                    Storage::disk('public')->delete($product->cover);
                }
                $data['cover'] = $request->file('cover')->store('products', 'public');
            }

            $product->update($data);

            // Handle Sizes Synchronization
            if ($request->has_sizes && $request->has('sizes')) {
                $providedSizeIds = collect($request->sizes)->pluck('id')->filter()->toArray();
                
                // Delete sizes not present in request
                $product->sizes()->whereNotIn('id', $providedSizeIds)->delete();

                foreach ($request->sizes as $sizeData) {
                    if (isset($sizeData['id'])) {
                        // Update existing size
                        $size = $product->sizes()->where('id', $sizeData['id'])->first();
                        if ($size) {
                            $size->update([
                                'size' => $sizeData['size'],
                                'price' => $sizeData['price'],
                            ]);
                        }
                    } else {
                        // Create new size
                        $size = $product->sizes()->create([
                            'size' => $sizeData['size'],
                            'price' => $sizeData['price'],
                        ]);
                    }

                    if ($size) {
                        // Update/Create inventory record for this size
                        $size->inventory()->updateOrCreate(
                            ['user_id' => auth()->id()],
                            [
                                'purchase_price' => $sizeData['cost'] ?? 0,
                                'current_quantity' => $sizeData['quantity'] ?? 0,
                                'purchase_unit_id' => $sizeData['unit_id'] ?: ($request->unit_id ?? null)
                            ]
                        );
                    }
                }
            } else {
                // For now, if sizes are explicitly null/empty in request, we clear them.
                if ($request->has('sizes')) {
                    $product->sizes()->delete();
                }
            }

            DB::commit();
            return redirect()->route('inventory.ready.index')->with('success', 'تم تعديل المنتج بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function convertToComposite($id)
    {
        $product = Product::where('user_id', auth()->id())->where('type', 'ready')->findOrFail($id);
        
        $product->update(['type' => 'manufactured']);
        
        return redirect()->route('inventory.composite.recipe.edit', $product->id)
            ->with('success', 'تم تحويل المنتج إلى (مركب) بنجاح. يمكنك الآن إدارة مكوناته.');
    }
    public function adjustStock(Request $request, $id, \App\Services\InventoryService $inventoryService)
    {
        $request->validate([
            'size_id' => 'nullable|exists:product_sizes,id',
            'quantity' => 'required|numeric',
            'type' => 'required|in:purchase,waste,adjustment',
            'description' => 'nullable|string|max:500',
            'unit_cost' => 'nullable|numeric|min:0',
        ]);

        try {
            $product = Product::where('user_id', auth()->id())->where('type', 'ready')->findOrFail($id);
            
            $modelToAdjust = $product;
            
            // Check if adjusting a specific size
            if ($request->filled('size_id')) {
                $size = $product->sizes()->where('id', $request->size_id)->firstOrFail();
                $modelToAdjust = $size;
            }

            // Get inventory record (PolyMorphic)
            $inventory = $modelToAdjust->inventory;
            
            if (!$inventory) {
                // Should exist, but create if missing
                $inventory = $modelToAdjust->inventory()->create([
                    'user_id' => auth()->id(),
                    'current_quantity' => 0,
                    'purchase_unit_id' => null, 
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

            return back()->with('success', 'تم تحديث مخزون المنتج بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function history($id)
    {
        $product = Product::where('user_id', auth()->id())
            ->where('type', 'ready')
            ->with(['category', 'inventory.unit', 'inventory.movements.user', 'sizes.inventory.movements.user'])
            ->findOrFail($id);

        $movements = collect();

        // Main Product Movements
        if ($product->inventory && $product->inventory->movements) {
            foreach ($product->inventory->movements as $movement) {
                $movement->item_name = $product->name; // Main Item
                $movements->push($movement);
            }
        }

        // Sizes Movements
        if ($product->sizes) {
            foreach ($product->sizes as $size) {
                if ($size->inventory && $size->inventory->movements) {
                    foreach ($size->inventory->movements as $movement) {
                        $movement->item_name = $product->name . ' - ' . $size->size;
                        $movements->push($movement);
                    }
                }
            }
        }

        $movements = $movements->sortByDesc('created_at');

        return view('dashboard.inventory.ready.history', compact('product', 'movements'));
    }
}
