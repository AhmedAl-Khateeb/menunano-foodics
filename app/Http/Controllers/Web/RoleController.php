<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(private RoleService $roleService)
    {
    }

    public function index()
    {
        $roles = Role::where('created_by', auth()->id())
            ->latest()
            ->paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->roleService->getAvailablePermissionsForCurrentUser();

        return view('roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->roleService->create($request->validated());

        return redirect()
            ->route('roles.index')
            ->with('success', 'تم إنشاء الدور بنجاح');
    }

    public function edit(Role $role)
    {
        $this->roleService->authorizeOwnership($role);

        $permissions = $this->roleService->getAvailablePermissionsForCurrentUser();

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->roleService->update($role, $request->validated());

        return redirect()
            ->route('roles.index')
            ->with('success', 'تم تحديث الدور بنجاح');
    }

    public function destroy(Role $role)
    {
        try {
            $this->roleService->delete($role);

            return redirect()
                ->route('roles.index')
                ->with('success', 'تم حذف الدور بنجاح');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء حذف الدور');
        }
    }
}
