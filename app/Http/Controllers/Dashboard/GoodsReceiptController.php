<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGoodsReceiptRequest;
use App\Models\GoodsReceipt;
use App\Models\PurchaseOrder;
use App\Models\RawMaterial;
use App\Models\Supplier;
use App\Models\Unit;
use App\Services\PurchaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsReceiptController extends Controller
{
    public function __construct(protected PurchaseService $purchaseService)
    {
    }

    public function index(Request $request)
    {
        $query = GoodsReceipt::with(['supplier', 'purchaseOrder', 'items'])
            ->where('user_id', auth()->id())
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('receipt_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                      $supplierQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $receipts = $query->paginate(15)->withQueryString();
        $suppliers = Supplier::where('user_id', auth()->id())->where('is_active', true)->get();

        return view('dashboard.inventory.receipts.index', compact('receipts', 'suppliers'));
    }

    public function create()
    {
        $suppliers = Supplier::where('user_id', auth()->id())->where('is_active', true)->get();
        $purchaseOrders = PurchaseOrder::with(['items.rawMaterial', 'items.unit'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['sent', 'partial_received'])
            ->latest()
            ->get();

        $materials = RawMaterial::where('user_id', auth()->id())->where('is_active', true)->get();
        $units = Unit::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.receipts.create', compact('suppliers', 'purchaseOrders', 'materials', 'units'));
    }

    public function store(StoreGoodsReceiptRequest $request)
    {
        DB::transaction(function () use ($request) {
            $receipt = GoodsReceipt::create([
                'user_id'           => auth()->id(),
                'purchase_order_id' => $request->purchase_order_id,
                'supplier_id'       => $request->supplier_id,
                'receipt_number'    => 'GR-' . now()->format('YmdHis'),
                'receipt_date'      => $request->receipt_date,
                'status'            => 'draft',
                'subtotal'          => $request->subtotal ?? 0,
                'discount'          => $request->discount ?? 0,
                'tax'               => $request->tax ?? 0,
                'total'             => $request->total ?? 0,
                'notes'             => $request->notes,
            ]);

            foreach ($request->items as $item) {
                $qty = (float) $item['quantity'];
                $unitCost = (float) $item['unit_cost'];

                $receipt->items()->create([
                    'raw_material_id'        => $item['raw_material_id'],
                    'purchase_order_item_id' => $item['purchase_order_item_id'] ?? null,
                    'unit_id'                => $item['unit_id'] ?? null,
                    'quantity'               => $qty,
                    'unit_cost'              => $unitCost,
                    'total_cost'             => $qty * $unitCost,
                ]);
            }
        });

        return redirect()
            ->route('inventory.receipts.index')
            ->with('success', 'تم إنشاء سند الاستلام بنجاح');
    }

    public function edit(GoodsReceipt $receipt)
    {
        abort_if($receipt->user_id !== auth()->id(), 403);

        if ($receipt->status === 'posted') {
            return redirect()
                ->route('inventory.receipts.index')
                ->with('error', 'لا يمكن تعديل سند استلام مرحّل');
        }

        $receipt->load('items');

        $suppliers = Supplier::where('user_id', auth()->id())->where('is_active', true)->get();
        $purchaseOrders = PurchaseOrder::with(['items.rawMaterial', 'items.unit'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['sent', 'partial_received'])
            ->latest()
            ->get();

        $materials = RawMaterial::where('user_id', auth()->id())->where('is_active', true)->get();
        $units = Unit::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.receipts.edit', compact('receipt', 'suppliers', 'purchaseOrders', 'materials', 'units'));
    }

    public function update(StoreGoodsReceiptRequest $request, GoodsReceipt $receipt)
    {
        abort_if($receipt->user_id !== auth()->id(), 403);

        if ($receipt->status === 'posted') {
            return back()->with('error', 'لا يمكن تعديل سند استلام مرحّل');
        }

        DB::transaction(function () use ($request, $receipt) {
            $receipt->update([
                'purchase_order_id' => $request->purchase_order_id,
                'supplier_id'       => $request->supplier_id,
                'receipt_date'      => $request->receipt_date,
                'subtotal'          => $request->subtotal ?? 0,
                'discount'          => $request->discount ?? 0,
                'tax'               => $request->tax ?? 0,
                'total'             => $request->total ?? 0,
                'notes'             => $request->notes,
            ]);

            $receipt->items()->delete();

            foreach ($request->items as $item) {
                $qty = (float) $item['quantity'];
                $unitCost = (float) $item['unit_cost'];

                $receipt->items()->create([
                    'raw_material_id'        => $item['raw_material_id'],
                    'purchase_order_item_id' => $item['purchase_order_item_id'] ?? null,
                    'unit_id'                => $item['unit_id'] ?? null,
                    'quantity'               => $qty,
                    'unit_cost'              => $unitCost,
                    'total_cost'             => $qty * $unitCost,
                ]);
            }
        });

        return redirect()
            ->route('inventory.receipts.index')
            ->with('success', 'تم تعديل سند الاستلام بنجاح');
    }

    public function destroy(GoodsReceipt $receipt)
    {
        abort_if($receipt->user_id !== auth()->id(), 403);

        if ($receipt->status === 'posted') {
            return back()->with('error', 'لا يمكن حذف سند استلام مرحّل');
        }

        $receipt->delete();

        return redirect()
            ->route('inventory.receipts.index')
            ->with('success', 'تم حذف سند الاستلام بنجاح');
    }

    public function post(GoodsReceipt $receipt)
    {
        abort_if($receipt->user_id !== auth()->id(), 403);

        if ($receipt->status === 'posted') {
            return back()->with('error', 'السند مرحّل بالفعل');
        }

        $this->purchaseService->postReceipt(
            $receipt->load('items.purchaseOrderItem', 'purchaseOrder')
        );

        return back()->with('success', 'تم ترحيل الاستلام وتحديث المخزون');
    }
}