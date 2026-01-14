<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'logo', 'value' => 'https://adminflamingo.blacklionsky.com/public/images/setting/1745080616.png'],
            ['key' => 'name', 'value' => 'فلا منجوو'],
            ['key' => 'description', 'value' => 'Description'],
            ['key' => 'phone', 'value' => '01094925571'],
            ['key' => 'whatsapp', 'value' => '+201094925571'],
            ['key' => 'address', 'value' => 'الغردقة'],
            ['key' => 'theme', 'value' => '1'],
            ['key' => 'status', 'value' => '1'],
            ['key' => 'facebook', 'value' => 'https://www.facebook.com/share/1946ZQCHcn/'],
            ['key' => 'instagram', 'value' => 'https://www.facebook.com/share/1946ZQCHcn/'],
            ['key' => 'copyright', 'value' => '© nano. All rights reserved.'],
            ['key' => 'maincolor', 'value' => '#96cfb2'],
            ['key' => 'curency', 'value' => 'جنية'],
            ['key' => 'secondcolor', 'value' => '#000000'],
            ['key' => 'maintextcolor', 'value' => '#f8f7f1'],
            ['key' => 'secoundtextcolor', 'value' => '#111d14'],
            ['key' => 'thirdtextcolor', 'value' => '#ffffff'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
