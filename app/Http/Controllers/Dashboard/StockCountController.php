<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockCountRequest;
use App\Models\Inventory;
use App\Models\StockCount;
use App\Services\StockCountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockCountController extends Controller
{
    public function __construct(protected StockCountService $stockCountService)
    {
    }

    public function index(Request $request)
    {
        $query = StockCount::with(['items', 'approver'])
            ->where('user_id', auth()->id())
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('count_number', 'like', '%' . trim($request->search) . '%');
        }

        $stockCounts = $query->paginate(15)->withQueryString();

        return view('dashboard.inventory.stock_counts.index', compact('stockCounts'));
    }

    public function create()
    {
        $inventories = Inventory::with(['inventoriable', 'unit'])
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        return view('dashboard.inventory.stock_counts.create', compact('inventories'));
    }

    public function store(StoreStockCountRequest $request)
    {
        DB::transaction(function () use ($request) {
            $stockCount = StockCount::create([
                'user_id'      => auth()->id(),
                'count_number' => 'SC-' . now()->format('YmdHis'),
                'count_date'   => $request->count_date,
                'type'         => $request->type,
                'status'       => 'draft',
                'notes'        => $request->notes,
            ]);

            foreach ($request->items as $item) {
                $inventory = Inventory::findOrFail($item['inventory_id']);
                $systemQty = (float) $inventory->current_quantity;
                $physicalQty = (float) $item['physical_quantity'];

                $stockCount->items()->create([
                    'inventory_id'        => $inventory->id,
                    'system_quantity'     => $systemQty,
                    'physical_quantity'   => $physicalQty,
                    'difference_quantity' => $physicalQty - $systemQty,
                    'notes'               => $item['notes'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('inventory.stock-counts.index')
            ->with('success', 'تم إنشاء جلسة الجرد بنجاح');
    }

    public function edit(StockCount $stock_count)
    {
        abort_if($stock_count->user_id !== auth()->id(), 403);

        if ($stock_count->status === 'approved') {
            return redirect()
                ->route('inventory.stock-counts.index')
                ->with('error', 'لا يمكن تعديل جلسة جرد معتمدة');
        }

        $stock_count->load('items');
        $inventories = Inventory::with(['inventoriable', 'unit'])
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        return view('dashboard.inventory.stock_counts.edit', compact('stock_count', 'inventories'));
    }

    public function update(StoreStockCountRequest $request, StockCount $stock_count)
    {
        abort_if($stock_count->user_id !== auth()->id(), 403);

        if ($stock_count->status === 'approved') {
            return back()->with('error', 'لا يمكن تعديل جلسة جرد معتمدة');
        }

        DB::transaction(function () use ($request, $stock_count) {
            $stock_count->update([
                'count_date' => $request->count_date,
                'type'       => $request->type,
                'notes'      => $request->notes,
            ]);

            $stock_count->items()->delete();

            foreach ($request->items as $item) {
                $inventory = Inventory::findOrFail($item['inventory_id']);
                $systemQty = (float) $inventory->current_quantity;
                $physicalQty = (float) $item['physical_quantity'];

                $stock_count->items()->create([
                    'inventory_id'        => $inventory->id,
                    'system_quantity'     => $systemQty,
                    'physical_quantity'   => $physicalQty,
                    'difference_quantity' => $physicalQty - $systemQty,
                    'notes'               => $item['notes'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('inventory.stock-counts.index')
            ->with('success', 'تم تعديل جلسة الجرد بنجاح');
    }

    public function destroy(StockCount $stock_count)
    {
        abort_if($stock_count->user_id !== auth()->id(), 403);

        if ($stock_count->status === 'approved') {
            return back()->with('error', 'لا يمكن حذف جلسة جرد معتمدة');
        }

        $stock_count->delete();

        return redirect()
            ->route('inventory.stock-counts.index')
            ->with('success', 'تم حذف جلسة الجرد بنجاح');
    }

    public function approve(StockCount $stock_count)
    {
        abort_if($stock_count->user_id !== auth()->id(), 403);

        if ($stock_count->status === 'approved') {
            return back()->with('error', 'الجلسة معتمدة بالفعل');
        }

        $this->stockCountService->approve($stock_count);

        return back()->with('success', 'تم اعتماد الجرد وتسجيل التسويات بنجاح');
    }
}