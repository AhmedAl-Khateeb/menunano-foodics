<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

use App\Traits\StoreHelper;

class PaymentMethodController extends Controller
{
    use StoreHelper;

    public function index()
    {
        $methods = PaymentMethod::where('is_active', 1)
            ->whereNull('created_by') // System wide methods for subscriptions
            ->get(['id', 'name', 'description', 'phone']);

        return response()->json([
            'status' => true,
            'message' => 'Payment Methods Avillable',
            'data' => $methods,
        ]);
    }

    public function storeMethods($storeName)
    {
        $user = $this->getUserByStoreName($storeName);

        $methods = PaymentMethod::where('is_active', 1)
            ->where('created_by', $user->id)
            ->get(['id', 'name', 'description', 'phone']);

        return response()->json([
            'status' => true,
            'message' => 'Store Payment Methods',
            'data' => $methods,
        ]);
    }
}
