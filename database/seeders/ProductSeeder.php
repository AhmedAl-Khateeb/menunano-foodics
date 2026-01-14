<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'برجر دجاج', 'description' => 'برجر دجاج مشوي مع صوص خاص', 'cover' => '1745446083.jpg'],
            ['name' => 'بيتزا مارجريتا', 'description' => 'بيتزا بالجبن والطماطم الطازجة', 'cover' => '1745446083.jpg'],
            ['name' => 'شاورما لحم', 'description' => 'شاورما لحم متبلة تقدم مع صوص الثوم', 'cover' => '1745446083.jpg'],
            ['name' => 'بطاطس مقلية', 'description' => 'بطاطس مقلية مقرمشة طازجة', 'cover' => '1745446083.jpg'],
            ['name' => 'وجبة ناغتس', 'description' => 'قطع دجاج مقلية ذهبية مع صوصات', 'cover' => '1745446083.jpg'],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'cover' => $product['cover'],
                'category_id' => Category::inRandomOrder()->first()->id,
            ]);
        }
    }
}
