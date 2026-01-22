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
            $table->foreignId('customer_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('payment_method')->after('total_price')->default('cash');
            $table->string('payment_proof')->after('payment_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn(['customer_id', 'payment_method', 'payment_proof']);
            $table->string('name')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
        });
    }
};
