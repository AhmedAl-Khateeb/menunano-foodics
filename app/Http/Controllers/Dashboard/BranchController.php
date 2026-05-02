<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Http\Requests\BranchUpdateRequest;
use App\Models\Branch;
use App\Models\User;
use App\Services\BranchService;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct(private readonly BranchService $branchService)
    {
    }

    public function index(Request $request)
    {
        $branches = $this->branchService->index($request);

        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        abort_unless(auth('web')->user()->role === 'super_admin', 403);

        $users = User::where(function ($query) {
            $query->where('id', auth('web')->id())
                ->orWhere('created_by', auth('web')->id());
        })
            ->whereIn('role', ['admin', 'cashier'])
            ->orderBy('name')
            ->get();

        return view('branches.create', compact('users'));
    }

    public function store(BranchRequest $request)
    {
        abort_unless(auth('web')->user()->role === 'super_admin', 403);

        $this->branchService->store($request->validated());

        return redirect()->route('branches.index')->with('success', 'تم إنشاء الفرع بنجاح');
    }

    public function edit($id)
    {
        $branch = Branch::findOrFail($id);

        abort_unless(
            $branch->created_by === auth('web')->id()
            || $branch->owner_id === auth('web')->id()
            || auth('web')->user()->role === 'super_admin',
            403
        );

        $users = User::where(function ($query) {
            $query->where('id', auth('web')->id())
                ->orWhere('created_by', auth('web')->id());
        })
            ->whereIn('role', ['admin', 'cashier', 'staff', 'employee'])
            ->orderBy('name')
            ->get();

        $branchPermissions = collect(config('branch_permissions'))
        ->groupBy('group');

        return view('branches.edit', compact('branch', 'users', 'branchPermissions'));
    }

    public function update(BranchUpdateRequest $request, $id)
    {
        $this->branchService->update($request->validated(), $id);

        return redirect()->route('branches.index')->with('success', 'تم تحديث الفرع بنجاح');
    }

    public function destroy($id)
    {
        $this->branchService->destroy($id);

        return redirect()->route('branches.index')->with('success', 'تم حذف الفرع بنجاح');
    }

    public function assignManager(Request $request, $id)
    {
        $availablePermissions = collect(config('branch_permissions'))
            ->pluck('key')
            ->filter()
            ->values()
            ->toArray();

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:manager,cashier,staff',
            'is_primary_manager' => 'nullable|boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:'.implode(',', $availablePermissions),
        ]);

        $this->branchService->assignManager($id, $data);

        return redirect()
            ->route('branches.index')
            ->with('success', 'تم ربط المستخدم بالفرع بنجاح');
    }
}
