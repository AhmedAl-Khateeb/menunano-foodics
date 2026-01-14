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
use Illuminate\Support\Facades\Route;

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

    Route::post('order/make', [OrderController::class, 'store']);
});





