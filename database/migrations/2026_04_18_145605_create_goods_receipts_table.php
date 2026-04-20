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
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('purchase_order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('supplier_id')->constrained()->restrictOnDelete();

            $table->string('receipt_number')->unique();
            $table->date('receipt_date');
            $table->enum('status', ['draft', 'posted', 'cancelled'])->default('posted');

            $table->decimal('subtotal', 14, 3)->default(0);
            $table->decimal('discount', 14, 3)->default(0);
            $table->decimal('tax', 14, 3)->default(0);
            $table->decimal('total', 14, 3)->default(0);

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};
