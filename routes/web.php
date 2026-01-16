<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\SuperAdmin\BusinessSettingController;
use App\Http\Controllers\Dashboard\SuperAdmin\AdminController;
use App\Http\Controllers\Dashboard\SuperAdmin\TermsAndConditionsController;
use App\Http\Controllers\Dashboard\SuperAdmin\PackageController;
use App\Http\Controllers\Dashboard\SuperAdmin\PaymentMethodController;
use App\Http\Controllers\Dashboard\SuperAdmin\SubscriptionController;
use App\Http\Controllers\Dashboard\SuperAdmin\SectionController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\RoleController;
use Illuminate\Support\Facades\Route;


Route::get('/inactive', function () {
    return view('inactive');
})->name('inactive');

Route::get('/clear-cache', function () {
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');
    \Artisan::call('route:clear');
    \Artisan::call('cache:clear');
    return 'Cache cleared ✅';
});


Route::middleware(['auth', 'super_admin'])->prefix('super')->group(function () {
    Route::get('business-settings', [BusinessSettingController::class, 'index'])->name('business_settings.index');
    Route::post('business-settings', [BusinessSettingController::class, 'update'])->name('business_settings.update');
    Route::resource('admins', AdminController::class);
    Route::patch('/admins/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admins.toggleStatus');
    Route::post('/admins/deactivate-all', [AdminController::class, 'deactivateAll'])->name('admins.deactivateAll');
    Route::resource('terms', TermsAndConditionsController::class)->except(['show']);
    Route::resource('packages', PackageController::class)->except(['show']);
    Route::resource('payment-methods', PaymentMethodController::class)->except(['show']);
    Route::patch('payment-methods/{id}/toggle', [PaymentMethodController::class, 'toggle'])->name('payment-methods.toggle');
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscriptions/{id}/update-status', [SubscriptionController::class, 'updateStatus'])->name('subscriptions.updateStatus');
    Route::delete('/subscriptions/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
    Route::resource('sections', SectionController::class)->except(['show']);
});

Route::middleware(['auth', 'active', 'CheckSubscription'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('', [CategoryController::class, 'index']);
    Route::resource(
        'categories',
        CategoryController::class
    )->except('create', 'edit');


    Route::resource(
        'products',
        ProductController::class
    )->except('create', 'edit');

    Route::resource(
        'sliders',
        SliderController::class
    )->except('create', 'edit');

    Route::get(
        'orders',
        [OrderController::class, 'index']
    )->name('orders.index');

    Route::get(
        'orders/{order}',
        [OrderController::class, 'show']
    )->name('order.show');

    Route::put(
        'orders/{order}',
        [OrderController::class, 'serve']
    )->name('orders.serve');

    Route::get(
        'settings',
        [SettingController::class, 'index']
    )->name('settings.index');

    Route::put(
        'settings/{setting}',
        [SettingController::class, 'update']
    )->name('settings.update');
    Route::get('/orders-count', function () {
        return response()->json([
            'count' => Order::count()
        ]);
    })->name('orders.count');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings/{setting}', [SettingController::class, 'update'])->name('settings.update');

    // User Management
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('payment-methods', PaymentMethodController::class);
});
