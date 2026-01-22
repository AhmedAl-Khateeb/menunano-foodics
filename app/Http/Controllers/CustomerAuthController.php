<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\CustomerLoginRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Traits\StoreHelper;

class CustomerAuthController extends Controller
{
    use StoreHelper;

    /**
     * Customer login/register endpoint
     * Creates new customer or returns existing one with access token
     * 
     * @param CustomerLoginRequest $request
     * @param string $storeName
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(CustomerLoginRequest $request, $storeName)
    {
        // Get store owner by store name
        $user = $this->getUserByStoreName($storeName);

        // Find or create customer
        $customer = Customer::firstOrCreate(
            [
                'user_id' => $user->id,
                'phone' => $request->phone
            ],
            [
                'name' => $request->name
            ]
        );

        // Generate access token for customer
        $token = $customer->createToken('customer-token')->plainTextToken;

        return ApiResponse::success([
            'customer' => new CustomerResource($customer),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
