<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Traits\StoreHelper;

class OrderController extends Controller
{
    use StoreHelper;

    public function store(OrderStoreRequest $request, $storeName)
    {
        DB::beginTransaction();

        try {
            // صاحب المحل (المتجر الحالي)
            $user = $this->getUserByStoreName($storeName);

            $totalPrice = collect($request->items)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            $order = Order::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);

            foreach ($request->items as $item) {
                $order->items()->attach($item['product_size_id'], [
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }

            DB::commit();

            return ApiResponse::created(new OrderResource($order));

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::serverError($e->getMessage());
        }
    }
}
