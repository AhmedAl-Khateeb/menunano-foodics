<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Http\Requests\BranchUpdateRequest;
use App\Models\Branch;
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
        return view('branches.create');
    }

    public function store(BranchRequest $request)
    {
        $this->branchService->store($request->validated());

        return redirect()->route('branches.index')->with('success', 'تم إنشاء الفرع بنجاح');
    }

    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        abort_unless($branch->created_by === auth('web')->id(), 403);

        return view('branches.edit', compact('branch'));
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
}
