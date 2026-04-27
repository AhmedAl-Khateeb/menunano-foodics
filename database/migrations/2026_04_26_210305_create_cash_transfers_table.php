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
        Schema::create('cash_transfers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('from_shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->foreignId('to_shift_id')->nullable()->constrained('shifts')->nullOnDelete();

            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();

            $table->foreignId('from_user_id')->nullable()->constrained('users')->nullOnDelete(); // الكاشير
            $table->foreignId('to_user_id')->nullable()->constrained('users')->nullOnDelete();   // المدير أو الكاشير التالي

            $table->enum('type', ['to_manager', 'to_next_shift', 'to_safe'])->default('to_manager');

            $table->decimal('amount', 12, 2)->default(0);

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');

            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_transfers');
    }
};
