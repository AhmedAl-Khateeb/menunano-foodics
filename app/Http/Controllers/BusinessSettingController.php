<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use Illuminate\Http\Request;

class BusinessSettingController extends Controller
{
    public function index()
    {
        $settings = BusinessSetting::pluck('value', 'key');

        // إذا كان فيه صورة رئيسية نخزنها كرابط كامل
        if (!empty($settings['main_image'])) {
            $settings['main_image'] = asset('storage/' . $settings['main_image']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Business settings retrieved successfully',
            'data' => $settings
        ]);
    }
}
