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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('dining_area_id')->constrained('dining_areas')->onDelete('cascade');
            $table->integer('capacity')->nullable();
            $table->boolean('is_active')->default(true); // Changed from status to is_active for consistency
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Assuming multi-tenant
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
