<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            $categoryId = $request->category_id;
            $query->whereHas('inventory.inventoriable', function ($q) use ($categoryId) {
                // Check if the related model (Product) has this category_id
                if (method_exists($q->getModel(), 'category')) {
                     $q->where('category_id', $categoryId);
                }
            });
        }

        // Filter by Date Range
        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'week':
                    $query->where('created_at', '>=', Carbon::now()->subDays(7));
                    break;
                case '14days':
                    $query->where('created_at', '>=', Carbon::now()->subDays(14));
                    break;
                case '28days':
                    $query->where('created_at', '>=', Carbon::now()->subDays(28));
                    break;
                case '60days':
                    $query->where('created_at', '>=', Carbon::now()->subDays(60));
                    break;
                case 'custom':
                    if ($request->filled('start_date')) {
                        $query->whereDate('created_at', '>=', $request->start_date);
                    }
                    if ($request->filled('end_date')) {
                         $query->whereDate('created_at', '<=', $request->end_date);
                    }
                    break;
            }
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
        $categories = Category::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.movements.index', compact('movements', 'categories', 'stats'));
    }
}
