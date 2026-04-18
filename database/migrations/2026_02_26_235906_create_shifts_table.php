<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();

            $table->decimal('starting_cash', 10, 2)->default(0);
            $table->decimal('expected_cash', 10, 2)->default(0)->comment('النقدية المتوقعة في نهاية الشيفت بناءً على المبيعات والمصروفات');
            $table->decimal('ending_cash', 10, 2)->nullable();
            $table->decimal('cash_difference', 10, 2)->default(0)->comment('الفرق بين النقدية المتوقعة والنقدية الفعلية');

            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();

            $table->enum('status', ['active', 'paused', 'closed'])->default('active');
            $table->text('notes')->nullable();

            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete()->comment('المستخدم الذي قام بإغلاق الشيفت');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};