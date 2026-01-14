<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['package', 'paymentMethod' , 'user'])
            ->latest()
            ->get();

        return view('super_admin.subscriptions.index', compact('subscriptions'));
    }

   public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,approved,rejected',
    ]);

    $subscription = Subscription::findOrFail($id);

    // تحديث حالة الاشتراك
    $subscription->status = $request->status;
    $subscription->save();

    // في حالة الموافقة
    if ($request->status === 'approved') {
        $user = $subscription->user; // العلاقة بين Subscription و User

        if ($user) {
            // نحضر الباقة المرتبطة
            $package = Package::find($subscription->package_id);

            // نحدد بداية ونهاية الاشتراك
            $start = now();
            $end = $package ? $start->copy()->addDays($package->duration) : null;

            $user->update([
                'status'             => 1,
                'subscription_start' => $start,
                'subscription_end'   => $end,
                'package_id'         => $subscription->package_id,
            ]);
        }
    }

    return redirect()->route('subscriptions.index')
        ->with('success', 'تم تحديث حالة الاشتراك بنجاح ✅');
}

     public function destroy($id)
{
    $subscription = Subscription::findOrFail($id);

    // لو عندك صورة محفوظة ممكن تمسحها
    if ($subscription->receipt_image && Storage::exists('public/' . $subscription->receipt_image)) {
        Storage::delete('public/' . $subscription->receipt_image);
    }

    $subscription->delete();

    return redirect()->route('subscriptions.index')->with('success', 'تم حذف الطلب بنجاح');
}
}
