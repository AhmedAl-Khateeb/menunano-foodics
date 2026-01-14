<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = ['وسط', 'صغير'];

        foreach (Product::all() as $product) {
            foreach ($sizes as $index => $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'price' => 30 + ($product->id * 5) + ($index * 10),
                ]);
            }
        }
    }
}
