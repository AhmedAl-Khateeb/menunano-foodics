<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'مشويات', 'cover' => '1745443664.png'],
            ['name' => 'محاشي', 'cover' => '1745444556.PNG'],
            ['name' => 'لحوم ستيك', 'cover' => '1745444804.png'],
            ['name' => 'فراخ جريل', 'cover' => '1745444676.PNG'],
            ['name' => 'طاجن بطاطا', 'cover' => '1745444700.PNG'],
            ['name' => 'سلطات', 'cover' => '1745444731.PNG'],
            ['name' => 'قلاش', 'cover' => '1745445091.PNG'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
