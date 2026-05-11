<?php

namespace Database\Seeders;

use App\Models\BusinessType;
use App\Models\BusinessTypePermissionDefault;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessTypePermissionDefaultsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // مطعم
            'rest' => [
                'dashboard.access',

                'emenu.access',
                'categories.access',
                'products.access',
                'sliders.access',

                'orders.access',
                'orders.all',
                'orders.delivery',
                'orders.pickup',
                'orders.local',

                'pos.access',

                'management.access',
                'users.access',
                'roles.access',
                'branches.access',
                'branch_creation_request.access',
                'branch_links.access',
                'shifts.access',
                'attendances.access',
                'cashier-cash-reports.access',

                'inventory.access',
                'inventory.dashboard',
                'inventory.suppliers',
                'inventory.categories',
                'units.access',
                'inventory.materials',
                'inventory.purchase_requests',
                'inventory.purchase_orders',
                'inventory.receipts',
                'inventory.production_orders',
                'inventory.transfer_requests',
                'inventory.stock_counts',
                'inventory.movements',

                'reports.access',
                'reports.sales',
                'reports.top_products',
                'reports.staff_performance',

                'settings.access',
                'settings.general',
                'payment_methods.access',
                'tables_areas.access',
                'charges.access',

                'barcodes.access',
            ],

            // محل
            'acc' => [
                'dashboard.access',

                'categories.access',
                'products.access',

                'orders.access',
                'orders.all',

                'pos.access',

                'management.access',
                'users.access',
                'roles.access',
                'branches.access',
                'shifts.access',
                'attendances.access',
                'cashier-cash-reports.access',

                'inventory.access',
                'inventory.dashboard',
                'inventory.suppliers',
                'inventory.categories',
                'units.access',
                'inventory.materials',
                'inventory.purchase_requests',
                'inventory.purchase_orders',
                'inventory.receipts',
                'inventory.stock_counts',
                'inventory.movements',

                'reports.access',
                'reports.sales',
                'reports.top_products',
                'reports.staff_performance',

                'settings.access',
                'settings.general',
                'payment_methods.access',
                'barcodes.access',
            ],

            // منيو إلكتروني فقط
            'menu' => [
                'dashboard.access',

                'emenu.access',
                'categories.access',
                'products.access',
                'sliders.access',

                'orders.access',
                'orders.all',
                'orders.delivery',
                'orders.pickup',

                'settings.access',
                'settings.general',
                'barcodes.access',
            ],
        ];

        $businessTypeNames = [
            'rest' => 'مطعم',
            'acc' => 'محل',
            'menu' => 'منيو إلكتروني',
        ];

        $validPermissionKeys = collect(config('package_permissions'))
            ->pluck('key')
            ->toArray();

        DB::transaction(function () use ($defaults, $businessTypeNames, $validPermissionKeys) {
            foreach ($defaults as $slug => $permissions) {
                $businessType = BusinessType::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => $businessTypeNames[$slug] ?? $slug,
                        'is_active' => true,
                    ]
                );

                BusinessTypePermissionDefault::where('business_type_id', $businessType->id)
                    ->delete();

                foreach ($permissions as $permissionKey) {
                    if (!in_array($permissionKey, $validPermissionKeys, true)) {
                        continue;
                    }

                    BusinessTypePermissionDefault::create([
                        'business_type_id' => $businessType->id,
                        'permission_key' => $permissionKey,
                        'is_active' => true,
                    ]);
                }
            }
        });
    }
}
