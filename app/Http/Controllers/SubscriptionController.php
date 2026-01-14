<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Http\Requests\StoreSubscriptionRequest;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(StoreSubscriptionRequest $request)
{
    $user = auth()->user();

    $data = $request->validated();
    $data['user_id'] = $user->id;
    $data['package_id'] = $user->package_id;
// لاحظ هنا صديقي المبرمج ان اسم الصورة في الداتابيز  receipt_image ولكن اسمها في ال request recipt_image من غير e وده كان لظروف كدا معينة واحنا شغالين فخلي بالك لو هتعدل عشان متحتارش
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
    // تجهيز الرقم مع كود الدولة
    $registeredPhone = $request->registered_phone;

    if (!str_starts_with($registeredPhone, '+2')) {
        $registeredPhone = '+20' . ltrim($registeredPhone, '0'); 
        // هيشيل 0 من الأول ويضيف +2
    }

    // تعديل القيم في الـ request نفسها
    $request->merge([
        'registered_phone' => $registeredPhone,
    ]);
    
    $request->validate([
       'registered_phone'   => 'required|string|exists:users,phone',
        'phone'              => 'required|string',
        'package_id'         => 'required|exists:packages,id',
        'payment_method_id'  => 'required|exists:payment_methods,id',
        'receipt_image'      => 'required|image|mimes:jpg,jpeg,heic,png|max:7000',
    ]);

    // جلب المستخدم عبر رقم الهاتف
    $user = User::where('phone', $request->registered_phone)->first();

    if (!$user) {
        return response()->json([
            'status'  => false,
            'message' => 'User not found with this phone number',
        ], 404);
    }

    // رفع صورة الإيصال
    $path = $request->file('receipt_image')->store('receipts', 'public');

    // إنشاء الاشتراك
    $subscription = Subscription::create([
        'user_id'           => $user->id,
        'package_id'        => $request->package_id,
        'payment_method_id' => $request->payment_method_id,
        'phone'             => $request->phone,
        'receipt_image'     => $path,
        'status'            => 'pending',
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'Subscription request submitted successfully',
        'data'    => $subscription,
    ], 201);
}


}
