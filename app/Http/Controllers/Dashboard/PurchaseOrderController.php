<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use App\Models\RawMaterial;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'request', 'items.rawMaterial'])
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
                $q->where('po_number', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                        $supplierQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $purchaseOrders = $query->paginate(15)->withQueryString();
        $suppliers = Supplier::where('user_id', auth()->id())->where('is_active', true)->get();

        return view('dashboard.inventory.purchase_orders.index', compact('purchaseOrders', 'suppliers'));
    }

    public function create()
    {
        $suppliers = Supplier::where('user_id', auth()->id())->where('is_active', true)->get();
        $purchaseRequests = PurchaseRequest::with('items.rawMaterial')
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->latest()
            ->get();

        $materials = RawMaterial::where('user_id', auth()->id())->where('is_active', true)->get();
        $units = Unit::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.purchase_orders.create', compact(
            'suppliers',
            'purchaseRequests',
            'materials',
            'units'
        ));
    }

    public function store(StorePurchaseOrderRequest $request)
    {
        DB::transaction(function () use ($request) {
            $purchaseOrder = PurchaseOrder::create([
                'user_id'             => auth()->id(),
                'supplier_id'         => $request->supplier_id,
                'purchase_request_id' => $request->purchase_request_id,
                'po_number'           => 'PO-' . now()->format('YmdHis'),
                'po_date'             => $request->po_date,
                'expected_date'       => $request->expected_date,
                'status'              => 'draft',
                'subtotal'            => $request->subtotal ?? 0,
                'discount'            => $request->discount ?? 0,
                'tax'                 => $request->tax ?? 0,
                'total'               => $request->total ?? 0,
                'notes'               => $request->notes,
            ]);

            foreach ($request->items as $item) {
                $qty = (float) $item['quantity'];
                $price = (float) $item['unit_price'];

                $purchaseOrder->items()->create([
                    'raw_material_id'  => $item['raw_material_id'],
                    'unit_id'          => $item['unit_id'] ?? null,
                    'quantity'         => $qty,
                    'received_quantity'=> 0,
                    'unit_price'       => $price,
                    'total'            => $qty * $price,
                    'notes'            => $item['notes'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('inventory.purchase-orders.index')
            ->with('success', 'تم إنشاء أمر الشراء بنجاح');
    }

    public function edit(PurchaseOrder $purchase_order)
    {
        abort_if($purchase_order->user_id !== auth()->id(), 403);

        $purchase_order->load('items');

        $suppliers = Supplier::where('user_id', auth()->id())->where('is_active', true)->get();
        $purchaseRequests = PurchaseRequest::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->latest()
            ->get();

        $materials = RawMaterial::where('user_id', auth()->id())->where('is_active', true)->get();
        $units = Unit::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.purchase_orders.edit', compact(
            'purchase_order',
            'suppliers',
            'purchaseRequests',
            'materials',
            'units'
        ));
    }

    public function update(StorePurchaseOrderRequest $request, PurchaseOrder $purchase_order)
    {
        abort_if($purchase_order->user_id !== auth()->id(), 403);

        if (in_array($purchase_order->status, ['received', 'partial_received'])) {
            return back()->with('error', 'لا يمكن تعديل أمر شراء تم استلامه أو بدأ استلامه');
        }

        DB::transaction(function () use ($request, $purchase_order) {
            $purchase_order->update([
                'supplier_id'         => $request->supplier_id,
                'purchase_request_id' => $request->purchase_request_id,
                'po_date'             => $request->po_date,
                'expected_date'       => $request->expected_date,
                'subtotal'            => $request->subtotal ?? 0,
                'discount'            => $request->discount ?? 0,
                'tax'                 => $request->tax ?? 0,
                'total'               => $request->total ?? 0,
                'notes'               => $request->notes,
            ]);

            $purchase_order->items()->delete();

            foreach ($request->items as $item) {
                $qty = (float) $item['quantity'];
                $price = (float) $item['unit_price'];

                $purchase_order->items()->create([
                    'raw_material_id'   => $item['raw_material_id'],
                    'unit_id'           => $item['unit_id'] ?? null,
                    'quantity'          => $qty,
                    'received_quantity' => 0,
                    'unit_price'        => $price,
                    'total'             => $qty * $price,
                    'notes'             => $item['notes'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('inventory.purchase-orders.index')
            ->with('success', 'تم تعديل أمر الشراء بنجاح');
    }

    public function destroy(PurchaseOrder $purchase_order)
    {
        abort_if($purchase_order->user_id !== auth()->id(), 403);

        if (in_array($purchase_order->status, ['received', 'partial_received'])) {
            return back()->with('error', 'لا يمكن حذف أمر شراء مرتبط باستلام');
        }

        $purchase_order->delete();

        return redirect()
            ->route('inventory.purchase-orders.index')
            ->with('success', 'تم حذف أمر الشراء بنجاح');
    }

    public function approve(PurchaseOrder $purchase_order)
    {
        abort_if($purchase_order->user_id !== auth()->id(), 403);

        if ($purchase_order->status !== 'draft') {
            return back()->with('error', 'فقط أوامر الشراء المسودة يمكن اعتمادها');
        }

        $purchase_order->update([
            'status' => 'sent',
        ]);

        return back()->with('success', 'تم اعتماد أمر الشراء بنجاح');
    }
}