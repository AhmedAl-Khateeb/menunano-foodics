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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('symbol', 10);
            $table->enum('type', ['count', 'weight', 'volume'])->default('count');
            $table->boolean('allow_decimal')->default(false);
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('base_unit_id')->nullable()->constrained('units')->onDelete('cascade');
            $table->decimal('conversion_rate', 10, 4)->nullable()->comment('Rate relative to base unit');
            $table->timestamps();

            // Unique name per user
            $table->unique(['user_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
