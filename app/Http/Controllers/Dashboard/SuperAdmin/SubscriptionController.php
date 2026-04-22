<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $subscriptions = Subscription::with([
            'package.businessType',
            'paymentMethod',
            'user',
        ])
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('created_at', 'like', "%{$search}%");
            });
        })
        ->latest()->get();

        return view('super_admin.subscriptions.index', compact('subscriptions'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,active,rejected,cancelled,expired',
        ]);

        $subscription = Subscription::with(['package', 'user'])->findOrFail($id);

        if (!$subscription->package) {
            return redirect()
                ->route('subscriptions.index')
                ->with('error', 'لا توجد باقة مرتبطة بهذا الاشتراك');
        }

        if ($request->status === 'active') {
            $start = now();
            $end = $start->copy()->addDays((int) $subscription->package->duration);

            $subscription->update([
                'status' => 'active',
                'is_active' => true,
                'price_paid' => $subscription->price_paid ?: $subscription->package->price,
                'starts_at' => $start,
                'ends_at' => $end,
            ]);

            if ($subscription->user && (int) $subscription->user->status !== 1) {
                $subscription->user->update([
                    'status' => 1,
                ]);
            }
        }

        if ($request->status === 'rejected') {
            $subscription->update([
                'status' => 'rejected',
                'is_active' => false,
                'starts_at' => null,
                'ends_at' => null,
            ]);
        }

        if ($request->status === 'pending') {
            $subscription->update([
                'status' => 'pending',
                'is_active' => false,
                'starts_at' => null,
                'ends_at' => null,
            ]);
        }

        if ($request->status === 'cancelled') {
            $subscription->update([
                'status' => 'cancelled',
                'is_active' => false,
                'starts_at' => null,
                'ends_at' => null,
            ]);
        }

        if ($request->status === 'expired') {
            $subscription->update([
                'status' => 'expired',
                'is_active' => false,
                'ends_at' => now(),
            ]);
        }

        return redirect()
            ->route('subscriptions.index')
    ->with('success', 'تم تحديث حالة الاشتراك بنجاح ✅');
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);

        if ($subscription->receipt_image && Storage::disk('public')->exists($subscription->receipt_image)) {
            Storage::disk('public')->delete($subscription->receipt_image);
        }

        $subscription->delete();

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'تم حذف الطلب بنجاح');
    }
}
