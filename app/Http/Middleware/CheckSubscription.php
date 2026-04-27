<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;

class CheckSubscription
{
    public function handle(Request $request, \Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // السوبر أدمن لا يخضع للاشتراك
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        /*
         * لو المستخدم Admin: نفحص اشتراكه هو
         * لو المستخدم كاشير/موظف: نفحص اشتراك صاحب المتجر created_by
         */
        $storeOwner = $user;

        if ($user->role !== 'admin') {
            $storeOwner = User::find($user->created_by);
        }

        if (!$storeOwner) {
            return redirect()->route('inactive');
        }

        $hasActiveSubscription = $storeOwner->subscriptions()
            ->where('status', 'active')
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->exists();

        if (!$hasActiveSubscription) {
            return redirect()->route('inactive');
        }

        return $next($request);
    }
}
