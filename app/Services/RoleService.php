<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService
{
    public function getAvailablePermissionsForCurrentUser()
    {
        $user = auth()->user();
        $userRole = $user->role;

        $permissionsQuery = \App\Models\Permission::query();

        if ($userRole !== 'super_admin') {
            $permissionsQuery->where('user_role', $userRole);
        }

        return $permissionsQuery->get()->groupBy('group');
    }

    public function create(array $data): Role
    {
        $role = Role::create([
            'name' => $data['name'],
            'guard_name' => 'web',
            'created_by' => auth()->id(),
        ]);

        $role->syncPermissions($data['permissions'] ?? []);

        return $role;
    }

    public function update(Role $role, array $data): Role
    {
        $this->authorizeOwnership($role);

        $role->update([
            'name' => $data['name'],
        ]);

        $role->syncPermissions($data['permissions'] ?? []);

        return $role;
    }

    public function delete(Role $role): void
    {
        $this->authorizeOwnership($role);

        $role->delete();
    }

    public function authorizeOwnership(Role $role): void
    {
        abort_if($role->created_by !== auth()->id(), 403);
    }
}
