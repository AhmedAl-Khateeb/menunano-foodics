<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'type')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('type')->default('ready')->after('id'); // ready, manufactured, component
            });
        }

        // Migrate existing data to pivot table
        $products = DB::table('products')->whereNotNull('category_id')->get(['id', 'category_id']);
        foreach ($products as $product) {
            DB::table('category_product')->insertOrIgnore([
                'category_id' => $product->category_id,
                'product_id' => $product->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_id')) {
                // Attempt to find and drop the foreign key dynamically
                $dbName = DB::getDatabaseName();
                $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'products' AND COLUMN_NAME = 'category_id' AND REFERENCED_TABLE_NAME IS NOT NULL", [$dbName]);
                
                foreach ($foreignKeys as $fk) {
                    $table->dropForeign($fk->CONSTRAINT_NAME);
                }

                $table->dropColumn('category_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('id')->constrained('categories')->onDelete('cascade');
            }
        });

        // Restore category_id from pivot table
        $relations = DB::table('category_product')->get();
        foreach ($relations as $relation) {
            DB::table('products')
                ->where('id', $relation->product_id)
                ->update(['category_id' => $relation->category_id]);
        }

        Schema::table('products', function (Blueprint $table) {
             if (Schema::hasColumn('products', 'type')) {
                $table->dropColumn('type');
             }
        });
    }
};
