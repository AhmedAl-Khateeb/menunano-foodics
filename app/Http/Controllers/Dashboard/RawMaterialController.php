<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRawMaterialRequest;
use App\Models\Inventory;
use App\Models\InventoryCategory;
use App\Models\RawMaterial;
use App\Models\Recipe;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RawMaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = RawMaterial::with(['category', 'defaultSupplier', 'unit', 'inventory'])
            ->where('user_id', auth()->id())
            ->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('sku', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('inventory_category_id')) {
            $query->where('inventory_category_id', $request->inventory_category_id);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $materials = $query->paginate(15)->withQueryString();
        $categories = InventoryCategory::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.raw.index', compact('materials', 'categories'));
    }

    public function create()
    {
        $categories = InventoryCategory::where('user_id', auth()->id())->get();
        $suppliers = Supplier::where('user_id', auth()->id())->get();
        $units = Unit::where('user_id', auth()->id())->get();
        $materials = RawMaterial::where('user_id', auth()->id())->where('is_active', true)->get();

        return view('dashboard.inventory.raw.create', compact('categories', 'suppliers', 'units', 'materials'));
    }

    public function store(StoreRawMaterialRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $material = RawMaterial::create(array_merge($validated, [
                'user_id' => auth()->id(),
                'is_active' => $request->boolean('is_active'),
                'is_produced' => $request->boolean('is_produced'),
            ]));

            Inventory::create([
                'user_id' => auth()->id(),
                'inventoriable_id' => $material->id,
                'inventoriable_type' => RawMaterial::class,
                'purchase_price' => $material->purchase_price,
                'avg_cost' => $material->avg_cost,
                'last_cost' => $material->last_cost,
                'purchase_unit_id' => $material->purchase_unit_id,
                'current_quantity' => 0,
                'reorder_level' => $material->reorder_level,
                'min_quantity' => $material->min_quantity,
                'max_quantity' => $material->max_quantity,
                'is_active' => true,
            ]);

            if ($request->boolean('is_produced')) {
                $recipe = Recipe::create([
                    'user_id' => auth()->id(),
                    'output_raw_material_id' => $material->id,
                    'name' => $material->name,
                    'yield_quantity' => $request->yield_quantity ?? 1,
                    'yield_unit_id' => $request->yield_unit_id ?: $material->purchase_unit_id,
                    'notes' => $request->recipe_notes,
                    'is_active' => true,
                ]);

                foreach ($request->recipe_items ?? [] as $item) {
                    if (empty($item['raw_material_id']) || empty($item['quantity'])) {
                        continue;
                    }

                    $recipe->items()->create([
                        'raw_material_id' => $item['raw_material_id'],
                        'unit_id' => $item['unit_id'] ?? null,
                        'quantity' => $item['quantity'],
                        'waste_percent' => $item['waste_percent'] ?? 0,
                        'notes' => $item['notes'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('inventory.materials.index')
            ->with('success', 'تم إضافة مادة المخزن بنجاح');
    }

    public function edit($id)
    {
        $material = RawMaterial::where('user_id', auth()->id())->findOrFail($id);

        $categories = InventoryCategory::where('user_id', auth()->id())->get();
        $suppliers = Supplier::where('user_id', auth()->id())->get();
        $units = Unit::where('user_id', auth()->id())->get();
        $materials = RawMaterial::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        // تحميل الوصفة لو موجودة
        $recipe = Recipe::where('output_raw_material_id', $material->id)->with('items')->first();

        return view('dashboard.inventory.raw.edit', compact(
            'material',
            'categories',
            'suppliers',
            'units',
            'materials',
            'recipe'
        ));
    }

    public function update(StoreRawMaterialRequest $request, $id)
    {
        $material = RawMaterial::where('user_id', auth()->id())->findOrFail($id);

        DB::transaction(function () use ($request, $material) {
            $validated = $request->validated();

            $material->update(array_merge($validated, [
                'is_active' => $request->boolean('is_active'),
                'is_produced' => $request->boolean('is_produced'),
            ]));

            // تحديث المخزون (اختياري حسب احتياجك)
            if ($material->inventory) {
                $material->inventory->update([
                    'purchase_price' => $material->purchase_price,
                    'avg_cost' => $material->avg_cost,
                    'last_cost' => $material->last_cost,
                    'purchase_unit_id' => $material->purchase_unit_id,
                    'reorder_level' => $material->reorder_level,
                    'min_quantity' => $material->min_quantity,
                    'max_quantity' => $material->max_quantity,
                ]);
            }

            // إدارة الوصفة
            $recipe = Recipe::where('output_raw_material_id', $material->id)->first();

            if ($request->boolean('is_produced')) {
                if (!$recipe) {
                    // إنشاء وصفة جديدة
                    $recipe = Recipe::create([
                        'user_id' => auth()->id(),
                        'output_raw_material_id' => $material->id,
                        'name' => $material->name,
                        'yield_quantity' => $request->yield_quantity ?? 1,
                        'yield_unit_id' => $request->yield_unit_id ?: $material->purchase_unit_id,
                        'notes' => $request->recipe_notes,
                        'is_active' => true,
                    ]);
                } else {
                    // تحديث الوصفة
                    $recipe->update([
                        'name' => $material->name,
                        'yield_quantity' => $request->yield_quantity ?? 1,
                        'yield_unit_id' => $request->yield_unit_id ?: $material->purchase_unit_id,
                        'notes' => $request->recipe_notes,
                    ]);

                    // حذف المكونات القديمة
                    $recipe->items()->delete();
                }

                // إضافة المكونات الجديدة
                foreach ($request->recipe_items ?? [] as $item) {
                    if (empty($item['raw_material_id']) || empty($item['quantity'])) {
                        continue;
                    }

                    $recipe->items()->create([
                        'raw_material_id' => $item['raw_material_id'],
                        'unit_id' => $item['unit_id'] ?? null,
                        'quantity' => $item['quantity'],
                        'waste_percent' => $item['waste_percent'] ?? 0,
                        'notes' => $item['notes'] ?? null,
                    ]);
                }
            } else {
                // لو شال علامة "يُنتج" → احذف الوصفة
                if ($recipe) {
                    $recipe->delete();
                }
            }
        });

        return redirect()->route('inventory.materials.index')
            ->with('success', 'تم تعديل مادة المخزن بنجاح');
    }

    public function destroy($id)
    {
        $material = RawMaterial::where('user_id', auth()->id())->findOrFail($id);

        // تأكد ما في أوامر إنتاج أو وصفات تعتمد على هذا الصنف
        if ($material->inventory && $material->inventory->productionOrders()->exists()) {
            return redirect()->route('inventory.materials.index')
                ->with('error', 'لا يمكن حذف مادة المخزن لوجود أوامر إنتاج تعتمد عليها');
        }

        if ($material->recipe) {
            return redirect()->route('inventory.materials.index')
                ->with('error', 'لا يمكن حذف مادة المخزن لوجود وصفة تعتمد عليها');
        }

        $material->delete();

        return redirect()->route('inventory.materials.index')
            ->with('success', 'تم حذف مادة المخزن بنجاح');
    }
}
