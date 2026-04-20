<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('production_orders', function (Blueprint $table) {
            $table->id();
              $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipe_id')->constrained()->restrictOnDelete();

            $table->string('production_number')->unique();
            $table->date('production_date');
            $table->decimal('planned_quantity', 14, 3)->default(0);
            $table->decimal('produced_quantity', 14, 3)->default(0);
            $table->enum('status', ['draft', 'approved', 'produced', 'cancelled'])->default('draft');
            $table->decimal('total_cost', 14, 3)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_orders');
    }
};
