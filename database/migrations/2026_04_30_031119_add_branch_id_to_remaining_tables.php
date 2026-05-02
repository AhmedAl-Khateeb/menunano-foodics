<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private function addBranchId(string $tableName): void
    {
        if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'branch_id')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            });
        }
    }

    private function dropBranchId(string $tableName): void
    {
        if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'branch_id')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropConstrainedForeignId('branch_id');
            });
        }
    }

    public function up(): void
    {
        // التشغيل والمبيعات
        $this->addBranchId('orders');
        $this->addBranchId('cart_items');
        $this->addBranchId('shifts');
        $this->addBranchId('attendances');

        // الكاشير والعهدة
        $this->addBranchId('shift_expenses');
        $this->addBranchId('cash_transfers');

        // الصالة والطاولات
        $this->addBranchId('dining_areas');
        $this->addBranchId('tables');
        $this->addBranchId('delivery_men');

        // المخزون
        $this->addBranchId('inventories');
        $this->addBranchId('inventory_movements');

        // المشتريات والاستلام
        $this->addBranchId('purchase_requests');
        $this->addBranchId('purchase_orders');
        $this->addBranchId('purchase_invoices');
        $this->addBranchId('goods_receipts');

        // التحويلات والجرد والإنتاج
        $this->addBranchId('transfer_requests');
        $this->addBranchId('stock_counts');
        $this->addBranchId('production_orders');
    }

    public function down(): void
    {
        $tables = [
            'orders',
            'cart_items',
            'shifts',
            'attendances',

            'shift_expenses',
            'cash_transfers',

            'dining_areas',
            'tables',
            'delivery_men',

            'inventories',
            'inventory_movements',

            'purchase_requests',
            'purchase_orders',
            'purchase_invoices',
            'goods_receipts',

            'transfer_requests',
            'stock_counts',
            'production_orders',
        ];

        foreach ($tables as $tableName) {
            $this->dropBranchId($tableName);
        }
    }
};
