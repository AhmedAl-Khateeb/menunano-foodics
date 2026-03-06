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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('type', ['takeaway', 'table', 'free_seating', 'delivery'])->default('takeaway')->after('status');
            $table->foreignId('table_id')->nullable()->after('type')->constrained('tables')->nullOnDelete();
            $table->decimal('delivery_fee', 10, 2)->default(0)->after('table_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['table_id']);
            $table->dropColumn(['type', 'table_id', 'delivery_fee']);
        });
    }
};
