<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPackagePermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPackagePermission($permission)) {
            abort(403, 'ليس لديك صلاحية الوصول');
        }

        return $next($request);
    }
}