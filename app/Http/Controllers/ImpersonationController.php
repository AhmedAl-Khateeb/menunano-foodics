<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function impersonate($userId)
    {
        $user = User::findOrFail($userId);
        $currentUser = auth()->user();

        // Security Check: Only allow Store Admin to impersonate their own users
        if ($currentUser->role !== 'admin' || $user->created_by !== $currentUser->id) {
            abort(403, 'Unauthorized action.');
        }

        // Store original user ID
        session()->put('impersonated_by', $currentUser->id);

        Auth::loginUsingId($user->id);

        return redirect()->route('dashboard')->with('success', 'You are now impersonating ' . $user->name);
    }

    public function leave()
    {
        if (!session()->has('impersonated_by')) {
            return redirect()->route('dashboard');
        }

        $originalUserId = session('impersonated_by');
        
        Auth::loginUsingId($originalUserId);
        session()->forget('impersonated_by');

        return redirect()->route('users.index')->with('success', 'You have returned to your account.');
    }
}
