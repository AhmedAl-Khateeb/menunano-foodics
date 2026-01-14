<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::filter()
        ->where('user_id', auth()->id())
        ->latest()
        ->get();
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
            Alert::toast('order not found','error');
            return redirect()->back();
        }
    }

    public function serve(Order $order)
    {
        try {
            if ($order->user_id !== auth()->id()) {
                Alert::toast('You are not authorized to update this order', 'error');
                return redirect()->route('orders.index');
            }
            $order->status = 'served';
            $order->save();
            Alert::success('success');
            return redirect()->route('orders.index');
        } catch (\Exception $exception) {
            Alert::toast('order not found','error');
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
