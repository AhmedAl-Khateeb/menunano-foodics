<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class SettingController extends Controller
{
    
    public function index()
{
    $user = auth()->user();

    // نجيب الإعدادات الخاصة بالمستخدم الحالي
    $settings = Setting::where('user_id', $user->id)->get();

    // لو المستخدم مالوش إعدادات ننسخ من المستخدم 1 (الافتراضي)
    if ($settings->isEmpty()) {
        $defaultSettings = Setting::where('user_id', 1)->get();

        foreach ($defaultSettings as $setting) {
            Setting::create([
                'user_id' => $user->id,
                'key' => $setting->key,
                'value' => $setting->value,
            ]);
        }

        // نجيب الإعدادات بعد الإدخال
        $settings = Setting::where('user_id', $user->id)->get();
    }

    return view('settings.index', compact('settings'));
}


    public function update(Request $request, Setting $setting)
{
    try {

        if ($setting->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'key' => 'required|string|in:name,description,logo,phone,whatsapp,theme,status,facebook,instagram,address,copyright,maincolor,secondcolor,curency,maintextcolor,secoundtextcolor,thirdtextcolor',
            'value' => 'required',
        ]);

        $value = $request->value;

        if ($request->hasFile('value')) {
            $file = $request->file('value');

            $path = $file->store('images/setting', 'public');

            $value = $path;
        }

        $setting->update(['value' => $value]);

        Alert::success('تم الحفظ بنجاح');
        return redirect()->route('settings.index');

    } catch (\Exception $exception) {
        Alert::toast('حدث خطأ غير متوقع', 'error');
        return redirect()->back();
    }
}


}
