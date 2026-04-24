<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InventoryCategory;
use App\Models\InventoryMovement;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryMovement::with(['inventory.inventoriable', 'user'])
            ->whereHas('inventory', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->latest();

        // Filter by Type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by Category
        if ($request->filled('category_id')) {
            $categoryId = (int) $request->category_id;

            $query->whereHas('inventory', function ($inventoryQuery) use ($categoryId) {
                $inventoryQuery->whereHasMorph(
                    'inventoriable',
                    [RawMaterial::class],
                    function ($q) use ($categoryId) {
                        $q->where('inventory_category_id', $categoryId);
                    }
                );
            });
        }

        // Filter by Date Range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Clone query for statistics BEFORE pagination
        $statsQuery = clone $query;

        $stats = [
            'purchase' => (clone $statsQuery)->where('type', 'purchase')->sum('quantity'),
            'waste' => (clone $statsQuery)->where('type', 'waste')->sum(DB::raw('ABS(quantity)')), // Show positive for display
            'sale' => (clone $statsQuery)->where('type', 'sale')->sum(DB::raw('ABS(quantity)')),
            'adjustment' => (clone $statsQuery)->where('type', 'adjustment')->sum('quantity'),
            'count' => (clone $statsQuery)->count(),
        ];

        $movements = $query->paginate(20)->withQueryString();

        // Fetch categories for filter
        $categories = InventoryCategory::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.movements.index', compact('movements', 'categories', 'stats'));
    }
}
