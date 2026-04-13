<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ShowDashboardService
{
    public function index(Request $request)
    {
        if (in_array(auth()->user()->role, ['user', 'cashier'])) {
            return redirect()->route('pos.index');
        }

        $filter = $request->get('filter', 'day');

        if ($filter === 'week') {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
            $format = 'D';
        } elseif ($filter === 'month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $format = 'd';
        } else {
            $startDate = Carbon::today();
            $endDate = Carbon::today();
            $format = 'd/m';
        }

        $orderCards = [
            [
                'title' => 'كل الطلبات',
                'key' => 'allOrdersChart',
                'type' => null,
                'source' => null,
            ],
            [
                'title' => 'طلبات التوصيل',
                'key' => 'deliveryChart',
                'type' => 'delivery',
                'source' => null,
            ],
            [
                'title' => 'طلبات الاستلام',
                'key' => 'pickupChart',
                'type' => 'takeaway',
                'source' => null,
            ],
            [
                'title' => 'الطلبات المحلية',
                'key' => 'localChart',
                'type' => 'local',
                'source' => null,
            ],
        ];

        foreach ($orderCards as &$card) {
            $labels = [];
            $data = [];

            $period = CarbonPeriod::create($startDate, $endDate);

            foreach ($period as $date) {
                $labels[] = $date->translatedFormat($format);

                $query = Order::where('user_id', auth()->id())
                    ->whereDate('created_at', $date->toDateString());

                if ($card['type']) {
                    if ($card['type'] === 'local') {
                        $query->whereIn('type', ['table', 'free_seating']);
                    } else {
                        $query->where('type', $card['type']);
                    }
                }

                if ($card['source']) {
                    $query->where('source', $card['source']);
                }

                $data[] = $query->count();
            }

            $totalQuery = Order::where('user_id', auth()->id());

            if ($card['type']) {
                if ($card['type'] === 'local') {
                    $totalQuery->whereIn('type', ['table', 'free_seating']);
                } else {
                    $totalQuery->where('type', $card['type']);
                }
            }

            if ($card['source']) {
                $totalQuery->where('source', $card['source']);
            }

            if ($filter === 'day') {
                $totalQuery->whereDate('created_at', Carbon::today());
            } elseif ($filter === 'week') {
                $totalQuery->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ]);
            } else {
                $totalQuery->whereBetween('created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                ]);
            }

            $card['labels'] = $labels;
            $card['data'] = $data;
            $card['value'] = $totalQuery->count();
        }

        return view('dashboard', compact('orderCards', 'filter'));
    }
}
