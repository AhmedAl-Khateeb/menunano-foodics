<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::where('is_active', 1)
            ->get(['id','name','description','phone']);

        return response()->json([
            'status' => true,
            'message' => 'Payment Methods Avillable',
            'data' => $methods,
        ]);
    }
}
