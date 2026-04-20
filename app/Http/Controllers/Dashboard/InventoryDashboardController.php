<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\PurchaseOrder;
use App\Models\StockCount;
use App\Models\TransferRequest;
use App\Models\ProductionOrder;

class InventoryDashboardController extends Controller
{
    public function index()
    {
        $inventories = Inventory::where('user_id', auth()->id())->get();

        $stats = [
            'items_count' => $inventories->count(),
            'low_stock_count' => $inventories->filter(function ($item) {
                return !is_null($item->reorder_level) && $item->current_quantity <= $item->reorder_level;
            })->count(),
            'inventory_value' => $inventories->sum(function ($item) {
                return (float) $item->current_quantity * (float) ($item->avg_cost ?: $item->purchase_price ?: 0);
            }),
            'pending_purchase_orders' => PurchaseOrder::where('user_id', auth()->id())
                ->whereIn('status', ['draft', 'approved', 'partial_received'])
                ->count(),
            'open_transfer_requests' => TransferRequest::where('user_id', auth()->id())
                ->whereIn('status', ['draft', 'approved'])
                ->count(),
            'draft_stock_counts' => StockCount::where('user_id', auth()->id())
                ->where('status', 'draft')
                ->count(),
            'draft_production_orders' => ProductionOrder::where('user_id', auth()->id())
                ->where('status', 'draft')
                ->count(),
        ];

        $lowStockItems = Inventory::with('inventoriable')
            ->where('user_id', auth()->id())
            ->get()
            ->filter(fn($item) => !is_null($item->reorder_level) && $item->current_quantity <= $item->reorder_level)
            ->take(10);

        return view('dashboard.inventory.dashboard', compact('stats', 'lowStockItems'));
    }
}