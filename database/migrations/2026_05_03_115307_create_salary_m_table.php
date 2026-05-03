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
        Schema::create('salary_m', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->decimal('penalties', 10, 2)->nullable()->default(0);
            $table->decimal('Salary_advance', 10, 2)->nullable()->default(0);
            $table->decimal('Rewards', 10, 2)->nullable()->default(0);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_m');
    }
};