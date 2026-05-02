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
        Schema::create('branch_users', function (Blueprint $table) {
            $table->id();

            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('role')->default('manager');
            // owner, main_manager, manager, cashier, staff

            $table->boolean('is_primary_manager')->default(false);
            $table->boolean('can_manage_permissions')->default(false);

            $table->json('permissions')->nullable();

            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->unique(['branch_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_users');
    }
};
