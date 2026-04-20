<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_category_id')->nullable()->constrained('inventory_categories')->nullOnDelete();
            $table->foreignId('default_supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->foreignId('purchase_unit_id')->nullable()->constrained('units')->nullOnDelete();

            $table->string('name');
            $table->string('sku')->nullable()->index();
            $table->string('barcode')->nullable();
            $table->text('description')->nullable();

            $table->decimal('purchase_price', 14, 3)->default(0);
            $table->decimal('avg_cost', 14, 3)->default(0);
            $table->decimal('last_cost', 14, 3)->default(0);

            $table->decimal('reorder_level', 14, 3)->nullable();
            $table->decimal('min_quantity', 14, 3)->nullable();
            $table->decimal('max_quantity', 14, 3)->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};
