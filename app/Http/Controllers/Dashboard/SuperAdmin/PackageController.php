<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use App\Models\BusinessType;
use App\Models\Package;
use App\Services\PackageService;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function __construct(private readonly PackageService $packageService)
    {
    }

    private function availablePermissions(): array
    {
        return config('package_permissions');
    }

    public function index()
    {
        $packages = $this->packageService->index();

        return view('super_admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $businessTypes = BusinessType::where('is_active', true)
        ->whereIn('slug', ['rest', 'acc', 'menu'])
        ->get();
        $availablePermissions = $this->availablePermissions();
        $permissionDefaults = $this->permissionDefaults();

        return view('super_admin.packages.create', compact('businessTypes', 'availablePermissions', 'permissionDefaults'));
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
        $package->load('features', 'permissions');

        $businessTypes = BusinessType::where('is_active', true)
            ->whereIn('slug', ['rest', 'acc', 'menu'])
            ->get();

        $availablePermissions = $this->availablePermissions();

        $permissionDefaults = $this->permissionDefaults();

        return view('super_admin.packages.edit', compact(
            'package',
            'businessTypes',
            'availablePermissions',
            'permissionDefaults'
        ));
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

    private function permissionDefaults(): array
    {
        return DB::table('business_type_permission_defaults as btp')
            ->join('business_types as bt', 'bt.id', '=', 'btp.business_type_id')
            ->where('btp.is_active', true)
            ->where('bt.is_active', true)
            ->select('bt.slug', 'btp.permission_key')
            ->get()
            ->groupBy('slug')
            ->map(function ($items) {
                return $items->pluck('permission_key')->values()->toArray();
            })
            ->toArray();
    }
}
