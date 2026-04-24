<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductionOrderRequest;
use App\Models\ProductionOrder;
use App\Models\RawMaterial;
use App\Models\Recipe;
use App\Models\Unit;
use App\Services\ProductionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionOrderController extends Controller
{
    public function __construct(protected ProductionService $productionService)
    {
    }

    public function index(Request $request)
    {
        $query = ProductionOrder::with(['recipe.outputMaterial', 'items.rawMaterial'])
            ->where('user_id', auth()->id())
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('production_number', 'like', '%'.$search.'%');
            });
        }

        $productionOrders = $query->paginate(15)->withQueryString();

        return view('dashboard.inventory.production_orders.index', compact('productionOrders'));
    }

    public function create()
    {
        $recipes = Recipe::with(['items', 'outputMaterial'])
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        $materials = RawMaterial::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        $units = Unit::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.production_orders.create', compact('recipes', 'materials', 'units'));
    }

    public function store(StoreProductionOrderRequest $request)
    {
        DB::transaction(function () use ($request) {
            $productionOrder = ProductionOrder::create([
                'user_id' => auth()->id(),
                'recipe_id' => $request->recipe_id,
                'production_number' => 'PD-'.now()->format('YmdHis'),
                'production_date' => $request->production_date,
                'planned_quantity' => $request->planned_quantity,
                'produced_quantity' => $request->produced_quantity,
                'status' => 'draft',
                'total_cost' => 0,
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $item) {
                $productionOrder->items()->create([
                    'raw_material_id' => $item['raw_material_id'],
                    'unit_id' => $item['unit_id'] ?? null,
                    'planned_quantity' => $item['planned_quantity'],
                    'consumed_quantity' => $item['consumed_quantity'],
                    'unit_cost' => 0,
                    'total_cost' => 0,
                ]);
            }
        });

        return redirect()
            ->route('inventory.production-orders.index')
            ->with('success', 'تم إنشاء أمر الإنتاج بنجاح');
    }

    public function edit(ProductionOrder $production_order)
    {
        abort_if($production_order->user_id !== auth()->id(), 403);

        if ($production_order->status === 'produced') {
            return redirect()->route('inventory.production-orders.index')
                ->with('error', 'لا يمكن تعديل أمر إنتاج تم ترحيله');
        }

        $production_order->load('items');

        $recipes = Recipe::with(['items', 'outputMaterial'])
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        $materials = RawMaterial::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        $units = Unit::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.production_orders.edit', compact(
            'production_order',
            'recipes',
            'materials',
            'units'
        ));
    }

    public function update(StoreProductionOrderRequest $request, ProductionOrder $production_order)
    {
        abort_if($production_order->user_id !== auth()->id(), 403);

        if ($production_order->status === 'produced') {
            return back()->with('error', 'لا يمكن تعديل أمر إنتاج تم ترحيله');
        }

        DB::transaction(function () use ($request, $production_order) {
            $production_order->update([
                'recipe_id' => $request->recipe_id,
                'production_date' => $request->production_date,
                'planned_quantity' => $request->planned_quantity,
                'produced_quantity' => $request->produced_quantity,
                'notes' => $request->notes,
            ]);

            $production_order->items()->delete();

            foreach ($request->items as $item) {
                $production_order->items()->create([
                    'raw_material_id' => $item['raw_material_id'],
                    'unit_id' => $item['unit_id'] ?? null,
                    'planned_quantity' => $item['planned_quantity'],
                    'consumed_quantity' => $item['consumed_quantity'],
                    'unit_cost' => 0,
                    'total_cost' => 0,
                ]);
            }
        });

        return redirect()
            ->route('inventory.production-orders.index')
            ->with('success', 'تم تعديل أمر الإنتاج بنجاح');
    }

    public function destroy(ProductionOrder $production_order)
    {
        abort_if($production_order->user_id !== auth()->id(), 403);

        if ($production_order->status === 'produced') {
            return back()->with('error', 'لا يمكن حذف أمر إنتاج تم ترحيله');
        }

        $production_order->delete();

        return redirect()
            ->route('inventory.production-orders.index')
            ->with('success', 'تم حذف أمر الإنتاج بنجاح');
    }

    public function produce(ProductionOrder $production_order)
    {
        abort_if($production_order->user_id !== auth()->id(), 403);

        if ($production_order->status === 'produced') {
            return back()->with('error', 'أمر الإنتاج مرحّل بالفعل');
        }

        $this->productionService->produce(
            $production_order->load(['items.rawMaterial.inventory', 'recipe.outputMaterial.inventory'])
        );

        return back()->with('success', 'تم ترحيل أمر الإنتاج بنجاح');
    }
}
