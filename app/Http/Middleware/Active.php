<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;

class Active
{
    public function handle(Request $request, \Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role === 'super_admin') {
            return $next($request);
        }

        $storeOwner = $user;

        if ($user->role !== 'admin') {
            $storeOwner = User::find($user->created_by);
        }

        if (!$storeOwner || (int) $storeOwner->status !== 1) {
            return redirect()->route('inactive');
        }

        if ((int) $user->status !== 1) {
            return redirect()->route('inactive');
        }

        return $next($request);
    }
}
