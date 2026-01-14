<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveUserMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status == 0) {
            Auth::logout();

            return redirect()->route('inactive')
                ->withErrors(['email' => 'حسابك غير نشط. تواصل مع الإدارة.']);
        }

        return $next($request);
    }
}
