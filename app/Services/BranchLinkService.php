<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\BranchLink;
use Illuminate\Validation\ValidationException;

class BranchLinkService
{
    private function canAccessBranch(Branch $branch, $user): bool
    {
        if ($user->role === 'super_admin') {
            return true;
        }

        if (
            (int) $branch->owner_id === (int) $user->id ||
            (int) $branch->created_by === (int) $user->id ||
            (int) $branch->business_id === (int) $user->id
        ) {
            return true;
        }

        return $branch->users()
            ->where('users.id', $user->id)
            ->exists();
    }

    public function store(array $data)
    {
        if ((int) $data['from_branch_id'] === (int) $data['to_branch_id']) {
            throw ValidationException::withMessages([
                'to_branch_id' => 'لا يمكن ربط الفرع بنفسه.',
            ]);
        }

        $user = auth('web')->user();

        $fromBranch = Branch::findOrFail($data['from_branch_id']);
        $toBranch = Branch::findOrFail($data['to_branch_id']);

        abort_unless($this->canAccessBranch($fromBranch, $user), 403);
        abort_unless($this->canAccessBranch($toBranch, $user), 403);

        return BranchLink::updateOrCreate(
            [
                'from_branch_id' => $data['from_branch_id'],
                'to_branch_id' => $data['to_branch_id'],
                'type' => $data['type'] ?? 'linked',
            ],
            [
                'business_id' => $fromBranch->business_id
                    ?? $fromBranch->owner_id
                    ?? $fromBranch->created_by,

                'is_active' => !empty($data['is_active']),
            ]
        );
    }

    public function destroy($id)
    {
        $user = auth('web')->user();

        $link = BranchLink::with(['fromBranch', 'toBranch'])->findOrFail($id);

        if ($user->role !== 'super_admin') {
            abort_unless(
                $link->fromBranch &&
                $this->canAccessBranch($link->fromBranch, $user),
                403
            );
        }

        $link->delete();

        return $link;
    }
}