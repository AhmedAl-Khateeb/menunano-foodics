<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransferRequestRequest;
use App\Models\Branch;
use App\Models\RawMaterial;
use App\Models\TransferRequest;
use App\Models\Unit;
use App\Services\TransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferRequestController extends Controller
{
    public function __construct(protected TransferService $transferService)
    {
    }

    public function index(Request $request)
    {
        $query = TransferRequest::with('items.rawMaterial')
            ->where('user_id', auth()->id())
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('transfer_number', 'like', '%'.$search.'%');
            });
        }

        $transfers = $query->paginate(15)->withQueryString();

        return view('dashboard.inventory.transfer_requests.index', compact('transfers'));
    }

    public function create()
    {
        $branches = Branch::where('created_by', auth()->id())->get();
        $materials = RawMaterial::where('user_id', auth()->id())->where('is_active', true)->get();
        $units = Unit::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.transfer_requests.create', compact('branches', 'materials', 'units'));
    }

    public function store(StoreTransferRequestRequest $request)
    {
        DB::transaction(function () use ($request) {
            $transfer = TransferRequest::create([
                'user_id' => auth()->id(),
                'transfer_number' => 'TR-'.now()->format('YmdHis'),
                'from_branch_id' => $request->from_branch_id,
                'to_branch_id' => $request->to_branch_id,
                'transfer_date' => $request->transfer_date,
                'status' => 'draft',
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $item) {
                $transfer->items()->create([
                    'raw_material_id' => $item['raw_material_id'],
                    'unit_id' => $item['unit_id'] ?? null,
                    'requested_quantity' => $item['requested_quantity'],
                    'sent_quantity' => $item['sent_quantity'] ?? 0,
                    'received_quantity' => $item['received_quantity'] ?? 0,
                    'notes' => $item['notes'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('inventory.transfer-requests.index')
            ->with('success', 'تم إنشاء طلب التحويل بنجاح');
    }

    public function edit(TransferRequest $transfer_request)
    {
        abort_if($transfer_request->user_id !== auth()->id(), 403);

        if ($transfer_request->status === 'received') {
            return redirect()->route('inventory.transfer-requests.index')
                ->with('error', 'لا يمكن تعديل تحويل تم استلامه');
        }

        $transfer_request->load('items');
        $branches = Branch::where('created_by', auth()->id())->get();
        $materials = RawMaterial::where('user_id', auth()->id())->where('is_active', true)->get();
        $units = Unit::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.transfer_requests.edit', compact('transfer_request', 'branches', 'materials', 'units'));
    }

    public function update(StoreTransferRequestRequest $request, TransferRequest $transfer_request)
    {
        abort_if($transfer_request->user_id !== auth()->id(), 403);

        if ($transfer_request->status === 'received') {
            return back()->with('error', 'لا يمكن تعديل تحويل تم استلامه');
        }

        DB::transaction(function () use ($request, $transfer_request) {
            $transfer_request->update([
                'from_branch_id' => $request->from_branch_id,
                'to_branch_id' => $request->to_branch_id,
                'transfer_date' => $request->transfer_date,
                'notes' => $request->notes,
            ]);

            $transfer_request->items()->delete();

            foreach ($request->items as $item) {
                $transfer_request->items()->create([
                    'raw_material_id' => $item['raw_material_id'],
                    'unit_id' => $item['unit_id'] ?? null,
                    'requested_quantity' => $item['requested_quantity'],
                    'sent_quantity' => $item['sent_quantity'] ?? 0,
                    'received_quantity' => $item['received_quantity'] ?? 0,
                    'notes' => $item['notes'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('inventory.transfer-requests.index')
            ->with('success', 'تم تعديل طلب التحويل بنجاح');
    }

    public function destroy(TransferRequest $transfer_request)
    {
        abort_if($transfer_request->user_id !== auth()->id(), 403);

        if ($transfer_request->status === 'received') {
            return back()->with('error', 'لا يمكن حذف تحويل تم استلامه');
        }

        $transfer_request->delete();

        return redirect()
            ->route('inventory.transfer-requests.index')
            ->with('success', 'تم حذف طلب التحويل بنجاح');
    }

    public function approve(TransferRequest $transfer_request)
    {
        abort_if($transfer_request->user_id !== auth()->id(), 403);

        if ($transfer_request->status !== 'draft') {
            return back()->with('error', 'فقط المسودات يمكن اعتمادها');
        }

        $this->transferService->approve($transfer_request->load('items'));

        return back()->with('success', 'تم اعتماد التحويل وصرف الكميات');
    }

    public function receive(TransferRequest $transfer_request)
    {
        abort_if($transfer_request->user_id !== auth()->id(), 403);

        if (!in_array($transfer_request->status, ['approved'])) {
            return back()->with('error', 'يجب اعتماد التحويل أولًا');
        }

        $this->transferService->receive($transfer_request->load('items'));

        return back()->with('success', 'تم استلام التحويل بنجاح');
    }
}
