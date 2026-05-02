<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\BranchCreationRequest;
use Illuminate\Support\Facades\DB;

class BranchCreationRequestService
{
    public function store(array $data)
    {
        $userId = auth('web')->id();

        return BranchCreationRequest::create([
            'business_id' => $userId,
            'requested_by' => $userId,

            'branch_name' => $data['branch_name'],
            'branch_code' => $data['branch_code'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,

            'status' => 'pending',
        ]);
    }

    public function approve($id)
    {
        return DB::transaction(function () use ($id) {
            $request = BranchCreationRequest::findOrFail($id);

            if ($request->status === 'approved') {
                return $request;
            }

            $branch = Branch::create([
                'business_id' => $request->business_id,
                'owner_id' => $request->requested_by,
                'created_by' => $request->requested_by,

                'name' => $request->branch_name,
                'code' => $request->branch_code,
                'phone' => $request->phone,
                'address' => $request->address,
                'is_active' => true,
            ]);

            // ربط صاحب الطلب بالفرع كمالك بصلاحيات كاملة
            $branch->users()->syncWithoutDetaching([
                $request->requested_by => [
                    'role' => 'owner',
                    'is_primary_manager' => true,
                    'can_manage_permissions' => true,
                    'permissions' => json_encode(['*']),
                    'assigned_by' => auth('web')->id(),
                ],
            ]);

            $request->update([
                'status' => 'approved',
                'approved_by' => auth('web')->id(),
                'approved_at' => now(),
                'created_branch_id' => $branch->id,
            ]);

            return $request;
        });
    }

    public function reject($id)
    {
        $request = BranchCreationRequest::findOrFail($id);

        $request->update([
            'status' => 'rejected',
            'approved_by' => auth('web')->id(),
            'approved_at' => now(),
        ]);

        return $request;
    }
}
