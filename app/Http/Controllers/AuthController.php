<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
     public function register(RegisterRequest $request)
{
    $imagePath = null;
    if ($request->hasFile('receipt_image')) {
        $imagePath = $request->file('receipt_image')->store('users', 'public');
    }
    $package = Package::find($request->package_id);
    $status = 0;
    $subscriptionStart = null;
    $subscriptionEnd = null;

    if ($package) {
        if ($package->price == 0) {
            $status = 1;
            $subscriptionStart = now();
            $subscriptionEnd = now()->addDays($package->duration);
        }
    }


    // إنشاء المستخدم
    $user = User::create([
        'email' => $request->email,
        'phone' => $request->phone,
        'store_name' => $request->store_name,
        'password' => Hash::make($request->password),
        'image' => $imagePath,
        'package_id' => $request->package_id,
        'status' => $status,
        'subscription_start' => $subscriptionStart,
        'subscription_end' => $subscriptionEnd,
        'role' => 'admin',
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return ApiResponse::success([
        'user' => $user,
        'access_token' => $token,
        'token_type' => 'bearer',
    ], 'registered successfully');
}



    public function login(Request $request)
    {
        $request->validate(['password' => 'required|string']);
        $user = User::get()->firstOrFail();


        if (!Hash::check($request->password, $user->password)) {
            return ApiResponse::unauthrized('can\'t login.');
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        
        $redirectTo = null;

    if ($user->role === 'admin' && $user->status == 1) {
        $redirectTo = route('dashboard');
    }

    if ($user->role === 'super_admin') {
        $redirectTo = route('admins.index');
    }

        return ApiResponse::success([
            [
                'access_token' => $token,
                'role' => $user->role,
                'redirect_to'  => $redirectTo,
                'token_type' => 'bearer',
            ]
        ],'logged in successfully');
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return ApiResponse::message('Logged out successfully');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string',
        ]);

        $user = User::get()->first();

        if (!Hash::check($request->old_password, $user->password)) {
            return ApiResponse::validationError(['old_password' => 'Wrong old password']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);
        $user->tokens()->delete();
        return ApiResponse::message('Password successfully changed');
    }
}

