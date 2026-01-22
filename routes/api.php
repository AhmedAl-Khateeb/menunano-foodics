<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BusinessSettingController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CartController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// cron job
Route::get('cron', function () {
    $efected = User::query()
        ->where('role', 'admin')
        ->where('status', 1)
        ->where('subscription_start', '<', now())
        ->where('subscription_end', '<=', now())
        ->update([
            'status' => 0,
        ]);

    return response()->json([
        'message' => 'cron job done',
        'efected' => $efected,
    ]);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::get('/admin-images', [SettingController::class, 'getAdminImages']);

Route::get('/admin-status', [SettingController::class, 'getAdminStatus']);

Route::get('/business-settings', [BusinessSettingController::class, 'index']);

Route::get('terms', [TermController::class, 'index']);
Route::get('terms/{id}', [TermController::class, 'show']);

Route::get('/sections', [SectionController::class, 'index']);
Route::get('/sections/{id}', [SectionController::class, 'show']);

Route::get('/packages', [PackageController::class, 'activePackages']);

Route::get('/payment-methods', [PaymentMethodController::class, 'index']);

Route::post('subscription/renew', [SubscriptionController::class, 'renewSubscription']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/subscriptions', [SubscriptionController::class, 'store']);
});

Route::prefix('{storeName}')->group(function () {
    Route::get('settings', [SettingController::class, 'index']);
    Route::get('settings/{setting}', [SettingController::class, 'show']);

    Route::get('socials', [SocialController::class, 'index']);

    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{product}', [ProductController::class, 'show']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);

    Route::get('sliders', [SliderController::class, 'index']);
    Route::get('sliders/{slider}', [SliderController::class, 'show']);

    // Customer Authentication
    Route::post('customer/login', [CustomerAuthController::class, 'login']);

    Route::get('payment-methods', [PaymentMethodController::class, 'storeMethods']);

    // Cart and Order Management (requires customer authentication)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('cart', [CartController::class, 'index']);
        Route::post('cart/add', [CartController::class, 'add']);
        Route::put('cart/update/{id}', [CartController::class, 'update']);
        Route::delete('cart/remove/{id}', [CartController::class, 'destroy']);
        Route::delete('cart/clear', [CartController::class, 'clear']);
        Route::post('order/make', [OrderController::class, 'store']);
    });
});
