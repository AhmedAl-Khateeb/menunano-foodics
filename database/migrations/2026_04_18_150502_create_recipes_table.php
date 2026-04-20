<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // الصنف الناتج من الوصفة
            $table->foreignId('output_raw_material_id')->constrained('raw_materials')->cascadeOnDelete();

            $table->string('name');

            // الكمية الناتجة القياسية من هذه الوصفة
            $table->decimal('yield_quantity', 14, 3)->default(1);

            // وحدة الناتج
            $table->foreignId('yield_unit_id')->nullable()->constrained('units')->nullOnDelete();

            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // كل صنف نهائي له وصفة واحدة
            $table->unique(['user_id', 'output_raw_material_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};