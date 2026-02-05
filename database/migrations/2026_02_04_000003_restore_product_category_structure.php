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
        // 1. Restore category_id if it doesn't exist
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('id')->constrained('categories')->onDelete('cascade');
            }
        });

        // 2. Data Migration: Copy from pivot table to category_id
        if (Schema::hasTable('category_product')) {
            $relations = DB::table('category_product')->get();
            foreach ($relations as $relation) {
                // Update product with the first category found (since we are reverting to one-to-many)
                DB::table('products')
                    ->where('id', $relation->product_id)
                    ->whereNull('category_id') // Only update if empty
                    ->update(['category_id' => $relation->category_id]);
            }
        }
        
        // 3. Drop pivot table
        Schema::dropIfExists('category_product');

        // 4. Drop 'type' column if exists (cleanup)
        if (Schema::hasColumn('products', 'type')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-create pivot table
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        
        // We don't drop category_id here to be safe, or we could if we wanted strict rollback logic.
    }
};
