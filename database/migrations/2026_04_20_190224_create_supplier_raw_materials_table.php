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
        Schema::create('supplier_raw_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('raw_material_id')->constrained()->cascadeOnDelete();

            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('supplier_item_code')->nullable(); // كود الوحدة/الصنف عند المورد
            $table->decimal('order_quantity', 12, 3)->default(1); // كمية الطلب
            $table->decimal('conversion_factor', 12, 3)->default(1); // معامل التحويل
            $table->decimal('purchase_cost', 12, 3)->default(0); // تكلفة الشراء
            $table->boolean('is_preferred')->default(false); // المورد الأساسي؟
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['supplier_id', 'raw_material_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_raw_materials');
    }
};
