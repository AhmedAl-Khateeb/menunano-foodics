<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBranchPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = auth('web')->user();

        abort_unless($user, 403);

        if ($user->role === 'super_admin') {
            return $next($request);
        }

        abort_unless(
            $user->hasBranchPermission($permission),
            403,
            'ليس لديك صلاحية للوصول إلى هذه الصفحة.'
        );

        return $next($request);
    }
}