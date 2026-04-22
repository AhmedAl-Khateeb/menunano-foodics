<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class CheckPackagePermission
{
    public function handle(Request $request, \Closure $next, string $permission)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // السوبر أدمن يمر دائمًا
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        if (!$user->hasPackagePermission($permission)) {
            return redirect()
                ->route('dashboard')
                ->with('permission_denied', 'انتهت الباقة أو هذه الميزة غير متاحة حاليًا، يمكنك استعراض الواجهة فقط حتى يتم التجديد.');
        }

        return $next($request);
    }
}
