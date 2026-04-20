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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained()->restrictOnDelete();
            $table->foreignId('purchase_request_id')->nullable()->constrained()->nullOnDelete();

            $table->string('po_number')->unique();
            $table->date('po_date');
            $table->date('expected_date')->nullable();

            $table->enum('status', ['draft', 'sent', 'partial_received', 'received', 'cancelled'])->default('draft');
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
        Schema::dropIfExists('purchase_orders');
    }
};
