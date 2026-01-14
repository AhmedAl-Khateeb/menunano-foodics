<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageFeature;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::with('features')->get();
        return view('super_admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'required|integer|min:1',
            'is_active'   => 'boolean',
            'features'    => 'nullable|array',
            'features.*'  => 'nullable|string|max:255',
        ]);

        $package = Package::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'duration'    => $request->duration,
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ]);

        // إضافة الـ features لو موجودة
        if ($request->filled('features')) {
            foreach ($request->features as $feature) {
                if ($feature) {
                    PackageFeature::create([
                        'package_id' => $package->id,
                        'text'       => $feature,
                    ]);
                }
            }
        }

        return redirect()->route('packages.index')->with('success', 'تمت إضافة الباقة بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        $package->load('features');
        return view('super_admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Package $package)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'required|integer|min:1',
            'is_active'   => 'boolean',
            'features'    => 'nullable|array',
            'features.*.id'   => 'nullable|integer|exists:package_features,id',
            'features.*.text' => 'nullable|string|max:255',
        ]);

        $package->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'duration'    => $request->duration,
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ]);

        // تحديث الـ features (مسح القديمة وإضافة الجديدة)
        $package->features()->delete();

        if ($request->filled('features')) {
            foreach ($request->features as $featureData) {
                $text = $featureData['text'] ?? null;

                if (!empty($text)) {
                    PackageFeature::create([
                        'package_id' => $package->id,
                        'text'       => $text,
                    ]);
                }
            }
        }

        return redirect()->route('packages.index')->with('success', 'تم تعديل الباقة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->features()->delete(); // احذف الفيتشرز كمان
        $package->delete();

        return redirect()->route('packages.index')->with('success', 'تم حذف الباقة بنجاح');
    }
}
