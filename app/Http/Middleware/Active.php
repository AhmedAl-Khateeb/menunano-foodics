<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class Active
{
    public function handle(Request $request, \Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // السوبر أدمن لا يخضع لفحص التفعيل/الاشتراك
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        if ((int) $user->status !== 1) {
            return redirect()->route('inactive');
        }

        return $next($request);
    }
}
