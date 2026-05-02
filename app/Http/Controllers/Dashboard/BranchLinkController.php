<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchLinkRequest;
use App\Models\Branch;
use App\Models\BranchLink;
use App\Services\BranchLinkService;

class BranchLinkController extends Controller
{
    public function __construct(
        private readonly BranchLinkService $service
    ) {
    }

    private function availableBranches()
    {
        $user = auth('web')->user();

        $branchesQuery = Branch::query();

        if ($user->role !== 'super_admin') {
            $branchesQuery->where(function ($query) use ($user) {
                $query->where('owner_id', $user->id)
                    ->orWhere('created_by', $user->id)
                    ->orWhere('business_id', $user->id)
                    ->orWhereHas('users', function ($q) use ($user) {
                        $q->where('users.id', $user->id);
                    });
            });
        }

        return $branchesQuery->orderBy('name')->get();
    }

    public function index()
    {
        $user = auth('web')->user();

        $branches = $this->availableBranches();
        $branchIds = $branches->pluck('id')->toArray();

        $linksQuery = BranchLink::with(['fromBranch', 'toBranch'])
            ->latest();

        if ($user->role !== 'super_admin') {
            $linksQuery->where(function ($query) use ($branchIds) {
                $query->whereIn('from_branch_id', $branchIds)
                    ->orWhereIn('to_branch_id', $branchIds);
            });
        }

        $links = $linksQuery->paginate(10)->withQueryString();

        return view('branch_links.index', compact('links'));
    }

    public function create()
    {
        $branches = $this->availableBranches();

        return view('branch_links.create', compact('branches'));
    }

    public function store(BranchLinkRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('branch-links.index')
            ->with('success', 'تم ربط الفرعين بنجاح.');
    }

    public function destroy($id)
    {
        $this->service->destroy($id);

        return redirect()
            ->route('branch-links.index')
            ->with('success', 'تم حذف الربط بنجاح.');
    }
}