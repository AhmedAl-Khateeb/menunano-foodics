<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Get customers for the currently authenticated store owner
        $customers = Customer::where('user_id', auth()->id())->latest()->get();
        return view('dashboard.customers.index', compact('customers'));
    }
}
