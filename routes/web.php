<?php

use App\Http\Controllers\Dashboard\AttendanceController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\ShiftController;
use App\Http\Controllers\Dashboard\ShowController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\SuperAdmin\AdminController;
use App\Http\Controllers\Dashboard\SuperAdmin\BusinessSettingController;
use App\Http\Controllers\Dashboard\SuperAdmin\BusinessTypeController;
use App\Http\Controllers\Dashboard\SuperAdmin\PackageController;
use App\Http\Controllers\Dashboard\SuperAdmin\PaymentMethodController;
use App\Http\Controllers\Dashboard\SuperAdmin\SectionController;
use App\Http\Controllers\Dashboard\SuperAdmin\SubscriptionController;
use App\Http\Controllers\Dashboard\SuperAdmin\TermsAndConditionsController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\UserController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::get('/inactive', function () {
    return view('inactive');
})->name('inactive');

Route::get('/clear-cache', function () {
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');

    return 'Cache cleared ✅';
});

Route::middleware(['auth', 'super_admin'])->prefix('super')->group(function () {
    Route::get('business-settings', [BusinessSettingController::class, 'index'])->name('business_settings.index');
    Route::post('business-settings', [BusinessSettingController::class, 'update'])->name('business_settings.update');
    Route::get('/admins/get-categories/{id}', [AdminController::class, 'getCategories'])->name('admins.categories');
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
    Route::get('/dashboard', [ShowController::class, 'index'])->name('dashboard');

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
            'count' => Order::count(),
        ]);
    })->name('orders.count');

    // الحضور ولانصراف
    Route::resource('attendances', AttendanceController::class)->except(['show']);
    // الشيفتات
    Route::resource('shifts', ShiftController::class)->except(['show']);
    Route::post('shifts/{shift}/close', [ShiftController::class, 'close'])->name('shifts.close');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings/{setting}', [SettingController::class, 'update'])->name('settings.update');

    // Specific User Routes (MUST be defined before resource route)
    Route::get('/users/staff', function () { return redirect()->route('under.development'); })->name('users.staff');
    Route::get('/users/customers', [App\Http\Controllers\Dashboard\CustomerController::class, 'index'])->name('users.customers');

    // User Management
    Route::resource('business-types', BusinessTypeController::class)->except(['show']);
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('roles', RoleController::class);
    Route::resource('branches', App\Http\Controllers\Dashboard\BranchController::class);
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::resource('delivery_men', App\Http\Controllers\DeliveryManController::class)->except(['show']);
    Route::resource('suppliers', App\Http\Controllers\SupplierController::class)->except(['show']);
    Route::resource('purchases', App\Http\Controllers\PurchaseInvoiceController::class)->except(['edit', 'update']);

    // Impersonation
    Route::get('/impersonate/leave', [App\Http\Controllers\ImpersonationController::class, 'leave'])->name('impersonate.leave');
    Route::get('/impersonate/{id}', [App\Http\Controllers\ImpersonationController::class, 'impersonate'])->name('impersonate');

    // POS / Quick Sale
    Route::get('/pos', App\Livewire\PosPage::class)->name('pos.index');

    // Under Development Route
    Route::get('/under-development', function () {
        return view('under-development');
    })->name('under.development');

    // Placeholders for new structure

    // Shift Pause Route (Called via AJAX on logout)
    Route::post('/shifts/pause', function () {
        $activeShift = App\Models\Shift::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();
        if ($activeShift) {
            $activeShift->update(['status' => 'paused']);
        }

        return response()->json(['success' => true]);
    })->name('shifts.pause');

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');

        Route::get('/delivery', [OrderController::class, 'delivery'])->name('delivery');
        Route::get('/local', [OrderController::class, 'local'])->name('local');
        Route::get('/pickup', [OrderController::class, 'pickup'])->name('pickup');

        Route::get('/{order}', [OrderController::class, 'show'])
            ->whereNumber('order')
            ->name('show');

        Route::patch('/{order}/serve', [OrderController::class, 'serve'])
            ->whereNumber('order')
            ->name('serve');
    });

    // Orders
    Route::get('/orders/new', function () { return redirect()->route('under.development'); })->name('orders.new');
    Route::get('/orders/ongoing', function () { return redirect()->route('under.development'); })->name('orders.ongoing');
    Route::get('/orders/completed', function () { return redirect()->route('under.development'); })->name('orders.completed');
    Route::get('/orders/filter', function () { return redirect()->route('under.development'); })->name('orders.filter');

    // Products
    Route::get('/products/addons', function () { return redirect()->route('under.development'); })->name('products.addons');
    Route::get('/products/active', function () { return redirect()->route('under.development'); })->name('products.active');

    // Inventory & Items Module
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/reconcile', App\Livewire\StockReconciliation::class)->name('reconcile');
        // Ready Items
        Route::get('/ready', [App\Http\Controllers\Dashboard\ReadyItemController::class, 'index'])->name('ready.index');
        Route::get('/ready/create', [App\Http\Controllers\Dashboard\ReadyItemController::class, 'create'])->name('ready.create');
        Route::post('/ready', [App\Http\Controllers\Dashboard\ReadyItemController::class, 'store'])->name('ready.store');
        Route::get('/ready/{id}/edit', [App\Http\Controllers\Dashboard\ReadyItemController::class, 'edit'])->name('ready.edit');
        Route::put('/ready/{id}', [App\Http\Controllers\Dashboard\ReadyItemController::class, 'update'])->name('ready.update');
        Route::put('/ready/{id}/convert', [App\Http\Controllers\Dashboard\ReadyItemController::class, 'convertToComposite'])->name('ready.convert');
        Route::post('/ready/{id}/adjust', [App\Http\Controllers\Dashboard\ReadyItemController::class, 'adjustStock'])->name('ready.adjust');
        Route::get('/ready/{id}/history', [App\Http\Controllers\Dashboard\ReadyItemController::class, 'history'])->name('ready.history');

        // Composite Items
        Route::get('/composite', [App\Http\Controllers\Dashboard\CompositeItemController::class, 'index'])->name('composite.index');
        Route::get('/composite/create', [App\Http\Controllers\Dashboard\CompositeItemController::class, 'create'])->name('composite.create');
        Route::post('/composite', [App\Http\Controllers\Dashboard\CompositeItemController::class, 'store'])->name('composite.store');
        Route::get('/composite/{id}/edit', [App\Http\Controllers\Dashboard\CompositeItemController::class, 'edit'])->name('composite.edit');
        Route::put('/composite/{id}', [App\Http\Controllers\Dashboard\CompositeItemController::class, 'update'])->name('composite.update');
        Route::get('/composite/{id}/recipe', [App\Http\Controllers\Dashboard\CompositeItemController::class, 'editRecipe'])->name('composite.recipe.edit');
        Route::post('/composite/{id}/recipe', [App\Http\Controllers\Dashboard\CompositeItemController::class, 'addIngredient'])->name('composite.recipe.add');
        Route::delete('/composite/recipe/{recipe_id}', [App\Http\Controllers\Dashboard\CompositeItemController::class, 'removeIngredient'])->name('composite.recipe.remove');

        // Inventory Categories
        Route::resource('categories', App\Http\Controllers\Dashboard\InventoryCategoryController::class)->except(['create', 'edit', 'show']);

        // Inventory Movements
        Route::get('/movements', [App\Http\Controllers\Dashboard\InventoryMovementController::class, 'index'])->name('movements.index');

        // Raw Materials
        Route::get('/raw', [App\Http\Controllers\Dashboard\RawMaterialController::class, 'index'])->name('raw.index');
        Route::get('/raw/create', [App\Http\Controllers\Dashboard\RawMaterialController::class, 'create'])->name('raw.create');
        Route::post('/raw', [App\Http\Controllers\Dashboard\RawMaterialController::class, 'store'])->name('raw.store');
        Route::get('/raw/{id}/edit', [App\Http\Controllers\Dashboard\RawMaterialController::class, 'edit'])->name('raw.edit');
        Route::put('/raw/{id}', [App\Http\Controllers\Dashboard\RawMaterialController::class, 'update'])->name('raw.update');
        Route::post('/raw/{id}/adjust', [App\Http\Controllers\Dashboard\RawMaterialController::class, 'adjustStock'])->name('raw.adjust');
        Route::get('/raw/{id}/history', [App\Http\Controllers\Dashboard\RawMaterialController::class, 'history'])->name('raw.history');
    });

    // Tables & Areas
    Route::resource('dining-areas', App\Http\Controllers\Dashboard\DiningAreaController::class)->only(['store', 'update', 'destroy']);
    Route::resource('tables', App\Http\Controllers\Dashboard\TableController::class)->except(['create', 'edit', 'show']);
    Route::resource('units', App\Http\Controllers\UnitController::class)->except(['create', 'edit', 'show']);
    Route::resource('settings/charges', App\Http\Controllers\ChargeController::class)->names('charges')->except(['create', 'edit', 'show']);
    // Legacy Redirect for Taxes
    Route::redirect('settings/taxes', 'settings/charges');

    // Reports
    Route::get('/reports/sales', function () { return redirect()->route('under.development'); })->name('reports.sales');
    Route::get('/reports/top-products', function () { return redirect()->route('under.development'); })->name('reports.top-products');
    Route::get('/reports/staff-performance', function () { return redirect()->route('under.development'); })->name('reports.staff-performance');

    // Settings
    Route::get('/settings/pos', function () { return redirect()->route('under.development'); })->name('settings.pos');
    Route::get('/settings/printing', function () { return redirect()->route('under.development'); })->name('settings.printing');
    Route::get('/settings/notifications', function () { return redirect()->route('under.development'); })->name('settings.notifications');
});
