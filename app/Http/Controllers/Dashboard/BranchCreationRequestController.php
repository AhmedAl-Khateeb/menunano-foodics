<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchCreationRequestRequest;
use App\Models\BranchCreationRequest;
use App\Services\BranchCreationRequestService;
use Illuminate\Http\Request;

class BranchCreationRequestController extends Controller
{
    public function __construct(
        private readonly BranchCreationRequestService $service
    ) {
    }

    public function index(Request $request)
    {
        $user = auth('web')->user();

        $query = BranchCreationRequest::with(['requester', 'createdBranch'])
            ->latest()
            ->when($request->filled('date_from'), function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->date_to);
            });

        if ($user->role !== 'super_admin') {
            $query->where('requested_by', $user->id);
        }

        $requests = $query->paginate(10)->withQueryString();

        return view('branch_creation_requests.index', compact('requests'));
    }

    public function create()
    {
        return view('branch_creation_requests.create');
    }

    public function store(BranchCreationRequestRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('branch-creation-requests.index')
            ->with('success', 'تم إرسال طلب إنشاء الفرع بنجاح، وفي انتظار الموافقة.');
    }

    public function approve($id)
    {
        abort_unless(auth('web')->user()->role === 'super_admin', 403);

        $this->service->approve($id);

        return back()->with('success', 'تمت الموافقة وإنشاء الفرع بنجاح.');
    }

    public function reject($id)
    {
        abort_unless(auth('web')->user()->role === 'super_admin', 403);

        $this->service->reject($id);

        return back()->with('success', 'تم رفض طلب إنشاء الفرع.');
    }
}
