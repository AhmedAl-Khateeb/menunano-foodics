<?php

namespace App\Http\Middleware;

use App\Models\User;
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

        /*
         * لو Admin نفحص الباقة الخاصة به
         * لو Cashier / Employee نفحص باقة صاحب المتجر created_by
         */
        $storeOwner = $user;

        if ($user->role !== 'admin') {
            $storeOwner = User::find($user->created_by);
        }

        if (!$storeOwner) {
            return redirect()->route('inactive')
                ->with('permission_denied', 'لا يوجد صاحب متجر مرتبط بهذا المستخدم.');
        }

        if (!$storeOwner->hasPackagePermission($permission)) {
            abort(403, 'هذه الميزة غير متاحة في الباقة الحالية.');
        }

        return $next($request);
    }
}