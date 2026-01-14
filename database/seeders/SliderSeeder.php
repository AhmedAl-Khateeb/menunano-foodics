<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            ['title' => 'ربع فراخ رول', 'description' => 'فراخ رول بالمشروم+رز+سلطة+خضار', 'image' => 'slider/1745165204.jpg'],
            ['title' => null, 'description' => null, 'image' => 'slider/1745450798.jpeg'],
            ['title' => null, 'description' => null, 'image' => 'slider/1745450814.jpeg'],
            ['title' => null, 'description' => null, 'image' => 'slider/1745451060.jpg']
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
