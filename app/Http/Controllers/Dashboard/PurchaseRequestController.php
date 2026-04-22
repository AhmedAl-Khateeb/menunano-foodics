<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequestRequest;
use App\Models\PurchaseRequest;
use App\Models\RawMaterial;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseRequest::with(['items.rawMaterial', 'items.unit', 'approver'])
            ->where('user_id', auth()->id())
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('request_date')) {
            $query->where('request_date', $request->request_date);
        }

        $purchaseRequests = $query->paginate(15)->withQueryString();

        return view('dashboard.inventory.purchase_requests.index', compact('purchaseRequests'));
    }

    public function create()
    {
        $materials = RawMaterial::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        $units = Unit::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.purchase_requests.create', compact('materials', 'units'));
    }

    public function store(StorePurchaseRequestRequest $request)
    {
        DB::transaction(function () use ($request) {
            $purchaseRequest = PurchaseRequest::create([
                'user_id' => auth()->id(),
                'request_number' => 'PR-'.now()->format('YmdHis'),
                'request_date' => $request->request_date,
                'status' => 'draft',
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $item) {
                $purchaseRequest->items()->create([
                    'raw_material_id' => $item['raw_material_id'],
                    'unit_id' => $item['unit_id'] ?? null,
                    'requested_quantity' => $item['requested_quantity'],
                    'approved_quantity' => 0,
                    'notes' => $item['notes'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('inventory.purchase-requests.index')
            ->with('success', 'تم إنشاء طلب الشراء بنجاح');
    }

    public function approve(PurchaseRequest $purchase_request)
    {
        abort_if($purchase_request->user_id !== auth()->id(), 403);

        $purchase_request->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $purchase_request->items()->each(function ($item) {
            if ($item->approved_quantity <= 0) {
                $item->update([
                    'approved_quantity' => $item->requested_quantity,
                ]);
            }
        });

        return back()->with('success', 'تم اعتماد طلب الشراء بنجاح');
    }
}
