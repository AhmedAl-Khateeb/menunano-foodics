<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Models\CartItem;
use App\Traits\StoreHelper;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    use StoreHelper;

    /**
     * Get all cart items for authenticated customer
     * 
     * @param string $storeName
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($storeName)
    {
        // Get authenticated customer from token
        $customer = auth('sanctum')->user();

        if (!$customer) {
            return ApiResponse::serverError('Unauthorized', 401);
        }

        // Verify customer belongs to this store
        $user = $this->getUserByStoreName($storeName);
        if ($customer->user_id !== $user->id) {
            return ApiResponse::serverError('Unauthorized', 403);
        }

        // Get cart items with product details
        $cartItems = $customer->cartItems()
            ->with('productSize.product')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->productSize->price;
        });

        return ApiResponse::success([
            'items' => CartItemResource::collection($cartItems),
            'total' => $total,
            'count' => $cartItems->count(),
        ]);
    }

    /**
     * Add item to cart or update quantity if exists
     * 
     * @param AddToCartRequest $request
     * @param string $storeName
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(AddToCartRequest $request, $storeName)
    {
        // Get authenticated customer from token
        $customer = auth('sanctum')->user();

        if (!$customer) {
            return ApiResponse::serverError('Unauthorized', 401);
        }

        // Verify customer belongs to this store
        $user = $this->getUserByStoreName($storeName);
        if ($customer->user_id !== $user->id) {
            return ApiResponse::serverError('Unauthorized', 403);
        }

        DB::beginTransaction();
        try {
            // Find existing cart item or create new one
            $cartItem = CartItem::where('customer_id', $customer->id)
                ->where('product_size_id', $request->product_size_id)
                ->first();

            if ($cartItem) {
                // Update existing item quantity
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                // Create new cart item
                $cartItem = CartItem::create([
                    'customer_id' => $customer->id,
                    'product_size_id' => $request->product_size_id,
                    'quantity' => $request->quantity,
                ]);
            }

            $cartItem->load('productSize.product');

            DB::commit();
            return ApiResponse::created(new CartItemResource($cartItem));
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::serverError($e->getMessage());
        }
    }

    /**
     * Update cart item quantity
     * 
     * @param UpdateCartItemRequest $request
     * @param string $storeName
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCartItemRequest $request, $storeName, $id)
    {
        // Get authenticated customer from token
        $customer = auth('sanctum')->user();

        if (!$customer) {
            return ApiResponse::serverError('Unauthorized', 401);
        }

        // Verify customer belongs to this store
        $user = $this->getUserByStoreName($storeName);
        if ($customer->user_id !== $user->id) {
            return ApiResponse::serverError('Unauthorized', 403);
        }

        // Find cart item and verify ownership
        $cartItem = CartItem::where('customer_id', $customer->id)
            ->findOrFail($id);

        $cartItem->update(['quantity' => $request->quantity]);
        $cartItem->load('productSize.product');

        return ApiResponse::updated(new CartItemResource($cartItem));
    }

    /**
     * Remove item from cart
     * 
     * @param string $storeName
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($storeName, $id)
    {
        // Get authenticated customer from token
        $customer = auth('sanctum')->user();

        if (!$customer) {
            return ApiResponse::serverError('Unauthorized', 401);
        }

        // Verify customer belongs to this store
        $user = $this->getUserByStoreName($storeName);
        if ($customer->user_id !== $user->id) {
            return ApiResponse::serverError('Unauthorized', 403);
        }

        // Find cart item and verify ownership
        $cartItem = CartItem::where('customer_id', $customer->id)
            ->findOrFail($id);

        $cartItem->delete();

        return ApiResponse::deleted();
    }

    /**
     * Clear all cart items for authenticated customer
     * 
     * @param string $storeName
     * @return \Illuminate\Http\JsonResponse
     */
    public function clear($storeName)
    {
        // Get authenticated customer from token
        $customer = auth('sanctum')->user();

        if (!$customer) {
            return ApiResponse::serverError('Unauthorized', 401);
        }

        // Verify customer belongs to this store
        $user = $this->getUserByStoreName($storeName);
        if ($customer->user_id !== $user->id) {
            return ApiResponse::serverError('Unauthorized', 403);
        }

        $customer->cartItems()->delete();

        return ApiResponse::deleted();
    }
}
