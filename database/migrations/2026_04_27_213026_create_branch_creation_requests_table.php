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
        Schema::create('branch_creation_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('business_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();

            $table->string('branch_name');
            $table->string('branch_code')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();

            // $table->decimal('amount', 10, 2)->default(0);
            // $table->string('payment_method')->nullable();
            // $table->string('payment_reference')->nullable();

            $table->enum('status', ['pending', 'paid', 'approved', 'rejected'])->default('pending');

            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();

            $table->foreignId('created_branch_id')->nullable()->constrained('branches')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_creation_requests');
    }
};
