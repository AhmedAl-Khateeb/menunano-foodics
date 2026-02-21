<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::filter()
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);
        return view('orders.index', compact('orders'));
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

                // Deduct inventory for each item
                $order->load('items.product');
                foreach ($order->items as $item) {
                    // $item is a ProductSize instance because of the relationship in Order model
                    if ($item->product->type === 'manufactured') {
                        $inventoryService->deductCompositeStock(
                            $item, 
                            $item->pivot->quantity, 
                            $order->user_id
                        );
                    } else if ($item->product->type === 'ready' && $item->inventory) {
                        // Optional: Also deduct for 'ready' items if they are tracked directly
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
            return redirect()->route('orders.index');
        } catch (\Exception $exception) {
            Alert::toast($exception->getMessage(), 'error');
            return redirect()->back();
        }
    }

    //    public function destroy(Order $order)
    //    {
    //        try {
    //            $order->delete();
    //            ApiResponse::deleted();
    //            Alert::success('success', 'slider deleted successfully');
    //            return redirect()->route('sliders.index');
    //        } catch (\Exception $exception) {
    //            Alert::toast('slider not deleted','error');
    //            return redirect()->back();
    //        }
    //    }

}
