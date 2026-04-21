<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use App\Http\Requests\StoreSubscriptionRequest;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(StoreSubscriptionRequest $request)
    {
        $user = auth()->user();
        $package = Package::findOrFail($request->package_id);

        $data = $request->validated();
        $data['user_id'] = $user->id;
        $data['package_id'] = $package->id;
        $data['price_paid'] = $package->price;
        $data['status'] = 'pending';
        $data['is_active'] = false;
        $data['starts_at'] = null;
        $data['ends_at'] = null;

        // اسم الحقل في الريكويست recipt_image
        if ($request->hasFile('recipt_image')) {
            $data['receipt_image'] = $request->file('recipt_image')->store('receipts', 'public');
        }

        $subscription = Subscription::create($data);

        return response()->json([
            'message' => 'Subscription created successfully',
            'subscription' => $subscription,
        ]);
    }

    public function renewSubscription(Request $request)
    {
        $registeredPhone = $request->registered_phone;

        if (!str_starts_with($registeredPhone, '+2')) {
            $registeredPhone = '+20' . ltrim($registeredPhone, '0');
        }

        $request->merge([
            'registered_phone' => $registeredPhone,
        ]);

        $request->validate([
            'registered_phone'  => 'required|string|exists:users,phone',
            'phone'             => 'required|string',
            'package_id'        => 'required|exists:packages,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'receipt_image'     => 'required|image|mimes:jpg,jpeg,heic,png|max:7000',
        ]);

        $user = User::where('phone', $request->registered_phone)->firstOrFail();
        $package = Package::findOrFail($request->package_id);

        $path = $request->file('receipt_image')->store('receipts', 'public');

        $subscription = Subscription::create([
            'user_id'           => $user->id,
            'package_id'        => $package->id,
            'payment_method_id' => $request->payment_method_id,
            'phone'             => $request->phone,
            'receipt_image'     => $path,
            'price_paid'        => $package->price,
            'starts_at'         => null,
            'ends_at'           => null,
            'status'            => 'pending',
            'is_active'         => false,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Subscription request submitted successfully',
            'data'    => $subscription,
        ], 201);
    }
}