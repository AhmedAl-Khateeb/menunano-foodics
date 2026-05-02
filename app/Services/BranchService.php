<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchService
{
    public function index(Request $request)
    {
        $search = $request->search;
        $user = auth('web')->user();

        $query = Branch::withCount('users')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', $search)
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('date_from'), function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->date_to);
            });

        if ($user->role === 'super_admin') {
            // السوبر أدمن يرى كل الفروع
        } elseif ($user->role === 'admin') {
            $query->where(function ($q) use ($user) {
                $q->where('owner_id', $user->id)
                    ->orWhere('created_by', $user->id)
                    ->orWhereHas('users', function ($userQuery) use ($user) {
                        $userQuery->where('users.id', $user->id);
                    });
            });
        } else {
            $query->whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        return $query->latest()->paginate(10)->withQueryString();
    }

    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            $ownerId = auth('web')->id();

            $branch = Branch::create([
                'business_id' => $ownerId,
                'name' => $data['name'],
                'code' => $data['code'] ?? null,
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
                'is_active' => !empty($data['is_active']),
                'created_by' => $ownerId,
                'owner_id' => $ownerId,
            ]);

            // صاحب الحساب مدير أساسي بصلاحيات كاملة
            $branch->users()->syncWithoutDetaching([
                $ownerId => [
                    'role' => 'owner',
                    'is_primary_manager' => true,
                    'can_manage_permissions' => true,
                    'permissions' => json_encode(['*']),
                    'assigned_by' => $ownerId,
                ],
            ]);

            // مستخدم إضافي اختياري
            if (!empty($data['manager_user_id']) && (int) $data['manager_user_id'] !== (int) $ownerId) {
                $isPrimaryManager = !empty($data['is_primary_manager']);

                $permissions = $isPrimaryManager
                    ? ['*']
                    : ($data['permissions'] ?? []);

                $branch->users()->syncWithoutDetaching([
                    $data['manager_user_id'] => [
                        'role' => $data['branch_role'] ?? 'manager',
                        'is_primary_manager' => $isPrimaryManager,
                        'can_manage_permissions' => !empty($data['can_manage_permissions']),
                        'permissions' => json_encode($permissions),
                        'assigned_by' => $ownerId,
                    ],
                ]);
            }

            return $branch;
        });
    }

    public function update($data, $id)
    {
        $branch = Branch::findOrFail($id);

        abort_unless(
            $branch->created_by === auth('web')->id()
            || $branch->owner_id === auth('web')->id(),
            403
        );

        $branch->update([
            'name' => $data['name'],
            'code' => $data['code'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,

            // مهم: لو checkbox مش متعلم هيرجع false بدل ما يفضل true
            'is_active' => !empty($data['is_active']),
        ]);

        return $branch;
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        abort_unless($branch->created_by === auth('web')->id(), 403);
        $branch->delete();

        return $branch;
    }


    
    public function assignManager($branchId, $data)
    {
        $branch = Branch::findOrFail($branchId);

        abort_unless(
            $branch->created_by === auth('web')->id()
            || $branch->owner_id === auth('web')->id()
            || auth('web')->user()->role === 'super_admin',
            403
        );

        $userId = $data['user_id'];

        $isPrimaryManager = !empty($data['is_primary_manager']);

        $permissions = $data['permissions'] ?? [];

        $branch->users()->syncWithoutDetaching([
            $userId => [
                'role' => $data['role'],
                'is_primary_manager' => $isPrimaryManager,
                'can_manage_permissions' => in_array('branches.manage_permissions', $permissions, true),
                'permissions' => json_encode($permissions),
                'assigned_by' => auth('web')->id(),
            ],
        ]);

        return $branch;
    }
}
