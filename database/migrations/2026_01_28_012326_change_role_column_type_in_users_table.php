<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Change role from ENUM to String (VARCHAR 191)
            // This preserves existing data and allows any string value
            $table->string('role', 191)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert back to ENUM if possible
            // Note: This might fail if the column contains values not in the allowed list
            // For now, we define the original values
            $table->enum('role', ['super_admin', 'admin', 'user', 'cashier'])->nullable()->change();
        });
    }
};
