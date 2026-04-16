<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Dashboard
            ['name' => 'dashboard_read', 'group' => 'Dashboard', 'user_role' => 'admin'],

            // Categories
            ['name' => 'category_create', 'group' => 'Categories', 'user_role' => 'admin'],
            ['name' => 'category_read', 'group' => 'Categories', 'user_role' => 'admin'],
            ['name' => 'category_update', 'group' => 'Categories', 'user_role' => 'admin'],
            ['name' => 'category_delete', 'group' => 'Categories', 'user_role' => 'admin'],

            // Products
            ['name' => 'product_create', 'group' => 'Products', 'user_role' => 'admin'],
            ['name' => 'product_read', 'group' => 'Products', 'user_role' => 'admin'],
            ['name' => 'product_update', 'group' => 'Products', 'user_role' => 'admin'],
            ['name' => 'product_delete', 'group' => 'Products', 'user_role' => 'admin'],

            // Orders
            ['name' => 'order_create', 'group' => 'Orders', 'user_role' => 'admin'],
            ['name' => 'order_read', 'group' => 'Orders', 'user_role' => 'admin'],
            ['name' => 'order_update', 'group' => 'Orders', 'user_role' => 'admin'],
            ['name' => 'order_delete', 'group' => 'Orders', 'user_role' => 'admin'],

            // Users
            ['name' => 'user_create', 'group' => 'Users', 'user_role' => 'admin'],
            ['name' => 'user_read', 'group' => 'Users', 'user_role' => 'admin'],
            ['name' => 'user_update', 'group' => 'Users', 'user_role' => 'admin'],
            ['name' => 'user_delete', 'group' => 'Users', 'user_role' => 'admin'],

            // Roles
            ['name' => 'role_create', 'group' => 'Roles', 'user_role' => 'admin'],
            ['name' => 'role_read', 'group' => 'Roles', 'user_role' => 'admin'],
            ['name' => 'role_update', 'group' => 'Roles', 'user_role' => 'admin'],
            ['name' => 'role_delete', 'group' => 'Roles', 'user_role' => 'admin'],

            // Settings
            ['name' => 'settings_read', 'group' => 'Settings', 'user_role' => 'admin'],
            ['name' => 'settings_update', 'group' => 'Settings', 'user_role' => 'admin'],

            // Sliders
            ['name' => 'slider_create', 'group' => 'Sliders', 'user_role' => 'admin'],
            ['name' => 'slider_read', 'group' => 'Sliders', 'user_role' => 'admin'],
            ['name' => 'slider_update', 'group' => 'Sliders', 'user_role' => 'admin'],
            ['name' => 'slider_delete', 'group' => 'Sliders', 'user_role' => 'admin'],

            // Super Admin Modules
            // Admins
            ['name' => 'admin_create', 'group' => 'Admins', 'user_role' => 'super_admin'],
            ['name' => 'admin_read', 'group' => 'Admins', 'user_role' => 'super_admin'],
            ['name' => 'admin_update', 'group' => 'Admins', 'user_role' => 'super_admin'],
            ['name' => 'admin_delete', 'group' => 'Admins', 'user_role' => 'super_admin'],

            // Business Settings
            ['name' => 'business_settings_read', 'group' => 'Business Settings', 'user_role' => 'super_admin'],
            ['name' => 'business_settings_update', 'group' => 'Business Settings', 'user_role' => 'super_admin'],

            // Packages
            ['name' => 'package_create', 'group' => 'Packages', 'user_role' => 'super_admin'],
            ['name' => 'package_read', 'group' => 'Packages', 'user_role' => 'super_admin'],
            ['name' => 'package_update', 'group' => 'Packages', 'user_role' => 'super_admin'],
            ['name' => 'package_delete', 'group' => 'Packages', 'user_role' => 'super_admin'],

            // Payment Methods
            ['name' => 'payment_method_create', 'group' => 'Payment Methods', 'user_role' => 'super_admin'],
            ['name' => 'payment_method_read', 'group' => 'Payment Methods', 'user_role' => 'super_admin'],
            ['name' => 'payment_method_update', 'group' => 'Payment Methods', 'user_role' => 'super_admin'],
            ['name' => 'payment_method_delete', 'group' => 'Payment Methods', 'user_role' => 'super_admin'],

            // Sections
            ['name' => 'section_create', 'group' => 'Sections', 'user_role' => 'super_admin'],
            ['name' => 'section_read', 'group' => 'Sections', 'user_role' => 'super_admin'],
            ['name' => 'section_update', 'group' => 'Sections', 'user_role' => 'super_admin'],
            ['name' => 'section_delete', 'group' => 'Sections', 'user_role' => 'super_admin'],

            // Subscriptions
            ['name' => 'subscription_read', 'group' => 'Subscriptions', 'user_role' => 'super_admin'],
            ['name' => 'subscription_update', 'group' => 'Subscriptions', 'user_role' => 'super_admin'],
            ['name' => 'subscription_delete', 'group' => 'Subscriptions', 'user_role' => 'super_admin'],

            // Terms
            ['name' => 'term_create', 'group' => 'Terms', 'user_role' => 'super_admin'],
            ['name' => 'term_read', 'group' => 'Terms', 'user_role' => 'super_admin'],
            ['name' => 'term_update', 'group' => 'Terms', 'user_role' => 'super_admin'],
            ['name' => 'term_delete', 'group' => 'Terms', 'user_role' => 'super_admin'],

            // Branches
            ['name' => 'branch_create', 'group' => 'Branches', 'user_role' => 'admin'],
            ['name' => 'branch_read', 'group' => 'Branches', 'user_role' => 'admin'],
            ['name' => 'branch_update', 'group' => 'Branches', 'user_role' => 'admin'],
            ['name' => 'branch_delete', 'group' => 'Branches', 'user_role' => 'admin'],
        ];

        // Truncate table to avoid duplicates (optional, use with caution in production)
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('permissions')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Better approach: Sync or Create
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'group' => $permission['group'],
                    'user_role' => $permission['user_role'], // Spatie models might not cast array automatically if not configured, better cast manually or ensure Model casts it
                ]
            );
        }
    }
}
