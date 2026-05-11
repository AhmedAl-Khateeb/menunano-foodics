<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_type_permission_defaults', function (Blueprint $table) {
            $table->id();

            $table->foreignId('business_type_id')
                ->constrained('business_types')
                ->cascadeOnDelete();

            $table->string('permission_key', 120);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(
                ['business_type_id', 'permission_key'],
                'bt_permission_default_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_type_permission_defaults');
    }
};