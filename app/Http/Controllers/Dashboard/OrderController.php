<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $this->baseQuery($request)
            ->latest()
            ->paginate(15);

        return view('orders.index', [
            'orders' => $orders,
            'pageTitle' => 'كل الطلبات',
            'pageType' => 'all',
            'stats' => $this->getStats(),
        ]);
    }

    public function delivery(Request $request)
    {
        $orders = $this->baseQuery($request)
            ->delivery()
            ->latest()
            ->paginate(15);

        return view('orders.index', [
            'orders' => $orders,
            'pageTitle' => 'طلبات التوصيل',
            'pageType' => 'delivery',
            'stats' => $this->getStats('delivery'),
        ]);
    }

    public function local(Request $request)
    {
        $orders = $this->baseQuery($request)
            ->local()
            ->latest()
            ->paginate(15);

        return view('orders.index', [
            'orders' => $orders,
            'pageTitle' => 'الطلبات المحلية',
            'pageType' => 'local',
            'stats' => $this->getStats('local'),
        ]);
    }

    public function pickup(Request $request)
    {
        $orders = $this->baseQuery($request)
            ->pickup()
            ->latest()
            ->paginate(15);

        return view('orders.index', [
            'orders' => $orders,
            'pageTitle' => 'طلبات الاستلام',
            'pageType' => 'pickup',
            'stats' => $this->getStats('pickup'),
        ]);
    }

    protected function baseQuery(Request $request)
    {
        $query = Order::query()
        ->ownedBy(auth()->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    protected function getStats(?string $type = null): array
    {
        $query = Order::query()->ownedBy(auth()->id());

        if ($type === 'delivery') {
            $query->delivery();
        } elseif ($type === 'pickup') {
            $query->pickup();
        } elseif ($type === 'local') {
            $query->local();
        }

        return [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'served' => (clone $query)->where('status', 'served')->count(),
            'sales' => (clone $query)->sum('total_price'),
        ];
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

    public function serve(Order $order, \App\Services\InventoryService $inventoryService)
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
}
