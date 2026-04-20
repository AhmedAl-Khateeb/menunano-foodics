<?php

use App\Http\Controllers\ChargeController;
use App\Http\Controllers\Dashboard\AttendanceController;
use App\Http\Controllers\Dashboard\BranchController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CompositeItemController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\DiningAreaController;
use App\Http\Controllers\Dashboard\GoodsReceiptController;
use App\Http\Controllers\Dashboard\InventoryCategoryController;
use App\Http\Controllers\Dashboard\InventoryDashboardController;
use App\Http\Controllers\Dashboard\InventoryMovementController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProductionOrderController;
use App\Http\Controllers\Dashboard\PurchaseOrderController;
use App\Http\Controllers\Dashboard\PurchaseRequestController;
use App\Http\Controllers\Dashboard\RawMaterialController;
use App\Http\Controllers\Dashboard\ReadyItemController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\ShiftController;
use App\Http\Controllers\Dashboard\ShowController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\StockCountController;
use App\Http\Controllers\Dashboard\SuperAdmin\AdminController;
use App\Http\Controllers\Dashboard\SuperAdmin\BusinessSettingController;
use App\Http\Controllers\Dashboard\SuperAdmin\BusinessTypeController;
use App\Http\Controllers\Dashboard\SuperAdmin\PackageController;
use App\Http\Controllers\Dashboard\SuperAdmin\PaymentMethodController;
use App\Http\Controllers\Dashboard\SuperAdmin\SectionController;
use App\Http\Controllers\Dashboard\SuperAdmin\SubscriptionController;
use App\Http\Controllers\Dashboard\SuperAdmin\TermsAndConditionsController;
use App\Http\Controllers\Dashboard\TableController;
use App\Http\Controllers\Dashboard\TransferRequestController;
use App\Http\Controllers\DeliveryManController;
use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\UserController;
use App\Livewire\PosPage;
use App\Livewire\StockReconciliation;
use App\Models\Order;
use App\Models\Shift;
use Illuminate\Support\Facades\Artisan;
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

    Route::get('admins/get-categories/{id}', [AdminController::class, 'getCategories'])->name('admins.categories');
    Route::resource('admins', AdminController::class);
    Route::patch('admins/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admins.toggleStatus');
    Route::post('admins/deactivate-all', [AdminController::class, 'deactivateAll'])->name('admins.deactivateAll');

    Route::resource('terms', TermsAndConditionsController::class)->except(['show']);
    Route::resource('packages', PackageController::class)->except(['show']);

    Route::resource('payment-methods', PaymentMethodController::class)
        ->names('super.payment-methods')
        ->except(['show']);
    Route::patch('payment-methods/{id}/toggle', [PaymentMethodController::class, 'toggle'])
        ->name('super.payment-methods.toggle');

    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('subscriptions/{id}/update-status', [SubscriptionController::class, 'updateStatus'])->name('subscriptions.updateStatus');
    Route::delete('subscriptions/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');

    Route::resource('sections', SectionController::class)->except(['show']);
});

