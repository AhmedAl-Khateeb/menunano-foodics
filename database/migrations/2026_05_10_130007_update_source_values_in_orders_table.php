<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        DB::table('orders')
            ->whereIn('source', ['web', 'app'])
            ->update(['source' => 'online']);

        DB::table('orders')
            ->where('source', 'pos')
            ->update(['source' => 'cachire']);

        DB::table('orders')
            ->whereNull('source')
            ->update(['source' => 'online']);

        Schema::table('orders', function (Blueprint $table) {
            $table->string('source')->default('online')->change();
        });
    }

    public function down(): void
    {
        DB::table('orders')
            ->where('source', 'online')
            ->update(['source' => 'web']);

        DB::table('orders')
            ->where('source', 'cachire')
            ->update(['source' => 'pos']);

        Schema::table('orders', function (Blueprint $table) {
            $table->string('source')->default('web')->change();
        });
    }
};
