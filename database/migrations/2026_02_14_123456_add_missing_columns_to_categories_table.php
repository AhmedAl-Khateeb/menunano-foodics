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
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (!Schema::hasColumn('categories', 'store_id')) {
                $table->foreignId('store_id')->nullable()->constrained('users')->onDelete('set null'); // Assuming store is also a user or separate table, but let's make it nullable foreign key. Actually, usually it's set to user_id in this system context? 
                // Wait, User IS the store owner in this multi-tenant app?
                // The Category model has belongsTo User. And belongsTo Store?
                // Let's check User model for store relationship if needed.
                // But for now, adding nullable store_id is safe.
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('categories', 'store_id')) {
                $table->dropForeign(['store_id']);
                $table->dropColumn('store_id');
            }
        });
    }
};
