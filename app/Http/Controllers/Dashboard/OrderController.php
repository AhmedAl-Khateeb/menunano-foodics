<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $this->baseQuery($request)
            ->with('cashier')
            ->leftJoin('users as cashiers', 'orders.user_id', '=', 'cashiers.id')
            ->select('orders.*')
            ->orderBy('cashiers.name', 'asc')
            ->orderBy('orders.created_at', 'desc')
            ->latest()
            ->paginate(15);

        return view('orders.index', [
            'orders' => $orders,
            'pageTitle' => 'كل الطلبات',
            'pageType' => 'all',
            'stats' => $this->getStats($request),
        ]);
    }

    public function delivery(Request $request)
    {
        $orders = $this->baseQuery($request)
            ->delivery()
            ->with(['cashier', 'deliveryMan'])
            ->leftJoin('users as cashiers', 'orders.user_id', '=', 'cashiers.id')
            ->select('orders.*')
            ->orderBy('cashiers.name', 'asc')
            ->orderBy('orders.created_at', 'desc')
            ->paginate(15);

        return view('orders.index', [
            'orders' => $orders,
            'pageTitle' => 'طلبات التوصيل',
            'pageType' => 'delivery',
            'stats' => $this->getStats($request, 'delivery'),
        ]);
    }

    public function local(Request $request)
    {
        $orders = $this->baseQuery($request)
            ->local()
            ->with('cashier')
            ->leftJoin('users as cashiers', 'orders.user_id', '=', 'cashiers.id')
            ->select('orders.*')
            ->orderBy('cashiers.name', 'asc')
            ->orderBy('orders.created_at', 'desc')
            ->paginate(15);

        return view('orders.index', [
            'orders' => $orders,
            'pageTitle' => 'الطلبات المحلية',
            'pageType' => 'local',
            'stats' => $this->getStats($request, 'local'),
        ]);
    }

    public function pickup(Request $request)
    {
        $orders = $this->baseQuery($request)
            ->pickup()
            ->with('cashier')
            ->leftJoin('users as cashiers', 'orders.user_id', '=', 'cashiers.id')
            ->select('orders.*')
            ->orderBy('cashiers.name', 'asc')
            ->orderBy('orders.created_at', 'desc')
            ->paginate(15);

        return view('orders.index', [
            'orders' => $orders,
            'pageTitle' => 'طلبات الاستلام',
            'pageType' => 'pickup',
            'stats' => $this->getStats($request, 'pickup'),
        ]);
    }

    protected function baseQuery(Request $request)
    {
        $query = Order::query()
            ->ownedBy(auth()->id());

        if ($request->filled('status')) {
            $query->where('orders.status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('orders.type', $request->type);
        }

        if ($request->filled('source') && in_array($request->source, ['online', 'cachire'])) {
            $query->where('orders.source', $request->source);
        }

        if ($request->filled('payment_method')) {
            $query->where('orders.payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('orders.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('orders.created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('orders.id', $search)
                    ->orWhere('orders.name', 'like', "%{$search}%")
                    ->orWhere('orders.phone', 'like', "%{$search}%")
                    ->orWhereHas('cashier', function ($cashierQuery) use ($search) {
                        $cashierQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        return $query;
    }

    protected function getStats(Request $request, ?string $type = null): array
    {
        $query = $this->baseQuery($request);

        if ($type === 'delivery') {
            $query->delivery();
        } elseif ($type === 'pickup') {
            $query->pickup();
        } elseif ($type === 'local') {
            $query->local();
        }

        return [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('orders.status', 'pending')->count(),
            'served' => (clone $query)->where('orders.status', 'served')->count(),
            'returned' => (clone $query)->where('orders.status', 'returned')->count(),
            'sales' => (clone $query)->sum('orders.total_price'),
            'purchase_total' => $this->calculatePurchaseTotal(clone $query),
        ];
    }

    protected function calculatePurchaseTotal($query): float
    {
        $orders = $query->with(['items.inventory'])->get();

        return $orders->sum(function ($order) {
            return $order->items->sum(function ($item) {
                $quantity = (float) ($item->pivot->quantity ?? 1);

                $purchasePrice = (float) (
                    $item->inventory->avg_cost
                    ?? $item->inventory->purchase_price
                    ?? $item->purchase_price
                    ?? 0
                );

                return $purchasePrice * $quantity;
            });
        });
    }

    public function show(Order $order)
    {
        try {
            if ($order->user_id !== auth()->id()) {
                Alert::toast('You are not authorized to view this order', 'error');

                return redirect()->route('orders.index');
            }

            return view('orders.show', compact('order'));
        } catch (\Exception $exception) {
            Alert::toast('order not found', 'error');

            return redirect()->back();
        }
    }

    public function serve(Order $order, InventoryService $inventoryService)
    {
        try {
            if ($order->user_id !== auth()->id()) {
                Alert::toast('You are not authorized to update this order', 'error');

                return redirect()->route('orders.index');
            }

            if ($order->status === 'served') {
                Alert::warning('Order already served');

                return redirect()->back();
            }

            if ($order->status === 'returned') {
                Alert::warning('Order already returned');

                return redirect()->back();
            }

            DB::transaction(function () use ($order, $inventoryService) {
                $order->status = 'served';
                $order->save();

                $order->load('items.product');

                foreach ($order->items as $item) {
                    if ($item->product->type === 'manufactured') {
                        $inventoryService->deductCompositeStock(
                            $item,
                            $item->pivot->quantity,
                            $order->user_id
                        );
                    } elseif ($item->product->type === 'ready' && $item->inventory) {
                        $inventoryService->adjust(
                            $item->inventory,
                            'waste',
                            $item->pivot->quantity,
                            null,
                            "Order: #{$order->id} served",
                            $order->user_id
                        );
                    }
                }
            });

            Alert::success('Order served and inventory updated');

            return redirect()->back();
        } catch (\Exception $exception) {
            Alert::toast($exception->getMessage(), 'error');

            return redirect()->back();
        }
    }

    public function returnOrder(Order $order)
    {
        try {
            if ($order->user_id !== auth()->id()) {
                Alert::toast('You are not authorized to update this order', 'error');

                return redirect()->route('orders.index');
            }

            if ($order->status === 'returned') {
                Alert::warning('Order already returned');

                return redirect()->back();
            }

            $order->update([
                'status' => 'returned',
                'returned_at' => now(),
            ]);

            Alert::success('Order marked as returned');

            return redirect()->back();
        } catch (\Exception $exception) {
            Alert::toast($exception->getMessage(), 'error');

            return redirect()->back();
        }
    }

    public function returned(Request $request)
    {
        $orders = $this->baseQuery($request)
            ->where('status', 'returned')
            ->with('cashier')
            ->latest()
            ->paginate(15);

        return view('orders.returned', [
            'orders' => $orders,
            'pageTitle' => 'الطلبات المرتجعة',
        ]);
    }

    public function restoreReturned(Order $order)
    {
        try {
            if ($order->user_id !== auth()->id()) {
                Alert::toast('You are not authorized to update this order', 'error');

                return redirect()->route('orders.returned');
            }

            if ($order->status !== 'returned') {
                Alert::warning('هذا الطلب ليس مرتجع');

                return redirect()->back();
            }

            $order->status = 'served';

            if (\Schema::hasColumn('orders', 'returned_at')) {
                $order->returned_at = null;
            }

            $order->save();

            Alert::success('تم إرجاع الطلب من المرتجع إلى الطلبات مرة أخرى');

            return redirect()->route('orders.returned');
        } catch (\Exception $exception) {
            Alert::toast($exception->getMessage(), 'error');

            return redirect()->back();
        }
    }

    public function updateSource(Request $request, Order $order)
    {
        try {
            if ($order->user_id !== auth()->id()) {
                Alert::toast('You are not authorized to update this order', 'error');

                return redirect()->route('orders.index');
            }

            $request->validate([
                'source' => ['required', 'in:online,cachire'],
            ]);

            $order->source = $request->source;
            $order->save();

            Alert::success('تم تحديث مصدر الطلب بنجاح');

            return redirect()->back();
        } catch (\Exception $exception) {
            Alert::toast($exception->getMessage(), 'error');

            return redirect()->back();
        }
    }

    public function returnDeliveryOrder(Order $order)
    {
        try {
            if ($order->user_id !== auth()->id()) {
                Alert::toast('You are not authorized to update this order', 'error');

                return redirect()->route('orders.delivery');
            }

            if ($order->type !== 'delivery') {
                Alert::warning('هذا الطلب ليس طلب توصيل');

                return redirect()->back();
            }

            if ($order->status === 'returned') {
                Alert::warning('Order already returned');

                return redirect()->back();
            }

            $order->update([
                'status' => 'returned',
                'returned_at' => now(),
            ]);

            Alert::success('تم تحويل طلب التوصيل إلى مرتجع');

            return redirect()->back();
        } catch (\Exception $exception) {
            Alert::toast($exception->getMessage(), 'error');

            return redirect()->back();
        }
    }
}
