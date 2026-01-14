<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusinessSettingController extends Controller
{
    public function index()
    {
        // جلب جميع الإعدادات من الداتا بيز
        $allSettings = BusinessSetting::all();

        // تحويل إلى مصفوفة associative array
        $settings = [];
        foreach ($allSettings as $setting) {
            $settings[$setting->key] = $setting->value;
        }

        // المفاتيح المطلوبة مع قيم افتراضية
        $requiredKeys = [
            'video_link_1' => '',
            'video_link_2' => '',
            'description' => '',
            'whatsapp' => '',
            'phone' => '',
            'currancy' => '',
            'main_image' => ''
        ];


        return view('super_admin.business_settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // التحقق من الصحة
        $validated = $request->validate([
            'video_link_1' => 'nullable|string|max:500',
            'video_link_2' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'currency' => 'nullable|string|max:10',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // معالجة البيانات
        foreach ($validated as $key => $value) {
            if ($key === 'main_image' && $request->hasFile('main_image')) {
                // حذف الصورة القديمة إذا وجدت
                $oldSetting = BusinessSetting::where('key', 'main_image')->first();
                if ($oldSetting && $oldSetting->value) {
                    Storage::disk('public')->delete($oldSetting->value);
                }

                // حفظ الصورة الجديدة
                $imagePath = $request->file('main_image')->store('settings', 'public');
                BusinessSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $imagePath]
                );
            } else {
                BusinessSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value ?: '']
                );
            }
        }

        return redirect()->route('business_settings.index')
            ->with('success', 'تم تحديث الإعدادات بنجاح');
    }
}
