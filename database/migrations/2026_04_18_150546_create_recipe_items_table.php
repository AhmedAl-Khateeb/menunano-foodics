<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recipe_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();

            // الخامة الداخلة في التصنيع
            $table->foreignId('raw_material_id')->constrained('raw_materials')->cascadeOnDelete();

            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();

            // كمية الخامة المستخدمة
            $table->decimal('quantity', 14, 3);

            // نسبة هالك اختيارية
            $table->decimal('waste_percent', 8, 2)->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();

            // منع تكرار نفس الخامة داخل نفس الوصفة
            $table->unique(['recipe_id', 'raw_material_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipe_items');
    }
};
