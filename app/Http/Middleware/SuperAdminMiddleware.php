<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // أو أي صفحة دخول عندك
        }

        // تحقق أن الدور هو super_admin
        if (Auth::user()->role !== 'super_admin') {
            abort(403, 'غير مسموح لك بالدخول هنا');
        }

        return $next($request);
    }
}
