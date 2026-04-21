<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('package_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->string('permission_key');
            $table->timestamps();

            $table->unique(['package_id', 'permission_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_permissions');
    }
};
