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
        $customer = auth('sanctum')->user();
        if (!$customer) {
            return ApiResponse::serverError('Unauthorized', 401);
        }

        $user = $this->getUserByStoreName($storeName);
        if ($customer->user_id !== $user->id) {
            return ApiResponse::serverError('Unauthorized', 403);
        }

        $cartItems = $customer->cartItems()->with('productSize')->get();

        if ($cartItems->isEmpty()) {
            return ApiResponse::serverError('Cart is empty', 400);
        }

        DB::beginTransaction();

        try {
            $totalPrice = $cartItems->sum(function ($item) {
                return $item->productSize->price * $item->quantity;
            });

            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            }

            $order = Order::create([
                'user_id' => $user->id,
                'customer_id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'address' => $request->address,
                'total_price' => $totalPrice,
                'payment_method' => $request->payment_method,
                'payment_proof' => $paymentProofPath,
                'status' => 'pending'
            ]);

            foreach ($cartItems as $item) {
                $order->items()->attach($item->product_size_id, [
                    'price' => $item->productSize->price,
                    'quantity' => $item->quantity,
                ]);
            }

            // Clear the cart
            $customer->cartItems()->delete();

            DB::commit();

            return ApiResponse::created(new OrderResource($order));
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::serverError($e->getMessage());
        }
    }
}
