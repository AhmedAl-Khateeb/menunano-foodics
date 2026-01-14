<?php

namespace App\Http\Controllers;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackageController extends Controller
{
   public function activePackages(): JsonResponse
{
    $packages = Package::with('features') // يجيب الباقة مع الميزات
        ->where('is_active', 1)
        ->get();

    return response()->json([
        'status' => true,
        'message' => 'الباقات المفعلة',
        'data' => $packages
    ]);
}
}
