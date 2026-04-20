<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            ALTER TABLE inventory_movements 
            MODIFY COLUMN type ENUM(
                'purchase',
                'sale',
                'waste',
                'adjustment',
                'transfer_out',
                'transfer_in',
                'production_in',
                'production_out'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE inventory_movements 
            MODIFY COLUMN type ENUM(
                'purchase',
                'sale',
                'waste',
                'adjustment'
            ) NOT NULL
        ");
    }
};
