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
use App\Http\Controllers\Dashboard\InvoiceController;
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

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'super_admin'])->prefix('super')->group(function () {
    Route::resource('business-types', BusinessTypeController::class)->except(['show']);
    Route::get('business-settings', [BusinessSettingController::class, 'index'])->name('business_settings.index');
    Route::post('business-settings', [BusinessSettingController::class, 'update'])->name('business_settings.update');

    Route::get('admins/get-categories/{id}', [AdminController::class, 'getCategories'])->name('admins.categories');
    Route::resource('admins', AdminController::class);
    Route::patch('admins/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admins.toggleStatus');
    Route::post('admins/deactivate-all', [AdminController::class, 'deactivateAll'])->name('admins.deactivateAll');

    Route::resource('terms', TermsAndConditionsController::class)->except(['show']);
    Route::resource('packages', PackageController::class)->except(['show']);

    Route::resource('payment-methods', PaymentMethodController::class)->names('super.payment-methods')->except(['show']);

    Route::patch('payment-methods/{id}/toggle', [PaymentMethodController::class, 'toggle'])->name('super.payment-methods.toggle');

    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('subscriptions/{id}/update-status', [SubscriptionController::class, 'updateStatus'])->name('subscriptions.updateStatus');
    Route::delete('subscriptions/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');

    Route::resource('sections', SectionController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Admin / Owner Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', [ShowController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'active', 'CheckSubscription'])->group(function () {
    Route::get('/orders-count', function () {
        return response()->json([
            'count' => Order::count(),
        ]);
    })->middleware('package.permission:dashboard.access')->name('orders.count');



    // Invoices
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{order}/print', [InvoiceController::class, 'print'])->name('invoices.print');

    /*
    |--------------------------------------------------------------------------
    | E-Menu
    |--------------------------------------------------------------------------
    */
    Route::resource('categories', CategoryController::class)
        ->except(['create', 'edit'])
        ->middleware('package.permission:categories.access');

    Route::resource('products', ProductController::class)
        ->except(['create', 'edit'])
        ->middleware('package.permission:products.access');

    Route::resource('sliders', SliderController::class)
        ->except(['create', 'edit'])
        ->middleware('package.permission:sliders.access');

    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])
            ->middleware('package.permission:orders.all')
            ->name('index');

        Route::get('/delivery', [OrderController::class, 'delivery'])
            ->middleware('package.permission:orders.delivery')
            ->name('delivery');

        Route::get('/local', [OrderController::class, 'local'])
            ->middleware('package.permission:orders.local')
            ->name('local');

        Route::get('/pickup', [OrderController::class, 'pickup'])
            ->middleware('package.permission:orders.pickup')
            ->name('pickup');

        Route::get('/{order}', [OrderController::class, 'show'])
            ->middleware('package.permission:orders.all')
            ->whereNumber('order')
            ->name('show');

        Route::patch('/{order}/serve', [OrderController::class, 'serve'])
            ->middleware('package.permission:orders.all')
            ->whereNumber('order')
            ->name('serve');
    });

    Route::get('/orders/new', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:orders.access')->name('orders.new');

    Route::get('/orders/ongoing', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:orders.access')->name('orders.ongoing');

    Route::get('/orders/completed', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:orders.access')->name('orders.completed');

    Route::get('/orders/filter', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:orders.access')->name('orders.filter');

    /*
    |--------------------------------------------------------------------------
    | POS
    |--------------------------------------------------------------------------
    */
    Route::get('/pos', PosPage::class)
        ->middleware('package.permission:pos.access')
        ->name('pos.index');

    /*
    |--------------------------------------------------------------------------
    | Management
    |--------------------------------------------------------------------------
    */
    Route::resource('users', UserController::class)
        ->except(['show'])
        ->middleware('package.permission:users.access');

    Route::get('/users/staff', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:users.access')->name('users.staff');

    Route::get('/users/customers', [CustomerController::class, 'index'])
        ->middleware('package.permission:users.access')
        ->name('users.customers');

    Route::resource('roles', RoleController::class)
        ->middleware('package.permission:roles.access');

    Route::resource('branches', BranchController::class)
        ->middleware('package.permission:branches.access');

    Route::resource('attendances', AttendanceController::class)
        ->except(['show'])
        ->middleware('package.permission:attendances.access');

    Route::resource('shifts', ShiftController::class)
        ->except(['show'])
        ->middleware('package.permission:shifts.access');
        
    Route::get('shifts/{shift}', [ShiftController::class, 'show'])
    ->middleware('package.permission:shifts.access')
    ->name('shifts.show');

    Route::post('shifts/{shift}/close', [ShiftController::class, 'close'])
        ->middleware('package.permission:shifts.access')
        ->name('shifts.close');

    Route::post('/shifts/pause', function () {
        $activeShift = Shift::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($activeShift) {
            $activeShift->update(['status' => 'paused']);
        }

        return response()->json(['success' => true]);
    })->middleware('package.permission:shifts.access')->name('shifts.pause');

    /*
    |--------------------------------------------------------------------------
    | Inventory
    |--------------------------------------------------------------------------
    */
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryDashboardController::class, 'index'])
            ->middleware('package.permission:inventory.dashboard')
            ->name('dashboard');

        Route::get('/reconcile', StockReconciliation::class)
            ->middleware('package.permission:inventory.stock_counts')
            ->name('reconcile');

        Route::resource('suppliers', SupplierController::class)
            ->middleware('package.permission:inventory.suppliers');

        Route::post('suppliers/{supplier}/materials', [SupplierController::class, 'attachMaterial'])
            ->middleware('package.permission:inventory.suppliers')
            ->name('suppliers.materials.attach');

        Route::put('suppliers/{supplier}/materials/{pivotId}', [SupplierController::class, 'updateAttachedMaterial'])
            ->middleware('package.permission:inventory.suppliers')
            ->name('suppliers.materials.update');

        Route::delete('suppliers/{supplier}/materials/{pivotId}', [SupplierController::class, 'detachMaterial'])
            ->middleware('package.permission:inventory.suppliers')
            ->name('suppliers.materials.detach');

        Route::resource('materials', RawMaterialController::class)
            ->except(['show'])
            ->middleware('package.permission:inventory.materials');

        Route::resource('categories', InventoryCategoryController::class)
            ->except(['create', 'edit', 'show'])
            ->middleware('package.permission:inventory.categories');

        Route::resource('purchase-requests', PurchaseRequestController::class)
            ->middleware('package.permission:inventory.purchase_requests');

        Route::post('purchase-requests/{purchase_request}/approve', [PurchaseRequestController::class, 'approve'])
            ->middleware('package.permission:inventory.purchase_requests')
            ->name('purchase-requests.approve');

        Route::resource('purchase-orders', PurchaseOrderController::class)
            ->middleware('package.permission:inventory.purchase_orders');

        Route::post('purchase-orders/{purchase_order}/approve', [PurchaseOrderController::class, 'approve'])
            ->middleware('package.permission:inventory.purchase_orders')
            ->name('purchase-orders.approve');

        Route::resource('receipts', GoodsReceiptController::class)
            ->middleware('package.permission:inventory.receipts');

        Route::post('receipts/{receipt}/post', [GoodsReceiptController::class, 'post'])
            ->middleware('package.permission:inventory.receipts')
            ->name('receipts.post');

        Route::resource('transfer-requests', TransferRequestController::class)
            ->middleware('package.permission:inventory.transfer_requests');

        Route::post('transfer-requests/{transfer_request}/approve', [TransferRequestController::class, 'approve'])
            ->middleware('package.permission:inventory.transfer_requests')
            ->name('transfer-requests.approve');

        Route::post('transfer-requests/{transfer_request}/receive', [TransferRequestController::class, 'receive'])
            ->middleware('package.permission:inventory.transfer_requests')
            ->name('transfer-requests.receive');

        Route::resource('stock-counts', StockCountController::class)
            ->middleware('package.permission:inventory.stock_counts');

        Route::post('stock-counts/{stock_count}/approve', [StockCountController::class, 'approve'])
            ->middleware('package.permission:inventory.stock_counts')
            ->name('stock-counts.approve');

        Route::resource('production-orders', ProductionOrderController::class)
            ->middleware('package.permission:inventory.production_orders');

        Route::post('production-orders/{production_order}/produce', [ProductionOrderController::class, 'produce'])
            ->middleware('package.permission:inventory.production_orders')
            ->name('production-orders.produce');

        Route::get('movements', [InventoryMovementController::class, 'index'])
            ->middleware('package.permission:inventory.movements')
            ->name('movements.index');

        Route::get('/ready', [ReadyItemController::class, 'index'])
            ->middleware('package.permission:inventory.materials')
            ->name('ready.index');

        Route::get('/ready/create', [ReadyItemController::class, 'create'])
            ->middleware('package.permission:inventory.materials')
            ->name('ready.create');

        Route::post('/ready', [ReadyItemController::class, 'store'])
            ->middleware('package.permission:inventory.materials')
            ->name('ready.store');

        Route::get('/ready/{id}/edit', [ReadyItemController::class, 'edit'])
            ->middleware('package.permission:inventory.materials')
            ->name('ready.edit');

        Route::put('/ready/{id}', [ReadyItemController::class, 'update'])
            ->middleware('package.permission:inventory.materials')
            ->name('ready.update');

        Route::put('/ready/{id}/convert', [ReadyItemController::class, 'convertToComposite'])
            ->middleware('package.permission:inventory.materials')
            ->name('ready.convert');

        Route::post('/ready/{id}/adjust', [ReadyItemController::class, 'adjustStock'])
            ->middleware('package.permission:inventory.materials')
            ->name('ready.adjust');

        Route::get('/ready/{id}/history', [ReadyItemController::class, 'history'])
            ->middleware('package.permission:inventory.materials')
            ->name('ready.history');

        Route::get('/composite', [CompositeItemController::class, 'index'])
            ->middleware('package.permission:inventory.production_orders')
            ->name('composite.index');

        Route::get('/composite/create', [CompositeItemController::class, 'create'])
            ->middleware('package.permission:inventory.production_orders')
            ->name('composite.create');

        Route::post('/composite', [CompositeItemController::class, 'store'])
            ->middleware('package.permission:inventory.production_orders')
            ->name('composite.store');

        Route::get('/composite/{id}/edit', [CompositeItemController::class, 'edit'])
            ->middleware('package.permission:inventory.production_orders')
            ->name('composite.edit');

        Route::put('/composite/{id}', [CompositeItemController::class, 'update'])
            ->middleware('package.permission:inventory.production_orders')
            ->name('composite.update');

        Route::get('/composite/{id}/recipe', [CompositeItemController::class, 'editRecipe'])
            ->middleware('package.permission:inventory.production_orders')
            ->name('composite.recipe.edit');

        Route::post('/composite/{id}/recipe', [CompositeItemController::class, 'addIngredient'])
            ->middleware('package.permission:inventory.production_orders')
            ->name('composite.recipe.add');

        Route::delete('/composite/recipe/{recipe_id}', [CompositeItemController::class, 'removeIngredient'])
            ->middleware('package.permission:inventory.production_orders')
            ->name('composite.recipe.remove');
    });

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */
    Route::get('settings', [SettingController::class, 'index'])
        ->middleware('package.permission:settings.general')
        ->name('settings.index');

    Route::put('settings/{setting}', [SettingController::class, 'update'])
        ->middleware('package.permission:settings.general')
        ->name('settings.update');

    Route::resource('payment-methods', PaymentMethodController::class)
        ->middleware('package.permission:payment_methods.access');

    Route::resource('tables', TableController::class)
        ->except(['create', 'edit', 'show'])
        ->middleware('package.permission:tables_areas.access');

    Route::resource('dining-areas', DiningAreaController::class)
        ->only(['store', 'update', 'destroy'])
        ->middleware('package.permission:tables_areas.access');

    Route::resource('units', UnitController::class)
        ->except(['create', 'edit', 'show'])
        ->middleware('package.permission:units.access');

    Route::resource('settings/charges', ChargeController::class)
        ->names('charges')
        ->except(['create', 'edit', 'show'])
        ->middleware('package.permission:charges.access');

    Route::redirect('settings/taxes', 'settings/charges');

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */
    Route::get('/reports/sales', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:reports.sales')->name('reports.sales');

    Route::get('/reports/top-products', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:reports.top_products')->name('reports.top-products');

    Route::get('/reports/staff-performance', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:reports.staff_performance')->name('reports.staff-performance');

    /*
    |--------------------------------------------------------------------------
    | Extras / Legacy
    |--------------------------------------------------------------------------
    */
    Route::resource('delivery_men', DeliveryManController::class)
        ->except(['show'])
        ->middleware('package.permission:orders.delivery');

    Route::resource('purchases', PurchaseInvoiceController::class)
        ->except(['edit', 'update'])
        ->middleware('package.permission:inventory.purchase_orders');

    Route::get('/impersonate/leave', [ImpersonationController::class, 'leave'])
        ->middleware('package.permission:users.access')
        ->name('impersonate.leave');

    Route::get('/impersonate/{id}', [ImpersonationController::class, 'impersonate'])
        ->middleware('package.permission:users.access')
        ->name('impersonate');

    Route::get('/under-development', function () {
        return view('under-development');
    })->name('under.development');

    Route::get('/products/addons', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:products.access')->name('products.addons');

    Route::get('/products/active', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:products.access')->name('products.active');

    Route::get('/settings/pos', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:pos.access')->name('settings.pos');

    Route::get('/settings/printing', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:settings.general')->name('settings.printing');

    Route::get('/settings/notifications', function () {
        return redirect()->route('under.development');
    })->middleware('package.permission:settings.general')->name('settings.notifications');
});
