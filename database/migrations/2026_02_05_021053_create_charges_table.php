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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('name');

            // tax = ضريبة | fee = رسوم | discount = خصم
            $table->enum('classification', ['tax', 'fee', 'discount'])->default('tax');

            // percentage / fixed
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');

            $table->decimal('value', 8, 2);

            // الضريبة ضمن السعر ولا لأ
            $table->boolean('is_inclusive')->default(false);

            // هل مفعل
            $table->boolean('is_active')->default(true);

            // POS / Online / All
            $table->json('applicable_order_types')->nullable();

            $table->string('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
