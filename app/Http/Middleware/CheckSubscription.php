<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class CheckSubscription
{
    public function handle(Request $request, \Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $hasActiveSubscription = $user->subscriptions()
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
