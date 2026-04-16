<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use App\Models\BusinessType;
use App\Models\Package;
use App\Services\PackageService;

class PackageController extends Controller
{
    public function __construct(private readonly PackageService $packageService)
    {
    }

    public function index()
    {
        $packages = $this->packageService->index();

        return view('super_admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $businessTypes = BusinessType::where('is_active', true)->get();

        return view('super_admin.packages.create', compact('businessTypes'));
    }

    public function store(PackageRequest $request)
    {
        $this->packageService->store($request->validated());

        return redirect()
            ->route('packages.index')
            ->with('success', 'تمت إضافة الباقة بنجاح');
    }

    public function edit(Package $package)
    {
        $package->load('features');
        $businessTypes = BusinessType::where('is_active', true)->get();

        return view('super_admin.packages.edit', compact('package', 'businessTypes'));
    }

    public function update(PackageRequest $request, Package $package)
    {
        $this->packageService->update($package, $request->validated());

        return redirect()
            ->route('packages.index')
            ->with('success', 'تم تعديل الباقة بنجاح');
    }

    public function destroy(Package $package)
    {
        $this->packageService->delete($package);

        return redirect()
            ->route('packages.index')
            ->with('success', 'تم حذف الباقة بنجاح');
    }
}
