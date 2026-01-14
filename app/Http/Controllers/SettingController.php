<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Models\Setting;
use App\Traits\StoreHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class SettingController extends Controller
{
    use StoreHelper;
    public function index($storeName)
    {
        $user = $this->getUserByStoreName($storeName);

        $settings = Setting::select('key', 'value')
        ->where('user_id', $user->id)
        ->get()
        ->map(function ($setting) {
            // إذا القيمة صورة نخليها لينك كامل
            if ($setting->value && str_contains($setting->value, 'images/setting/')) {
                $setting->value = asset('storage/app/public/' . $setting->value);
            }
            return $setting;
        });

        return ApiResponse::success($settings);
    }

    public function show($storeName, $setting)
    {
        $user = $this->getUserByStoreName($storeName);

        $value = Setting::where('user_id', $user->id)
            ->where('key', $setting)
            ->firstOrFail()
            ->value;

        return ApiResponse::success([$setting => $value]);
    }
    public function getAdminImages()
{
    $images = User::where('role', 'admin')
        ->whereNotNull('image')
        ->pluck('image')
        ->map(function ($image) {
            return asset('storage/app/public/' . $image);
        });;

    return response()->json([
        'status' => true,
        'images' => $images,
    ]);
}
public function getAdminStatus(Request $request): JsonResponse
{
    $request->validate([
        'store_name' => 'required|string|exists:users,store_name'
    ]);

    $admin = User::where('store_name', $request->store_name)
        ->where('role', 'admin')
        ->first();

    return response()->json([
        'success' => true,
        'message' => 'تم جلب حالة الأدمن بنجاح',
        'data' => [
            'store_name' => $admin->store_name,
            'status' => $admin->status,
        ]
    ]);
}

}