Route::middleware(['auth', 'active', 'CheckSubscription'])->group(function () {
    Route::get('/dashboard', [ShowController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
    Route::resource('products', ProductController::class)->except(['create', 'edit']);
    Route::resource('sliders', SliderController::class)->except(['create', 'edit']);

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings/{setting}', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/orders-count', function () {
        return response()->json([
            'count' => Order::count(),
        ]);
    })->name('orders.count');

    Route::resource('attendances', AttendanceController::class)->except(['show']);
    Route::resource('shifts', ShiftController::class)->except(['show']);
    Route::post('shifts/{shift}/close', [ShiftController::class, 'close'])->name('shifts.close');

    Route::get('/users/staff', function () {
        return redirect()->route('under.development');
    })->name('users.staff');

    Route::get('/users/customers', [CustomerController::class, 'index'])
        ->name('users.customers');

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/reconcile', StockReconciliation::class)->name('reconcile');

        Route::resource('suppliers', SupplierController::class);
        Route::post('suppliers/{supplier}/materials', [SupplierController::class, 'attachMaterial'])
            ->name('suppliers.materials.attach');
        Route::put('suppliers/{supplier}/materials/{pivotId}', [SupplierController::class, 'updateAttachedMaterial'])
            ->name('suppliers.materials.update');
        Route::delete('suppliers/{supplier}/materials/{pivotId}', [SupplierController::class, 'detachMaterial'])
            ->name('suppliers.materials.detach');

        Route::resource('materials', RawMaterialController::class)
            ->except(['show']);

        Route::resource('categories', InventoryCategoryController::class)
            ->except(['create', 'edit', 'show']);

        Route::resource('purchase-requests', PurchaseRequestController::class);
        Route::post('purchase-requests/{purchase_request}/approve', [PurchaseRequestController::class, 'approve'])
            ->name('purchase-requests.approve');

        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::post('purchase-orders/{purchase_order}/approve', [PurchaseOrderController::class, 'approve'])
            ->name('purchase-orders.approve');

        Route::resource('receipts', GoodsReceiptController::class);
        Route::post('receipts/{receipt}/post', [GoodsReceiptController::class, 'post'])
            ->name('receipts.post');

        Route::resource('transfer-requests', TransferRequestController::class);
        Route::post('transfer-requests/{transfer_request}/approve', [TransferRequestController::class, 'approve'])
            ->name('transfer-requests.approve');
        Route::post('transfer-requests/{transfer_request}/receive', [TransferRequestController::class, 'receive'])
            ->name('transfer-requests.receive');

        Route::resource('stock-counts', StockCountController::class);
        Route::post('stock-counts/{stock_count}/approve', [StockCountController::class, 'approve'])
            ->name('stock-counts.approve');

        Route::resource('production-orders', ProductionOrderController::class);
        Route::post('production-orders/{production_order}/produce', [ProductionOrderController::class, 'produce'])
            ->name('production-orders.produce');

        Route::get('movements', [InventoryMovementController::class, 'index'])
            ->name('movements.index');

        Route::get('/ready', [ReadyItemController::class, 'index'])->name('ready.index');
        Route::get('/ready/create', [ReadyItemController::class, 'create'])->name('ready.create');
        Route::post('/ready', [ReadyItemController::class, 'store'])->name('ready.store');
        Route::get('/ready/{id}/edit', [ReadyItemController::class, 'edit'])->name('ready.edit');
        Route::put('/ready/{id}', [ReadyItemController::class, 'update'])->name('ready.update');
        Route::put('/ready/{id}/convert', [ReadyItemController::class, 'convertToComposite'])->name('ready.convert');
        Route::post('/ready/{id}/adjust', [ReadyItemController::class, 'adjustStock'])->name('ready.adjust');
        Route::get('/ready/{id}/history', [ReadyItemController::class, 'history'])->name('ready.history');

        Route::get('/composite', [CompositeItemController::class, 'index'])->name('composite.index');
        Route::get('/composite/create', [CompositeItemController::class, 'create'])->name('composite.create');
        Route::post('/composite', [CompositeItemController::class, 'store'])->name('composite.store');
        Route::get('/composite/{id}/edit', [CompositeItemController::class, 'edit'])->name('composite.edit');
        Route::put('/composite/{id}', [CompositeItemController::class, 'update'])->name('composite.update');
        Route::get('/composite/{id}/recipe', [CompositeItemController::class, 'editRecipe'])->name('composite.recipe.edit');
        Route::post('/composite/{id}/recipe', [CompositeItemController::class, 'addIngredient'])->name('composite.recipe.add');
        Route::delete('/composite/recipe/{recipe_id}', [CompositeItemController::class, 'removeIngredient'])->name('composite.recipe.remove');
    });

    Route::resource('business-types', BusinessTypeController::class)->except(['show']);
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('roles', RoleController::class);
    Route::resource('branches', BranchController::class);

    Route::resource('payment-methods', PaymentMethodController::class);

    Route::resource('delivery_men', DeliveryManController::class)->except(['show']);
    Route::resource('purchases', PurchaseInvoiceController::class)->except(['edit', 'update']);

    Route::get('/impersonate/leave', [ImpersonationController::class, 'leave'])->name('impersonate.leave');
    Route::get('/impersonate/{id}', [ImpersonationController::class, 'impersonate'])->name('impersonate');

    Route::get('/pos', PosPage::class)->name('pos.index');

    Route::get('/under-development', function () {
        return view('under-development');
    })->name('under.development');

    Route::post('/shifts/pause', function () {
        $activeShift = Shift::where('user_id', auth()->id())
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
        Route::get('/{order}', [OrderController::class, 'show'])->whereNumber('order')->name('show');
        Route::patch('/{order}/serve', [OrderController::class, 'serve'])->whereNumber('order')->name('serve');
    });

    Route::get('/orders/new', function () {
        return redirect()->route('under.development');
    })->name('orders.new');

    Route::get('/orders/ongoing', function () {
        return redirect()->route('under.development');
    })->name('orders.ongoing');

    Route::get('/orders/completed', function () {
        return redirect()->route('under.development');
    })->name('orders.completed');

    Route::get('/orders/filter', function () {
        return redirect()->route('under.development');
    })->name('orders.filter');

    Route::get('/products/addons', function () {
        return redirect()->route('under.development');
    })->name('products.addons');

    Route::get('/products/active', function () {
        return redirect()->route('under.development');
    })->name('products.active');

    Route::resource('dining-areas', DiningAreaController::class)
        ->only(['store', 'update', 'destroy']);

    Route::resource('tables', TableController::class)
        ->except(['create', 'edit', 'show']);

    Route::resource('units', UnitController::class)
        ->except(['create', 'edit', 'show']);

    Route::resource('settings/charges', ChargeController::class)
        ->names('charges')
        ->except(['create', 'edit', 'show']);

    Route::redirect('settings/taxes', 'settings/charges');

    Route::get('/reports/sales', function () {
        return redirect()->route('under.development');
    })->name('reports.sales');

    Route::get('/reports/top-products', function () {
        return redirect()->route('under.development');
    })->name('reports.top-products');

    Route::get('/reports/staff-performance', function () {
        return redirect()->route('under.development');
    })->name('reports.staff-performance');

    Route::get('/settings/pos', function () {
        return redirect()->route('under.development');
    })->name('settings.pos');

    Route::get('/settings/printing', function () {
        return redirect()->route('under.development');
    })->name('settings.printing');

    Route::get('/settings/notifications', function () {
        return redirect()->route('under.development');
    })->name('settings.notifications');
});
