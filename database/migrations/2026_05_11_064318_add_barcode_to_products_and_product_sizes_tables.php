<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'barcode')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('barcode')->nullable()->unique()->after('name');
            });
        }

        if (!Schema::hasColumn('product_sizes', 'barcode')) {
            Schema::table('product_sizes', function (Blueprint $table) {
                $table->string('barcode')->nullable()->unique()->after('size');
            });
        }

        DB::table('products')
            ->whereNull('barcode')
            ->orderBy('id')
            ->select('id')
            ->chunkById(100, function ($products) {
                foreach ($products as $product) {
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update([
                            'barcode' => 'P'.str_pad($product->id, 8, '0', STR_PAD_LEFT),
                        ]);
                }
            });

        DB::table('product_sizes')
            ->whereNull('barcode')
            ->orderBy('id')
            ->select('id')
            ->chunkById(100, function ($sizes) {
                foreach ($sizes as $size) {
                    DB::table('product_sizes')
                        ->where('id', $size->id)
                        ->update([
                            'barcode' => 'S'.str_pad($size->id, 8, '0', STR_PAD_LEFT),
                        ]);
                }
            });
    }

    public function down(): void
    {
        if (Schema::hasColumn('product_sizes', 'barcode')) {
            Schema::table('product_sizes', function (Blueprint $table) {
                $table->dropColumn('barcode');
            });
        }

        if (Schema::hasColumn('products', 'barcode')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('barcode');
            });
        }
    }
};
